<?php

namespace App\Filament\Resources\SetupJurnalJualBeliResource\Pages;

use App\Filament\Resources\SetupJurnalJualBeliResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSetupJurnalJualBelis extends ListRecords
{
    protected static string $resource = SetupJurnalJualBeliResource::class;

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
                        ->body('Data Setup Jurnal Jual Beli baru berhasil dibuat!')
                ),
        ];
    }
}
