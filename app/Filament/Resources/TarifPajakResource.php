<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TarifPajakResource\Pages;
use App\Filament\Resources\TarifPajakResource\RelationManagers;
use App\Models\TarifPajak;
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
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Toggle;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TarifPajakResource extends Resource
{
    protected static ?string $model = TarifPajak::class;



    protected static ?string $slug = '/tarif-pajak';

    protected static ?int $navigationSort = 14;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Tarif Pajak';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Tarif Pajak')
                    ->collapsible(true)
                    ->schema([
                        Fieldset::make('Data Tarif Pajak')
                            ->schema([
                                Select::make('wilayah_id')
                                    ->relationship('wilayah', 'nama')
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
                                TextInput::make('ppn')
                                    ->label(__('PPN'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('ppnbm')
                                    ->label(__('PPNBM'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphfinal')
                                    ->label(__('PPH Final'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl21')
                                    ->label(__('PPH Pasal 21'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl22')
                                    ->label(__('PPH Pasal 22'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl23')
                                    ->label(__('PPH Pasal 23'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl24')
                                    ->label(__('PPH Pasal 24'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl25')
                                    ->label(__('PPH Pasal 25'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl26')
                                    ->label(__('PPH Pasal 26'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                TextInput::make('pphpsl29')
                                    ->label(__('PPH Pasal 29'))
                                    ->numeric()
                                    ->maxLength(length: 10),
                                Grid::make()->schema(components: [
                                    Toggle::make('is_journal')
                                        ->label(__('Upload Jurnal')),
                                ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'wilayah.nama')
                    ->label(__('Wilayah'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'ppn')
                    ->label(__('PPN'))
                    ->suffix(' %'),
                Tables\Columns\TextColumn::make(name: 'ppnbm')
                    ->label(__('PPNBM'))
                    ->suffix(' %'),
                Tables\Columns\TextColumn::make(name: 'pphfinal')
                    ->label(__('PPH Final'))
                    ->suffix(' %'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->sortable()
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
                            ->body('Data Tarif Pajak berhasil diubah!')
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
                            ->body('Data Tarif Pajak berhasil dihapus!'),
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
            'index' => Pages\ListTarifPajaks::route('/'),
            'create' => Pages\CreateTarifPajak::route('/create'),
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
