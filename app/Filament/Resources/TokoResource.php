<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TokoResource\Pages;
use App\Filament\Resources\TokoResource\RelationManagers;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TokoResource extends Resource
{
    protected static ?string $model = Toko::class;

    protected static ?string $slug = '/toko';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 13;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Toko';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Toko')
                    ->collapsible(true)
                    ->schema([
                        Fieldset::make('Data Toko')
                            ->schema([
                                TextInput::make('kode')
                                    ->label(__('Kode Barang'))
                                    ->required()
                                    ->disabled()
                                    ->maxLength(30)
                                    ->visibleOn(['view', 'edit']),
                                Select::make('wilayah_id')
                                    ->relationship('region', 'nama')
                                    ->label('Wilayah')
                                    ->searchable()
                                    ->preload(),
                                TextInput::make('npwp')
                                    ->label(__('NPWP'))
                                    ->maxLength(length: 30),
                                TextInput::make('nama')
                                    ->label(__('Nama Toko'))
                                    ->required()
                                    ->maxLength(length: 100),
                                TextInput::make('alamat')
                                    ->label(__('Alamat Toko')),
                                DatePicker::make('tgl_pengukuhan')
                                    ->label(__('Tanggal Pengukuhan'))
                                    ->maxDate(now()),
                                TextInput::make('notelepon')
                                    ->label(__('Nomor Telepon'))
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->maxLength(length: 15),
                                TextInput::make('nowa')
                                    ->label(__('Nomor WA'))
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->maxLength(length: 15),
                                TextInput::make('email')
                                    ->label(__('Email'))
                                    ->email()
                                    ->maxLength(length: 50),
                                TextInput::make('fb')
                                    ->label(__('Akun FB'))
                                    ->maxLength(length: 50),
                                TextInput::make('ig')
                                    ->label(__('Akun IG'))
                                    ->maxLength(length: 50),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label(__('Kode Toko'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label(__('Nama Toko'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('region.nama')
                    ->label(__('Wilayah'))
                    ->sortable()
                    ->searchable(),
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
                            ->body('Data Barang berhasil dihapus!'),
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
            'index' => Pages\ListTokos::route('/'),
            'create' => Pages\CreateToko::route('/create'),
            'view' => Pages\ViewToko::route('/{record}'),
            'edit' => Pages\EditToko::route('/{record}/edit'),
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
