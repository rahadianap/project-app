<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChartAccountResource\Pages;
use App\Filament\Resources\ChartAccountResource\RelationManagers;
use App\Models\ChartAccount;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChartAccountResource extends Resource
{
    protected static ?string $model = ChartAccount::class;



    protected static ?int $navigationSort = 10;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'COA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Fieldset::make('Data COA')
                            ->schema([
                                Grid::make()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('nomoraccount')
                                            ->label(__('Nomor Akun'))
                                            ->required(),
                                        TextInput::make('nama')
                                            ->label(__('Nama Akun'))
                                            ->required()
                                            ->maxLength(100),
                                        Select::make('kelompokaccount')
                                            ->relationship('group_coa', 'nama')
                                            ->label('Kelompok Akun')
                                            ->searchable()
                                            ->preload(),
                                        TextInput::make('level')
                                            ->label(__('Level Akun'))
                                            ->numeric()
                                            ->required(),
                                        Select::make('kasbank')
                                            ->label('Kas Bank')
                                            ->options([
                                                'T' => 'T',
                                                'Y' => 'Y'
                                            ]),
                                        Select::make('tipeaccount')
                                            ->label('Kelompok Akun')
                                            ->options([
                                                'INDUK' => 'INDUK',
                                                'ANAK' => 'ANAK'
                                            ]),
                                    ])
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomoraccount')
                    ->label(__(key: 'Nomor Akun'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label(__('Nama Akun'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'group_coa.nama')
                    ->label(__('Kelompok Akun')),
                Tables\Columns\TextColumn::make(name: 'tipeaccount')
                    ->label(__('Tipe Akun')),
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
                            ->body('Data COA berhasil dihapus!'),
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DetailsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChartAccounts::route('/'),
            'create' => Pages\CreateChartAccount::route('/create'),
            'view' => Pages\ViewChartAccount::route('/{record}'),
            'edit' => Pages\EditChartAccount::route('/{record}/edit'),
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
