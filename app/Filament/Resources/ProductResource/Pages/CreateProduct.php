<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['kode'] = IdGenerator::generate(['table' => 'mstbarang', 'field' => 'kode', 'length' => 8, 'prefix' => 'PRD-']);
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data Barang baru berhasil dibuat!');
    }
}
