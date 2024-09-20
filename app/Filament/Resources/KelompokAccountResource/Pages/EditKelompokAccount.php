<?php

namespace App\Filament\Resources\KelompokAccountResource\Pages;

use App\Filament\Resources\KelompokAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKelompokAccount extends EditRecord
{
    protected static string $resource = KelompokAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
