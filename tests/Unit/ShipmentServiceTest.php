<?php

namespace Tests\Unit;

use App\Services\ShipmentService;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use InvalidArgumentException;

class ShipmentServiceTest extends TestCase
{
    /** ✅ Test sukses Step 1 */
    public function test_it_saves_step1_data_to_session()
    {
        $step1 = [
            'pickupAddress' => 'Jl. Contoh 123',
            'pickupLatitude' => '1.1234567',
            'pickupLongitude' => '104.1234567',
            'receiverName' => 'Nama Penerima',
            'receiverPhoneNumber' => '81234567890',
            'receiverAddress' => 'Jl. Tujuan 456',
            'receiverLatitude' => '1.2234567',
            'receiverLongitude' => '104.2234567',
            'itemType' => 'Dokumen',
            'weightKG' => 2.5,
            'notes' => 'Jangan dibanting',
        ];

        Session::shouldReceive('put')
            ->once()
            ->with('shipment_data', $step1);

        $service = new ShipmentService();
        $service->saveStep1Data($step1);

        $this->assertTrue(true);
    }

    /** ✅ Test sukses Step 2 */
    public function test_it_merges_step2_data_into_existing_session()
    {
        $existing = [
            'pickupAddress' => 'Jl. Contoh 123',
        ];

        $step2 = [
            'paymentMethod' => 'cod',
        ];

        $expected = array_merge($existing, $step2);

        Session::shouldReceive('get')
            ->with('shipment_data', [])
            ->andReturn($existing);

        Session::shouldReceive('put')
            ->once()
            ->with('shipment_data', $expected);

        $service = new ShipmentService();
        $service->saveStep2Data($step2);

        $this->assertTrue(true);
    }

    /** ❌ Test gagal Step 2: kosong */
    public function test_it_throws_exception_if_step2_data_is_empty()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Payment method is required.');

        $service = new ShipmentService();
        $service->saveStep2Data([]); // ❌ Tanpa paymentMethod
    }

    /** ❌ Test gagal Step 2: paymentMethod null */
    public function test_it_throws_exception_if_payment_method_is_null()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Payment method is required.');

        $service = new ShipmentService();
        $service->saveStep2Data(['paymentMethod' => null]); // ❌ paymentMethod null
    }
}
