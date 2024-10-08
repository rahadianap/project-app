<?php

namespace App\Filament\Resources\TarifPajakResource\Pages;

use App\Filament\Resources\TarifPajakResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class CreateTarifPajak extends CreateRecord
{
    protected static string $resource = TarifPajakResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $nextAutoIncrement = TarifPajakResource::getModel()::max('id') + 1;
        $data['penanda'] = $nextAutoIncrement;
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data Tarif Pajak baru berhasil dibuat!');
    }
}
