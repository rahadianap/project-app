<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Barang')
                    ->columns(2)
                    ->schema([
                        TextInput::make('kode')
                            ->label(__('Kode Barang'))
                            ->required()
                            ->disabled()
                            ->maxLength(30)
                            ->visibleOn(['view', 'edit']),
                        TextInput::make('kodebarcode')
                            ->label(__('Kode Barcode'))
                            ->numeric()
                            ->required()
                            ->maxLength(length: 30),
                        TextInput::make('nama')
                            ->label(__('Nama Barang'))
                            ->required()
                            ->maxLength(length: 100),
                        TextInput::make('namaalias')
                            ->label(__('Alias'))
                            ->maxLength(length: 100),
                        TextInput::make('merk')
                            ->label(__('Merk Barang'))
                            ->maxLength(length: 20),
                        Select::make('unit_id')
                            ->relationship('unit', 'nama')
                            ->label('Satuan')
                            ->searchable()
                            ->preload(),
                        Select::make('category_id')
                            ->relationship('category', 'nama')
                            ->label('Kategori')
                            ->searchable()
                            ->preload(),
                        TextInput::make('ukuran')
                            ->label(__('Ukuran'))
                            ->numeric()
                            ->suffix('gram')
                            ->maxLength(length: 20),
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label(__('Kode Barang'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('kodebarcode')
                    ->label(__('Barcode'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label(__('Nama Barang'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.nama')
                    ->label(__('Kategori'))
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
                Tables\Actions\RestoreAction::make()
                    ->after(function (Model $record): Model {
                        $record->update(['deleted_by' => null]);

                        return $record;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->color('success')
                            ->title('Restored Successfully')
                            ->body('Data Barang berhasil dipulihkan!'),
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
            RelationManagers\DetailsRelationManager::class,
            RelationManagers\RekanansRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
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
