<?php

namespace App\Filament\Resources\SetupAccountResource\Pages;

use App\Filament\Resources\SetupAccountResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListSetupAccounts extends ListRecords
{
    protected static string $resource = SetupAccountResource::class;

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
                        ->body('Data Setup Account baru berhasil dibuat!')
                ),
        ];
    }
}
