<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    protected $destination;

    public function __construct(Destination $destination)
    {
        $this->destination = $destination;
    }

    public function index(Request $request)
    {
        $destinations = $this->destination->select('id', 'name')
            ->where('name', 'like', '%'.$request->q.'%')
            ->get();

        return response()->json([
            'data' => $destinations,
        ]);
    }

    public function show($id)
    {
        $destination = $this->destination
            ->select('cost')
            ->where('id', $id)
            ->first();

        return response()->json([
            'destination' => $destination,
        ]);
    }
}
