<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetupJurnalJualBeliResource\Pages;
use App\Filament\Resources\SetupJurnalJualBeliResource\RelationManagers;
use App\Models\SetupJurnalJualBeli;
use App\Models\ChartAccount;
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

class SetupJurnalJualBeliResource extends Resource
{
    protected static ?string $model = SetupJurnalJualBeli::class;

    protected static ?int $navigationSort = 21;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Setup Jurnal Jual Beli';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->columns(3)
                            ->schema([
                                Select::make('chart_account_id')
                                    ->label(__('COA'))
                                    ->relationship('sj_coa', 'nomoraccount')
                                    ->options(ChartAccount::where('tipeaccount', 'ANAK')->pluck('nomoraccount', 'id')->toArray())
                                    ->required()
                                    ->searchable(),
                                TextInput::make('namajurnal')
                                    ->label(label: __(key: 'Nama Jurnal')),
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
                Tables\Columns\TextColumn::make(name: 'sj_coa.nomoraccount')
                    ->label(__('COA'))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'namajurnal')
                    ->label(__('Nama Jurnal'))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'jenistransaksi')
                    ->label(__('Jenis Transaksi'))
                    ->searchable(),
                Tables\Columns\IconColumn::make(name: 'posisidebet')
                    ->label(__('Debit'))
                    ->boolean(),
                Tables\Columns\IconColumn::make(name: 'posisikredit')
                    ->label(__('Kredit'))
                    ->boolean()
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
                            ->body('Data Setup Jurnal Jual Beli berhasil diubah!')
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
                            ->body('Data Setup Jurnal Jual Beli berhasil dihapus!'),
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
            'index' => Pages\ListSetupJurnalJualBelis::route('/'),
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
