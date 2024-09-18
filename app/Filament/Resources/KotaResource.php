<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KotaResource\Pages;
use App\Filament\Resources\KotaResource\RelationManagers;
use App\Models\Kota;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KotaResource extends Resource
{
    protected static ?string $model = Kota::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Kota / Kabupaten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('nama')
                                    ->label(__('Nama Kota'))
                                    ->required()
                                    ->maxLength(length: 25),
                                Select::make('provinsi_id')
                                    ->relationship('province', 'nama')
                                    ->label('Nama Provinsi')
                                    ->searchable()
                                    ->preload(),
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'nama')
                    ->label(__('Nama Kota'))
                    ->sortable()
                    ->searchable(),
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
                            ->body('Data Kota berhasil diubah!')
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
                            ->body('Data Kota berhasil dihapus!'),
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
            RelationManagers\DistrictsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKotas::route('/'),
            'view' => Pages\ViewKota::route('/{record}'),
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
