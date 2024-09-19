<?php

namespace App\Filament\Resources\RekananResource\Pages;

use App\Filament\Resources\RekananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekanans extends ListRecords
{
    protected static string $resource = RekananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
