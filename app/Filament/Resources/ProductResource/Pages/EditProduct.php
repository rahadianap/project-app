<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\DetailProduct;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $detail = DetailProduct::find($data['id']);

        $data['kodetoko'] = $detail->kodetoko;
        $data['kodewilayah'] = $detail->kodewilayah;
        $data['saldoawal'] = $detail->saldoawal;
        $data['hargajualkarton'] = $detail->hargajualkarton;
        $data['hargajualeceran'] = $detail->hargajualeceran;
        $data['hargabelikarton'] = $detail->hargabelikarton;
        $data['hargabelieceran'] = $detail->hargabelieceran;
        $data['hargapokokavgkarton'] = $detail->hargapokokavgkarton;
        $data['hargapokokavgeceran'] = $detail->hargapokokavgeceran;
        $data['hargapokokfifokarton'] = $detail->hargapokokfifokarton;
        $data['hargapokokfifoeceran'] = $detail->hargapokokfifoeceran;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $detail = DetailProduct::find($record['id']);

        $detail->update($data);
        $record->update($data);

        return $record;
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color('success')
            ->title('Updated Successfully')
            ->body('Data Barang berhasil diubah!');
    }
}
