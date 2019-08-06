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
     * @var House
     */
    private $house;

    /**
     * HouseController constructor.
     * @param House $house
     */
    public function __construct(House $house)
    {
        $this->house = $house;
    }

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function search(Request $request)
    {
        $houses = $this->house->fetchFoundData($request->all());

        return HouseResource::collection($houses)->additional(['meta' => [
            'version' => '1.0.0',
            'base_url' => url('/')
        ]]);
    }
}
