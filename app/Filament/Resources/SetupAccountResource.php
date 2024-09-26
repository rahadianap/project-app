<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetupAccountResource\Pages;
use App\Filament\Resources\SetupAccountResource\RelationManagers;
use App\Models\ChartAccount;
use App\Models\SetupAccount;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SetupAccountResource extends Resource
{
    protected static ?string $model = SetupAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->columns(2)
                            ->schema([
                                Select::make('chart_account_id')
                                    ->label(__('COA'))
                                    ->relationship('sa_coa', 'nomoraccount')
                                    ->options(ChartAccount::where('tipeaccount', 'ANAK')->pluck('nomoraccount', 'id')->toArray())
                                    ->required()
                                    ->searchable(),
                                TextInput::make('jenistransaksi')
                                    ->label(label: __('Jenis Transaksi')),
                                Checkbox::make('posisidebet')
                                    ->label(__('Debit')),
                                Checkbox::make('posisikredit')
                                    ->label(__('Kredit')),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'sa_coa.nomoraccount')
                    ->label(__('COA'))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'jenistransaksi')
                    ->label(__('Jenis Transaksi'))
                    ->searchable(),
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
                            ->body('Data Setup Account berhasil diubah!')
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
                            ->body('Data Setup Account berhasil dihapus!'),
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
            'index' => Pages\ListSetupAccounts::route('/'),
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
