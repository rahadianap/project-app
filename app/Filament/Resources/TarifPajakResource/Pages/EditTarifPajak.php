<?php

namespace App\Filament\Resources\TarifPajakResource\Pages;

use App\Filament\Resources\TarifPajakResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTarifPajak extends EditRecord
{
    protected static string $resource = TarifPajakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
