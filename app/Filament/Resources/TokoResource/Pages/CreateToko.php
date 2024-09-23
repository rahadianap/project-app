<?php

namespace App\Filament\Resources\TokoResource\Pages;

use App\Filament\Resources\TokoResource;
use Filament\Actions;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateToko extends CreateRecord
{
    protected static string $resource = TokoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['kode'] = IdGenerator::generate(['table' => 'msttoko', 'field' => 'kode', 'length' => 6, 'prefix' => 'TK-']);
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data Toko baru berhasil dibuat!');
    }
}
