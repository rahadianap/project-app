<?php

namespace App\Filament\Resources\SetupAccountResource\Pages;

use App\Filament\Resources\SetupAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetupAccount extends EditRecord
{
    protected static string $resource = SetupAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
