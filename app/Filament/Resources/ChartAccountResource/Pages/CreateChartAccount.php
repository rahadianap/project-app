<?php

namespace App\Filament\Resources\ChartAccountResource\Pages;

use App\Filament\Resources\ChartAccountResource;
use App\Models\DetailChartAccount;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;

class CreateChartAccount extends CreateRecord
{
    protected static string $resource = ChartAccountResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data COA baru berhasil dibuat!');
    }
}
