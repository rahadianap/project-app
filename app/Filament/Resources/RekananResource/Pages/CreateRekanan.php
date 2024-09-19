<?php

namespace App\Filament\Resources\RekananResource\Pages;

use App\Filament\Resources\RekananResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class CreateRekanan extends CreateRecord
{
    protected static string $resource = RekananResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['kode'] = IdGenerator::generate(['table' => 'mstrekanan', 'field' => 'kode', 'length' => 8, 'prefix' => 'CLG-']);
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data Rekanan baru berhasil dibuat!');
    }
}
