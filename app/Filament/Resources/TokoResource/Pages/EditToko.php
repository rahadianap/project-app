<?php

namespace App\Filament\Resources\TokoResource\Pages;

use App\Filament\Resources\TokoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditToko extends EditRecord
{
    protected static string $resource = TokoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
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
            ->body('Data Toko berhasil diubah!');
    }
}
