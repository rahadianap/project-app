<?php

namespace App\Filament\Resources\UnitResource\Pages;

use App\Filament\Resources\UnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListUnits extends ListRecords
{
    protected static string $resource = UnitResource::class;

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
                        ->body('Data Satuan baru berhasil dibuat!')
                ),
        ];
    }
}
