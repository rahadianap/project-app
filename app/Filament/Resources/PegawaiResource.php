<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;



    protected static ?string $slug = '/pegawai';

    protected static ?int $navigationSort = 18;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Pegawai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Pegawai')
                    ->collapsible(true)
                    ->schema([
                        Fieldset::make('Data Diri Pegawai')
                            ->schema([
                                Grid::make()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('kode')
                                            ->label(__('Kode Pegawai'))
                                            ->required()
                                            ->disabled()
                                            ->maxLength(30)
                                            ->visibleOn(['view', 'edit']),
                                        TextInput::make('nama')
                                            ->label(__('Nama Pegawai'))
                                            ->required()
                                            ->maxLength(length: 100),
                                        TextInput::make('alamat')
                                            ->label(__('Alamat')),
                                        DatePicker::make('tgl_lahir')
                                            ->label(__('Tanggal Lahir'))
                                            ->maxDate(now())
                                    ]),
                                DatePicker::make('tgl_gabung')
                                    ->label(__('Tanggal Gabung'))
                                    ->maxDate(now()),
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
                            ]),
                        Fieldset::make('Data Pekerjaan')
                            ->schema([
                                Grid::make()
                                    ->columns(4)
                                    ->schema([
                                        Select::make('wilayah_id')
                                            ->relationship('pgw_wilayah', 'nama')
                                            ->label('Wilayah')
                                            ->reactive()
                                            ->searchable()
                                            ->afterStateUpdated(fn(callable $set): mixed => $set('toko_id', null))
                                            ->preload(),
                                        Select::make('toko_id')
                                            ->options(function (Forms\Get $get) {
                                                return Toko::where('wilayah_id', $get('wilayah_id'))->pluck('nama', 'id')->toArray();
                                            })
                                            ->label('Toko')
                                            ->searchable(),
                                        Select::make('departemen_id')
                                            ->relationship('pgw_departemen', 'nama')
                                            ->label('Departemen')
                                            ->searchable()
                                            ->preload(),
                                        Select::make('jabatan_id')
                                            ->relationship('pgw_jabatan', 'nama')
                                            ->label('Jabatan')
                                            ->searchable()
                                            ->preload(),
                                    ])
                            ])
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'kode')
                    ->label(__('Kode Pegawai'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'nama')
                    ->label(__('Nama Pegawai'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'pgw_jabatan.nama')
                    ->label(__('Jabatan'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
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
                            ->body('Data Pegawai berhasil dihapus!'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
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
