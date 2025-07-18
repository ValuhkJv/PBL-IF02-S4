<?php

namespace App\Services;

use App\Models\Shipment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use InvalidArgumentException;

class StatusService
{
    public function updateStatus(Shipment $shipment, array $data)
    {
        if (empty($data['currentStatus'])) {
            throw new InvalidArgumentException('Status is required.');
        }

        if ($data['currentStatus'] === 'Pesanan Selesai' && empty($data['delivery_proof'])) {
            throw new InvalidArgumentException('Delivery proof is required.');
        }

        $shipment->currentStatus = $data['currentStatus'];

        if (!empty($data['delivery_proof'])) {
            $file = $data['delivery_proof'];
            $path = $file->store('delivery_proofs', 'public');
            $shipment->delivery_proof = $path;
        }

        $shipment->save();

        return $shipment;
    }
}
