<?php

namespace App\Filament\Resources\WilayahResource\Pages;

use App\Filament\Resources\WilayahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class ListWilayahs extends ListRecords
{
    protected static string $resource = WilayahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['kode'] = IdGenerator::generate(['table' => 'mstwilayah', 'field' => 'kode', 'length' => 5, 'prefix' => 'RG-']);
                    $data['created_by'] = Auth() ? Auth()->user()->name : null;
                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->color(color: 'success')
                        ->title('Created Successfully')
                        ->body('Data Wilayah baru berhasil dibuat!')
                ),
        ];
    }
}
