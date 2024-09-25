<?php

namespace App\Filament\Resources\HakKasBankResource\Pages;

use App\Filament\Resources\HakKasBankResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListHakKasBanks extends ListRecords
{
    protected static string $resource = HakKasBankResource::class;

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
                        ->body('Data Hak Kas Bank baru berhasil dibuat!')
                ),
        ];
    }
}
