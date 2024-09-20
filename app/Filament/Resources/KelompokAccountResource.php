<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelompokAccountResource\Pages;
use App\Filament\Resources\KelompokAccountResource\RelationManagers;
use App\Models\KelompokAccount;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelompokAccountResource extends Resource
{
    protected static ?string $model = KelompokAccount::class;

    protected static ?int $navigationSort = 11;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Kelompok COA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Kelompok Akun')
                    ->schema([
                        Grid::make()
                            ->columns(3)
                            ->schema([
                                TextInput::make('kode')
                                    ->label(__('Kode Kelompok'))
                                    ->required()
                                    ->disabled()
                                    ->maxLength(30)
                                    ->visibleOn(['view', 'edit']),
                                Select::make('kelompok')
                                    ->label('Kelompok')
                                    ->options([
                                        'AKTIVA' => 'AKTIVA',
                                        'PASIVA' => 'PASIVA',
                                        'MODAL' => 'MODAL',
                                        'PENDAPATAN' => 'PENDAPATAN',
                                        'RETUR' => 'RETUR',
                                        'BIAYA' => 'BIAYA',
                                    ]),
                                TextInput::make('nama')
                                    ->label(__('Nama Kelompok'))
                                    ->required()
                                    ->maxLength(length: 30),
                                Grid::make()
                                    ->schema([
                                        Checkbox::make('debit')
                                            ->label(__('Debit')),
                                    ]),
                                Grid::make()
                                    ->schema([
                                        Checkbox::make('kredit')
                                            ->label(__('Kredit')),
                                    ])
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'kode')
                    ->label(__(key: 'Kode Kelompok'))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'kelompok')
                    ->label(__(key: 'Kelompok'))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'nama')
                    ->label(__(key: 'Nama Kelompok'))
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\RestoreAction::make()
                    ->after(function (Model $record): Model {
                        $record->update(['deleted_by' => null]);

                        return $record;
                    }),
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['updated_by'] = Auth() ? Auth()->user()->name : null;

                        return $data;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->color(color: 'success')
                            ->title('Updated Successfully')
                            ->body('Data Kelompok Akun berhasil diubah!')
                    ),
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
                            ->body('Data Kelompok Akun berhasil dihapus!'),
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
            'index' => Pages\ListKelompokAccounts::route('/'),
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
