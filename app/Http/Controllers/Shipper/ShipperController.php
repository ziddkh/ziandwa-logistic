<?php

namespace App\Http\Controllers\Shipper;

use App\Enums\ShipperStatusEnums;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shipper\StoreRequest;
use App\Models\Destination;
use App\Models\Shipment\TypeOfShipment;
use App\Models\Shipper;
use App\Services\Shipper\ShipperService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipperController extends Controller
{
    public function __construct(
      protected Shipper $model
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "List Shipper";
        $data = $this->model
          ->latest()
          ->get();

        return view('pages.shipper.index', [
          'title' => $title,
          'shippers' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Tambah Shipper";
        return view('pages.shipper.create', [
          'title' => $title,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $dataToInsert = $request->validated();
        try {
            $newDocumentNumber = ShipperService::generateDocumentNumber();
        } catch (\Exception $e) {
            throw $e;
        }

        try {
            $destination = Destination::findOrFail($dataToInsert['destination_id']);
        } catch (\Exception $e) {
            throw $e;
        }

        try {
            $typeOfShipment = TypeOfShipment::findOrFail(1);
        } catch (\Exception $e) {
            throw $e;
        }

        $dataToInsert['document_number'] = $newDocumentNumber;
        $dataToInsert['destination_name'] = $destination->name;

        $dataToInsert['type_of_shipment_id'] = $typeOfShipment->id;
        $dataToInsert['type_of_shipment_name'] = $typeOfShipment->name;
        $dataToInsert['type_of_shipment_freight'] = $typeOfShipment->freight;

        $dataToInsert['status'] = ShipperStatusEnums::PENDING->value;
        $dataToInsert['total_colly'] = collect($dataToInsert['items'])->sum('colly');
        $dataToInsert['total_vol_weight'] = collect($dataToInsert['items'])->sum('vol_weight');
        $dataToInsert['total_price'] = (int) ($dataToInsert['total_vol_weight'] * $dataToInsert['destination_cost']);

        $itemsToInsert = $dataToInsert['items'];
        unset($dataToInsert['items']);

        foreach ($itemsToInsert as &$item) {
            $item['price'] = (int) ($item['vol_weight'] * $dataToInsert['destination_cost']);
        }

        try {
            DB::beginTransaction();
            $shipper = $this->model->create($dataToInsert);
            $shipper->items()->createMany($itemsToInsert);
          DB::commit();
        } catch (\Exception $e) {
          DB::rollBack();
          throw $e;
        }

        return response()->json([
            'redirect_url' => route('shipper.show', ['uuid' => $shipper->uuid])
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function show($shipper)
    {
        $title = "Detail Shipper";
        $data = $this->model
          ->with('items')
          ->where('uuid', $shipper)
          ->firstOrFail();
        return view('pages.shipper.show', [
          'title' => $title,
          'shipper' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipper $shipper)
    {
        $dataToUpdate = $request->validated();
        $shipper->update($dataToUpdate);

        return redirect()->route('shipper.show')->with('success', 'Shipper berhasil di-edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipper  $shipper
     * @return \Illuminate\Http\Response
     */
    public function destroy($shipper)
    {
        $this->model
          ->with('items')
          ->where('uuid', $shipper)
          ->firstOrFail()
          ->delete();

        return redirect()->route('shipper.index')->with('success', 'Shipper berhasil di-hapus');
    }
}
