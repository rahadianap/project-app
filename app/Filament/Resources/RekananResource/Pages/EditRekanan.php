<?php

namespace App\Filament\Resources\RekananResource\Pages;

use App\Filament\Resources\RekananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditRekanan extends EditRecord
{
    protected static string $resource = RekananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color('success')
            ->title('Updated Successfully')
            ->body('Data Rekanan berhasil diubah!');
    }
}
