<?php

namespace App\Filament\Resources\GroupRekananResource\Pages;

use App\Filament\Resources\GroupRekananResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGroupRekanan extends ViewRecord
{
    protected static string $resource = GroupRekananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
