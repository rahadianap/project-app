<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use App\Models\DetailProduct;
use Filament\Resources\Pages\CreateRecord;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Get;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        $detail = new DetailProduct();
        $detail->kodetoko = $data['kodetoko'];
        $detail->kodewilayah = $data['kodewilayah'];
        $detail->saldoawal = $data['saldoawal'];
        $detail->hargajualkarton = $data['hargajualkarton'];
        $detail->hargajualeceran = $data['hargajualeceran'];
        $detail->hargabelikarton = $data['hargabelikarton'];
        $detail->hargabelieceran = $data['hargabelieceran'];
        $detail->hargapokokavgkarton = $data['hargapokokavgkarton'];
        $detail->hargapokokavgeceran = $data['hargapokokavgeceran'];
        $detail->hargapokokfifokarton = $data['hargapokokfifokarton'];
        $detail->hargapokokfifoeceran = $data['hargapokokfifoeceran'];
        $detail->created_by = Auth() ? Auth()->user()->name : null;

        $detail->kode = $record->kode;

        $detail->save();

        return $record;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['kode'] = IdGenerator::generate(['table' => 'mstbarang', 'field' => 'kode', 'length' => 8, 'prefix' => 'PRD-']);
        $data['created_by'] = Auth() ? Auth()->user()->name : null;
        return $data;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->color(color: 'success')
            ->title('Created Successfully')
            ->body('Data Barang baru berhasil dibuat!');
    }
}
