<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\House;
use App\Http\Resources\House as HouseResource;

/**
 * Class HouseController
 * @package App\Http\Controllers
 */
class HouseController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $houses = House::paginate(House::PER_PAGE);

        return HouseResource::collection($houses)->additional(['meta' => [
            'version' => '1.0.0',
            'base_url' => url('/')
        ]]);
    }

    public function search(Request $request)
    {
        $houses = House::where('name', 'iLike', '%' . $request->q . '%')->get();

        return HouseResource::collection($houses)->additional(['meta' => [
            'version' => '1.0.0',
            'base_url' => url('/')
        ]]);
    }
}
