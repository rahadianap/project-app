<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekananResource\Pages;
use App\Filament\Resources\RekananResource\RelationManagers;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Kota;
use App\Models\Provinsi;
use App\Models\Rekanan;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekananResource extends Resource
{
    protected static ?string $model = Rekanan::class;



    protected static ?int $navigationSort = 8;

    protected static ?string $navigationLabel = 'Rekanan';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Rekanan')
                    ->collapsible(true)
                    ->schema([
                        Fieldset::make('Data Rekanan')
                            ->schema([
                                TextInput::make('kode')
                                    ->label(__('Kode Rekanan'))
                                    ->required()
                                    ->disabled()
                                    ->maxLength(30)
                                    ->visibleOn(['view', 'edit']),
                                TextInput::make('no_ktp')
                                    ->label(__('Nomor KTP'))
                                    ->numeric()
                                    ->required()
                                    ->minLength(length: 16),
                                TextInput::make('npwp')
                                    ->label(__('Nomor NPWP'))
                                    ->maxLength(length: 30),
                                TextInput::make('nama')
                                    ->label(__('Nama Rekanan'))
                                    ->required(),
                                DatePicker::make('tgl_lahir')
                                    ->label(__('Tanggal Lahir'))
                                    ->minDate(now()->subYears(150))
                                    ->maxDate(now())
                                    ->format('d-m-Y'),
                                TextInput::make('no_hp1')
                                    ->label(__('Nomor HP 1'))
                                    ->tel()
                                    ->required(),
                                TextInput::make('no_hp2')
                                    ->label(__('Nomor HP 2'))
                                    ->tel(),
                                TextInput::make('email')
                                    ->label(__('Email'))
                                    ->email(),
                                Select::make('group_id')
                                    ->relationship('group', 'nama')
                                    ->label('Group Rekanan')
                                    ->searchable()
                                    ->preload(),
                                Grid::make()
                                    ->columns(3)
                                    ->schema([
                                        Select::make('agama')
                                            ->label(__('Agama'))
                                            ->options([
                                                'Islam' => 'Islam',
                                                'Katolik' => 'Katolik',
                                                'Protestan' => 'Protestan',
                                                'Hindu' => 'Hindu',
                                                'Buddha' => 'Buddha',
                                                'Konghucu' => 'Konghucu',
                                                'Lainnya' => 'Lainnya'
                                            ])
                                            ->searchable(),
                                        Select::make('pendidikan')
                                            ->label(__('Pendidikan'))
                                            ->options([
                                                'SD' => 'SD',
                                                'SMP' => 'SMP',
                                                'SMA' => 'SMA',
                                                'Diploma' => 'Diploma',
                                                'Sarjana' => 'Sarjana'
                                            ])
                                            ->searchable(),
                                        Select::make('pekerjaan')
                                            ->label(__('Pekerjaan'))
                                            ->options([
                                                'Swasta' => 'Swasta',
                                                'BUMN' => 'BUMN',
                                                'PNS' => 'PNS',
                                                'IRT' => 'IRT'
                                            ])
                                            ->searchable(),
                                    ]),
                                TextInput::make('keterangan')
                                    ->label(__('Keterangan'))
                                    ->columnSpanFull(),
                            ]),
                        Fieldset::make('Alamat Rekanan')
                            ->schema([
                                Grid::make()
                                    ->columns(4)
                                    ->schema([
                                        Select::make('provinsi_id')
                                            ->label(__('Provinsi'))
                                            ->options(Provinsi::pluck('nama', 'id')->toArray())
                                            ->reactive()
                                            ->searchable()
                                            ->preload()
                                            ->afterStateUpdated(fn(callable $set) => $set('kota_id', null)),
                                        Select::make('kota_id')
                                            ->label(__('Kota'))
                                            ->options(function (Forms\Get $get) {
                                                return Kota::where('provinsi_id', $get('provinsi_id'))->pluck('nama', 'id')->toArray();
                                            })
                                            ->reactive()
                                            ->searchable()
                                            ->afterStateUpdated(fn(callable $set) => $set('kecamatan_id', null)),
                                        Select::make('kecamatan_id')
                                            ->label(__('Kecamatan'))
                                            ->options(function (Forms\Get $get) {
                                                return Kecamatan::where('kota_id', $get('kota_id'))->pluck('nama', 'id')->toArray();
                                            })
                                            ->reactive()
                                            ->searchable()
                                            ->afterStateUpdated(fn(callable $set): mixed => $set('kelurahan_id', null)),
                                        Select::make('kelurahan_id')
                                            ->label(__('Kelurahan'))
                                            ->options(function (Forms\Get $get) {
                                                return Kelurahan::where('kecamatan_id', $get('kecamatan_id'))->pluck('nama', 'id')->toArray();
                                            })
                                            ->searchable(),
                                    ]),
                                TextInput::make('alamat')
                                    ->label(__('Alamat Rekanan'))
                                    ->columnSpanFull(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'nama')
                    ->label(__('Nama Rekanan'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'group.nama')
                    ->label(__('Group Rekanan')),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->after(function (Model $record): Model {
                        $record->update(['updated_by' => Auth() ? Auth()->user()->name : null]);

                        return $record;
                    })
                ,
                Tables\Actions\DeleteAction::make()
                    ->after(function (Model $record): Model {
                        $record->update(['deleted_by' => Auth() ? Auth()->user()->name : null]);

                        return $record;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->color('danger')
                            ->title('Deleted Successfully')
                            ->body('Data Rekanan berhasil dihapus!'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRekanans::route('/'),
            'create' => Pages\CreateRekanan::route('/create'),
            'view' => Pages\ViewRekanan::route('/{record}'),
            'edit' => Pages\EditRekanan::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
