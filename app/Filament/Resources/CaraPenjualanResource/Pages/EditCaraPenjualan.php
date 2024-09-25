<?php

namespace App\Filament\Resources\CaraPenjualanResource\Pages;

use App\Filament\Resources\CaraPenjualanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCaraPenjualan extends EditRecord
{
    protected static string $resource = CaraPenjualanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
