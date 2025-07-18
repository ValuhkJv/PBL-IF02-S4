<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use InvalidArgumentException;

class ShipmentService
{
    public function saveStep1Data(array $step1Data): void
    {
        Session::put('shipment_data', $step1Data);
    }

    public function saveStep2Data(array $step2Data): void
    {
        if (
            !isset($step2Data['paymentMethod']) ||
            $step2Data['paymentMethod'] === null ||
            $step2Data['paymentMethod'] === ''
        ) {
            throw new InvalidArgumentException('Payment method is required.');
        }

        $existing = Session::get('shipment_data', []);
        $merged = array_merge($existing, $step2Data);
        Session::put('shipment_data', $merged);
    }

    public function getFinalShipmentData(): array
    {
        return Session::get('shipment_data', []);
    }
}
