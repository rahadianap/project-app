<?php

namespace App\Filament\Resources\GroupRekananResource\Pages;

use App\Filament\Resources\GroupRekananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupRekanan extends EditRecord
{
    protected static string $resource = GroupRekananResource::class;

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
