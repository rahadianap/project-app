<?php

namespace App\Filament\Resources\SetupJurnalJualBeliResource\Pages;

use App\Filament\Resources\SetupJurnalJualBeliResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSetupJurnalJualBeli extends EditRecord
{
    protected static string $resource = SetupJurnalJualBeliResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
