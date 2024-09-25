<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HakKasBankResource\Pages;
use App\Filament\Resources\HakKasBankResource\RelationManagers;
use App\Models\HakKasBank;
use App\Models\Toko;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Card;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HakKasBankResource extends Resource
{
    protected static ?string $model = HakKasBank::class;



    protected static ?string $slug = '/hak-kas-bank';

    protected static ?int $navigationSort = 16;

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Hak Kas Bank';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('pegawai_id')
                                    ->relationship('hkb_pegawai', 'nama')
                                    ->label('Nama Pegawai')
                                    ->searchable()
                                    ->preload(),
                                Select::make('chart_account_id')
                                    ->relationship('hkb_coa', titleAttribute: 'nama')
                                    ->label('Hak COA')
                                    ->searchable()
                                    ->preload(),
                                Select::make('wilayah_id')
                                    ->relationship('hkb_wilayah', 'nama')
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
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'hkb_pegawai.nama')
                    ->label(__('Nama Pegawai'))
                    ->searchable(),
                Tables\Columns\TextColumn::make(name: 'hkb_coa.nama')
                    ->label(__('Hak COA'))
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
                            ->body('Data Hak Kas Bank berhasil diubah!')
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
                            ->body('Data Hak Kas Bank berhasil dihapus!'),
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
            'index' => Pages\ListHakKasBanks::route('/'),
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
