<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $inverseRelationship = 'barang';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kodetoko')
                    ->label(__('Kode Toko'))
                    ->maxLength(length: 100),
                TextInput::make('kodewilayah')
                    ->label(__('Kode Wilayah'))
                    ->maxLength(length: 100),
                TextInput::make('saldoawal')
                    ->label(__('Saldo Awal'))
                    ->numeric(),
                Grid::make()
                    ->schema([
                        MoneyInput::make('hargajualkarton')
                            ->label(__('Harga Jual (Karton)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargajualeceran')
                            ->label(__('Harga Jual (Eceran)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargabelikarton')
                            ->label(__('Harga Beli (Karton)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargabelieceran')
                            ->label(__('Harga Beli (Eceran)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargapokokavgkarton')
                            ->label(__('Harga Pokok Avg (Karton)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargapokokavgeceran')
                            ->label(__('Harga Pokok Avg (Eceran)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargapokokfifokarton')
                            ->label(__('Harga Pokok FIFO (Karton)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0),
                        MoneyInput::make('hargapokokfifoeceran')
                            ->label(__('Harga Pokok FIFO (Eceran)'))
                            ->currency('IDR')
                            ->locale('id_ID')
                            ->minValue(0)
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('kodetoko')
                    ->label('Kode Toko'),
                Tables\Columns\TextColumn::make('kodewilayah')
                    ->label('Kode Wilayah'),
                Tables\Columns\TextColumn::make('saldoawal')
                    ->label('Saldo Awal'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
