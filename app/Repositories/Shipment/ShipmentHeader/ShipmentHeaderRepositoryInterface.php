<?php

namespace App\Repositories\Shipment\ShipmentHeader;

interface ShipmentHeaderRepositoryInterface
{
    public function all();

    public function find($uuid);

    public function create(array $shipmentHeader, array $shipmentItems);

    public function update($uuid, $shipmentHeaderNumber, array $shipmentHeaderData);

    public function delete($uuid);
}
