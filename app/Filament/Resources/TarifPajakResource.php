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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                                Grid::make()->schema([
                                    Toggle::make('pajak')
                                        ->label(__('Barang Kena Pajak'))
                                        ->required(),
                                    Toggle::make('isaktif')
                                        ->label(__('Barang Aktif'))
                                        ->default(1)
                                        ->required(),
                                ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'edit' => Pages\EditTarifPajak::route('/{record}/edit'),
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
