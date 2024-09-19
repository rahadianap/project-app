<?php

namespace App\Filament\Resources\GroupRekananResource\Pages;

use App\Filament\Resources\GroupRekananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;

class ListGroupRekanans extends ListRecords
{
    protected static string $resource = GroupRekananResource::class;

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
                        ->body('Data Group Rekanan baru berhasil dibuat!')
                ),
        ];
    }
}
