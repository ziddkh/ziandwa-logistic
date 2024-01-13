<?php

namespace App\Http\Services\Shipment;

use App\Repositories\Shipment\ShipmentHeader\ShipmentHeaderRepository;

class ShipmentHeaderService
{
    protected $shipmentHeaderRepository;

    public function __construct(ShipmentHeaderRepository $shipmentHeaderRepository)
    {
        $this->shipmentHeaderRepository = $shipmentHeaderRepository;
    }

    public function all()
    {
        $shipmentHeaders = $this->shipmentHeaderRepository->all();

        return $shipmentHeaders;
    }

    public function find($uuid)
    {
        $shipmentHeader = $this->shipmentHeaderRepository->find($uuid);

        return $shipmentHeader;
    }

    public function create($shipmentHeader)
    {
        // $shipmentHeader = $this->shipmentHeaderRepository->create($shipmentHeader);
        return $shipmentHeader;
    }

    public function update($uuid, $shipmentHeader)
    {
        // $shipmentHeader = $this->shipmentHeaderRepository->update($uuid, $shipmentHeader);
        return $shipmentHeader;
    }

    public function delete($uuid)
    {
        $shipmentHeader = $this->shipmentHeaderRepository->delete($uuid);

        return $shipmentHeader;
    }
}
