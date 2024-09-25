<?php

namespace App\Filament\Resources\PegawaiResource\Pages;

use App\Filament\Resources\PegawaiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;

class CreatePegawai extends CreateRecord
{
    protected static string $resource = PegawaiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['kode'] = IdGenerator::generate(['table' => 'mstpegawai', 'field' => 'kode', 'length' => 8, 'prefix' => 'PGW-']);
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data Pegawai baru berhasil dibuat!');
    }
}
