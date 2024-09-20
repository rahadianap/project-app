<?php

namespace App\Filament\Resources\ChartAccountResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class DetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'details';

    protected static ?string $inverseRelationship = 'coa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nomoraccount')
                    ->label(__('Nomor Akun'))
                    ->required()
                    ->disabled()
                    ->maxLength(30)
                    ->visibleOn(['view', 'edit']),
                Select::make('posisi')
                    ->label('Posisi Akun')
                    ->options([
                        'D' => 'Debit',
                        'K' => 'Kredit'
                    ]),
                TextInput::make(name: 'kodetoko')
                    ->label(__('Kode Toko')),
                TextInput::make(name: 'kodewilayah')
                    ->label(__('Kode Wilayah')),
                MoneyInput::make('saldoawal')
                    ->label(__(key: 'Saldo Awal'))
                    ->currency('IDR')
                    ->locale('id_ID')
                    ->minValue(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nomoraccount')
            ->columns([
                Tables\Columns\TextColumn::make('chart_account_id')
                    ->label(__('Nomor Akun')),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
