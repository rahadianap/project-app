<?php

namespace App\Filament\Resources\DepartemenResource\Pages;

use App\Filament\Resources\DepartemenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class ListDepartemens extends ListRecords
{
    protected static string $resource = DepartemenResource::class;

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
                        ->body('Data Departemen baru berhasil dibuat!')
                ),
        ];
    }
}
