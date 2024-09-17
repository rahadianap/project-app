<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\DetailProduct;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

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
}