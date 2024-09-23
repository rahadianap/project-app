<?php

namespace App\Filament\Resources\TarifPajakResource\Pages;

use App\Filament\Resources\TarifPajakResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTarifPajaks extends ListRecords
{
    protected static string $resource = TarifPajakResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
