<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use App\Models\Wilayah;
use Filament\Forms;
use App\Models\Toko;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
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
                Select::make('wilayah_id')
                    ->label('Wilayah')
                    ->relationship('db_wilayah', 'nama')
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
                TextInput::make('saldoawal')
                    ->label(__('Saldo Awal'))
                    ->prefix('Rp.')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Grid::make()
                    ->schema([
                        TextInput::make('hargajualkarton')
                            ->label(__('Harga Jual (Karton)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargajualeceran')
                            ->label(__('Harga Jual (Eceran)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargabelikarton')
                            ->label(__('Harga Beli (Karton)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargabelieceran')
                            ->label(__('Harga Beli (Eceran)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargapokokavgkarton')
                            ->label(__('Harga Pokok Avg (Karton)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargapokokavgeceran')
                            ->label(__('Harga Pokok Avg (Eceran)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargapokokfifokarton')
                            ->label(__('Harga Pokok FIFO (Karton)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                        TextInput::make('hargapokokfifoeceran')
                            ->label(__('Harga Pokok FIFO (Eceran)'))
                            ->prefix('Rp.')
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->numeric(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product_id')
            ->columns([
                Tables\Columns\TextColumn::make('db_wilayah.nama')
                    ->label('Kode Wilayah'),
                Tables\Columns\TextColumn::make('db_toko.nama')
                    ->label('Kode Toko'),
                Tables\Columns\TextColumn::make('saldoawal')
                    ->label('Saldo Awal'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = Auth() ? Auth()->user()->name : null;

                        return $data;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->color(color: 'success')
                            ->title('Created Successfully')
                            ->body('Data Detail Barang baru berhasil dibuat!')
                    )
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
                            ->body('Data Detail Barang baru berhasil diubah!')
                    ),
                Tables\Actions\DeleteAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['deleted_by'] = Auth() ? Auth()->user()->name : null;

                        return $data;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->color(color: 'success')
                            ->title('Deleted Successfully')
                            ->body('Data Detail Barang baru berhasil dihapus!')
                    ),
                Tables\Actions\RestoreAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['deleted_by'] = null;

                        return $data;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->color(color: 'success')
                            ->title('Restored Successfully')
                            ->body('Data Detail Barang baru berhasil dipulihkan!')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
