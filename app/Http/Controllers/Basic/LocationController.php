<?php

namespace App\Http\Controllers\Basic;

use App\Models\Location\City;
use App\Models\Product\Product;
use App\Models\Location\Block;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        if (count($cities) > 0) {
            return response()->json($cities);
        } else {
            return response()->json(['error' => 'No cities found for the given state ID.']);
        }
    }

    public function getBlocks($cityId)
    {
        $blocks = Block::where('city_id', $cityId)->get();
        // if (count($blocks) > 0) {
            return response()->json($blocks);
        // } else {
        //     return response()->json(['error' => 'No blocks found for the given city ID.']);
        // }
    }
    
    public function filter(Request $request)
{
    $query = Product::select('products.*','stores.store_slug')
        ->join('stores', 'products.store_id', '=', 'stores.id');

    if ($request->has('state') && $request->state != '') {
        $query->where('stores.state_name', $request->state);
    }

    if ($request->has('city') && $request->city != '') {
        $query->where('stores.city_name', $request->city);
    }

    if ($request->has('block') && $request->block != '') {
        $query->where('stores.block_name', $request->block);
    }

    $query->where('quantity', '>', 0);
    $coupens = $query->get();

    return view('coupens.filter', compact('coupens'));
}

    public function getCitiesByState(Request $request)
    {
        $state = $request->state;
        $cities = City::where('state_id', $state)->get();
        return response()->json($cities);
    }

    public function getBlocksByCity(Request $request)
{
    $blocks = Block::where('city_id', $request->city)
        ->orderBy('name', 'asc')
        ->get();
    return response()->json($blocks);
}

}
