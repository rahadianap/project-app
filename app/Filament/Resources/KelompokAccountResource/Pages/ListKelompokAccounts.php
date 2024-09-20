<?php

namespace App\Filament\Resources\KelompokAccountResource\Pages;

use App\Filament\Resources\KelompokAccountResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Resources\Pages\ListRecords;

class ListKelompokAccounts extends ListRecords
{
    protected static string $resource = KelompokAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['kode'] = IdGenerator::generate(['table' => 'mstkelompokaccount', 'field' => 'kode', 'length' => 2, 'prefix' => '0']);
                    $data['created_by'] = Auth() ? Auth()->user()->name : null;

                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->color(color: 'success')
                        ->title('Created Successfully')
                        ->body('Data Kelompok Akun baru berhasil dibuat!')
                ),
        ];
    }
}
