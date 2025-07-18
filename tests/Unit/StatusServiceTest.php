<?php

namespace Tests\Unit;

use App\Models\Shipment;
use App\Services\StatusService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;
use Mockery;
use Tests\TestCase;

class StatusServiceTest extends TestCase
{
    /** Test: Update status sedang dikirim */
    public function test_it_updates_status_sedang_dikrim()
    {
        // Arrange
        $shipment = Mockery::mock(Shipment::class)->makePartial();
        $shipment->shouldReceive('save')->once();
        $service = new StatusService();

        // Act
        $result = $service->updateStatus($shipment, [
            'currentStatus' => 'Sedang Dikirim',
        ]);

        // Assert
        $this->assertEquals('Sedang Dikirim', $result->currentStatus);
    }

    /**  Test: Update status "Menuju Alamat" */
    public function test_it_updates_status_menuju_alamat()
    {
        // Arrange
        $shipment = Mockery::mock(Shipment::class)->makePartial();
        $shipment->shouldReceive('save')->once();
        $service = new StatusService();

        // Act
        $result = $service->updateStatus($shipment, [
            'currentStatus' => 'Menuju Alamat',
        ]);

        // Assert
        $this->assertEquals('Menuju Alamat', $result->currentStatus);
    }

    /**  Test: Update status dengan bukti pengiriman */
    public function test_it_updates_status_with_delivery_proof()
    {
        // Arrange
        Storage::fake('public');
        $shipment = Mockery::mock(Shipment::class)->makePartial();
        $shipment->shouldReceive('save')->once();
        $file = UploadedFile::fake()->image('bukti.jpg');
        $service = new StatusService();

        // Act
        $result = $service->updateStatus($shipment, [
            'currentStatus' => 'Pesanan Selesai',
            'delivery_proof' => $file,
        ]);

        // Assert
        $this->assertEquals('Pesanan Selesai', $result->currentStatus);
        Storage::disk('public')->assertExists($result->delivery_proof);
    }

    /** Test: Gagal jika status kosong */
    public function test_it_fails_if_shipment_status_is_empty()
    {
        // Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Status is required.');
        $shipment = Mockery::mock(Shipment::class)->makePartial();
        $service = new StatusService();

        // Act
        $service->updateStatus($shipment, []);
    }

    /** Test: Gagal jika status "Pesanan Selesai" tapi bukti tidak ada */
    public function test_it_fails_if_proof_missing_for_selesai()
    {
        // Arrange
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Delivery proof is required.');
        $shipment = Mockery::mock(Shipment::class)->makePartial();
        $service = new StatusService();

        // Act
        $service->updateStatus($shipment, [
            'currentStatus' => 'Pesanan Selesai',
            'delivery_proof' => null,
        ]);
    }
}
