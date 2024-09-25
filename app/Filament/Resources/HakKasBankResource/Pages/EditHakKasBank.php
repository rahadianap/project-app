<?php

namespace App\Filament\Resources\HakKasBankResource\Pages;

use App\Filament\Resources\HakKasBankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHakKasBank extends EditRecord
{
    protected static string $resource = HakKasBankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
