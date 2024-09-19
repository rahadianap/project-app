<?php

namespace App\Filament\Resources\RekananResource\Pages;

use App\Filament\Resources\RekananResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRekanan extends ViewRecord
{
    protected static string $resource = RekananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
