<?php

namespace App\Filament\Resources\CaraPenjualanResource\Pages;

use App\Filament\Resources\CaraPenjualanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListCaraPenjualans extends ListRecords
{
    protected static string $resource = CaraPenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['created_by'] = Auth() ? Auth()->user()->name : null;
                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->color(color: 'success')
                        ->title('Created Successfully')
                        ->body('Data Cara Penjualan baru berhasil dibuat!')
                )
        ];
    }
}
