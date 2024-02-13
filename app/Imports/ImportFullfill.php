<?php

namespace App\Imports;

use App\Models\ImportFullfillOrder;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportFullfill implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['barcode'] != null && $row['trackingid'] != null && $row['trackingurl'] != null) {
            $chec = ImportFullfillOrder::where('Barcode', $row['barcode'])->first();
            if ($chec == null) {
                return new ImportFullfillOrder([
                    'barcode'     => $row['barcode'],
                    'trackingid'    => $row['trackingid'],
                    'tracking_url' => $row['trackingurl'],
                ]);
            }
        }
    }
}
