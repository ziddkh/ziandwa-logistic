<?php

namespace App\Http\Controllers\Shipment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipment\StoreRequest;
use App\Models\Shipment\ShipmentHeader;
use App\Services\Payment\PaymentHeaderService;
use App\Services\Shipment\ShipmentService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
    protected $shipmentService;

    protected $paymentHeaderService;

    public function __construct(ShipmentService $shipmentService, PaymentHeaderService $paymentHeaderService)
    {
        $this->shipmentService = $shipmentService;
        $this->paymentHeaderService = $paymentHeaderService;
    }

    public function index(Request $request)
    {
        $title = 'List Pengiriman';
        $shipments = ShipmentHeader::with(['shipmentItems', 'paymentHeader.paymentDetails']);
            // ->where('departure_date', '>=', Carbon::today()->format('Y-m-d'))

        if ($request->filled('name')) {
            $shipments = $shipments->where("recipient_name", "LIKE", "%$request->name%");
        }

        if ($request->filled('departure_date')) {
            $shipments = $shipments->whereDate("departure_date", $request->departure_date);
        }

        if ($request->filled('recipient_address')) {
            $recipientAddress = $request->recipient_address;
            $shipments = $shipments->where(function ($query) use ($recipientAddress) {
                $query->whereRaw('LOWER(recipient_address) LIKE ?', ['%'.strtolower($recipientAddress).'%'])
                    ->orWhereRaw('UPPER(recipient_address) LIKE ?', ['%'.strtoupper($recipientAddress).'%']);
            });
        }

        $shipments = $shipments->latest('created_at')->get();

        return view('pages.shipments-2.index', [
            'title' => $title,
            'shipments' => $shipments,
            'request' => $request->all()
        ]);
    }

    public function create()
    {
        $title = 'Tambah Pengiriman';

        return view('pages.shipments-2.create.index', compact('title'));
    }

    public function store(StoreRequest $request)
    {
        DB::beginTransaction();
        try {
            if (! empty($request->items['bales'])) {
                $totalVolWeight = collect($request->items['bales'])->sum(function ($bale) {
                    return $bale['width'] * $bale['length'] * $bale['height'] / 1000000;
                });
            } else {
                $totalVolWeight = 0;
            }
            $shipment = ShipmentHeader::create([
                'shipment_number' => $this->shipmentService->generateShipmentNumber(),
                'departure_date' => $request->departure_date,
                'expected_arrival_date' => Carbon::parse($request->departure_date)->addDays(6),
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'recipient_address' => $request->recipient_address,
                'type_of_shipment_id' => 1,
                'destination_id' => $request->destination_id,
                'destination_cost' => $request->cost,
                'harbor_name' => $request->harbor_name,
                'status' => 'pickup',
                'total_vol_weight' => $totalVolWeight,
            ]);
            if (! empty($request->items['bales'])) {
                foreach ($request->items['bales'] as $bale) {
                    $shipment->shipmentItems()->create([
                        'shipment_id' => $shipment->id,
                        'type' => 'bale',
                        'ship_name' => $request->ship_name,
                        'length' => $bale['length'],
                        'width' => $bale['width'],
                        'height' => $bale['height'],
                        'vol_weight' => $bale['width'] * $bale['length'] * $bale['height'] / 1000000,
                        'price' => $request->cost * $bale['width'] * $bale['length'] * $bale['height'] / 1000000,
                    ]);
                }
            }

            if (! empty($request->items['vehicles'])) {
                foreach ($request->items['vehicles'] as $vehicle) {
                    $shipment->shipmentItems()->create([
                        'shipment_id' => $shipment->id,
                        'type' => 'vehicle',
                        'ship_name' => $request->ship_name,
                        'price' => $vehicle['price'],
                        'description' => $vehicle['description'],
                    ]);
                }
            }

            $shipment->paymentHeader()->create([
                'shipment_header_id' => $shipment->id,
                'payment_number' => $this->paymentHeaderService->generatePaymentNumber(),
                'payment_status' => 'Belum Dibayar',
                'total_payment' => $shipment->shipmentItems->sum('price'),
            ]);

            DB::commit();

            return response()->json([
                'redirect_url' => route('shipments-2.index'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return $e;
            // return redirect()->back()->with('error', 'Pengiriman gagal ditambahkan');
        }
    }

    public function show($uuid)
    {
        $title = 'Detail Pengiriman';
        $shipment = ShipmentHeader::with('shipmentItems', 'destination')->where('uuid', $uuid)->firstOrFail();

        return view('pages.shipments-2.show.index', compact('title', 'shipment'));
    }

    public function update()
    {
        DB::beginTransaction();
        try {

        } catch (\Exception $e) {

        }
    }

    public function destroy($uuid, $shipmentHeaderNumber)
    {
        ShipmentHeader::where('uuid', $uuid)
            ->where('shipment_number', $shipmentHeaderNumber)
            ->firstOrFail()
            ->delete();

        return redirect()->route('shipments-2.index')->with('success', 'Pengiriman berhasil dihapus');
    }
}
