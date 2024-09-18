<?php

namespace App\Filament\Resources\KecamatanResource\Pages;

use App\Filament\Resources\KecamatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListKecamatans extends ListRecords
{
    protected static string $resource = KecamatanResource::class;

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
                        ->color(color: 'ijo')
                        ->title('Created Successfully')
                        ->body('Data Kecamatan baru berhasil dibuat!')
                ),
        ];
    }
}
