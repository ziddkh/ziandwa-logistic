<?php

namespace App\Repositories\Shipment;

interface ShipmentRepositoryInterface
{
    public function all();

    public function find(string $uuid, string $shipmentHeaderNumber);

    public function create(array $shipmentHeader, array $shipmentItems);

    public function delete(string $uuid, string $shipmentHeaderNumber);
}
