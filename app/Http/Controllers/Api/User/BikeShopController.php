<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\BikeShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BikeShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Tag(
     *     name="BikeShops",
     *     description="Operations related to bike shops"
     * )
     */

    /**
     * @OA\Get(
     *     path="/api/bike-shops",
     *     tags={"BikeShops"},
     *     summary="Get all bike shops",
     *     description="Retrieve all bike shops.",
     *     @OA\Response(
     *         response=200,
     *         description="List of bike shops retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="bike_shop",
     *                 type="array",
     *                 description="List of bike shops",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example="1",
     *                         description="ID of the bike shop"
     *                     ),
     *                     @OA\Property(
     *                         property="name",
     *                         type="string",
     *                         example="Sample Bike Shop",
     *                         description="Name of the bike shop"
     *                     ),
     *                     @OA\Property(
     *                         property="description",
     *                         type="string",
     *                         example="A description of the bike shop",
     *                         description="Description of the bike shop"
     *                     ),
     *                     @OA\Property(
     *                         property="location",
     *                         type="object",
     *                         example={"lat": 123.456, "long": 78.90},
     *                         description="Location of the bike shop"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */

    public function index()
    {
        $shops = BikeShop::get();


        return response([
            'bike_shop' => $shops
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *     path="/api/bike-shops",
     *     tags={"BikeShops"},
     *     summary="Create a new bike shop",
     *     description="Create a new bike shop.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Bike shop data to add",
     *         @OA\JsonContent(
     *             required={"name", "description", "location"},
     *             @OA\Property(property="name", type="string", example="Sample Bike Shop"),
     *             @OA\Property(property="description", type="string", example="A description of the bike shop"),
     *             @OA\Property(property="location", type="object", example={"lat": 123.456, "long": 78.90})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike shop added successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Bikeshop Added"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid."
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "name": {"The name field is required."},
     *                     "description": {"The description field is required."},
     *                     "location": {"The location field is required."}
     *                 }
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'location' => 'array|required'
        ]);


        $user = Auth::user();

        $bikeShop = BikeShop::create(
            collect(['user_id' => $user->id])
                ->merge($data)
                ->toArray()
        );


        return response([
            'message' => 'Bikeshop Added',
            'bike_store' => $bikeShop
        ], 200);
    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *     path="/api/bike-shops/{id}",
     *     tags={"BikeShops"},
     *     summary="Get a specific bike shop",
     *     description="Retrieve a specific bike shop by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bike shop to retrieve",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike shop retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="bike_shop",
     *                 type="object",
     *                 description="Bike shop details",
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="1",
     *                     description="ID of the bike shop"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Sample Bike Shop",
     *                     description="Name of the bike shop"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="A description of the bike shop",
     *                     description="Description of the bike shop"
     *                 ),
     *                 @OA\Property(
     *                     property="location",
     *                     type="object",
     *                     example={"lat": 123.456, "long": 78.90},
     *                     description="Location of the bike shop"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bike shop not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Bike shop not found"
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */
    public function show(string $id)
    {
        $shop = BikeShop::find($id);



        return response([
            'bike_shop' => $shop
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *     path="/api/bike-shops/{id}",
     *     tags={"BikeShops"},
     *     summary="Update a bike shop",
     *     description="Update a bike shop by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bike shop to update",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Updated bike shop data",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Updated Bike Shop"),
     *             @OA\Property(property="description", type="string", example="Updated description of the bike shop"),
     *             @OA\Property(property="location", type="object", example={"lat": 123.456, "long": 78.90})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike shop updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Shop Updated Success"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bike shop not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Bike shop not found"
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */
    public function update(Request $request, string $id)
    {
        $shop = BikeShop::find($id);


        $shop->update([
            'name' => $request->name ?? $shop->name,
            'description' => $request->description ?? $shop->description,
            'location' => json_encode($request->location ?? $shop->location)
        ]);


        return response([
            'message' => 'Shop Updated Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @OA\Delete(
     *     path="/api/bike-shops/{id}",
     *     tags={"BikeShops"},
     *     summary="Delete a bike shop",
     *     description="Delete a bike shop by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bike shop to delete",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike shop deleted successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Shop Deleted"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bike shop not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Bike shop not found"
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */
    public function destroy(string $id)
    {
        $shop = BikeShop::find($id);


        $shop->delete();


        return response([
            'message' => 'Shop Deleted'
        ]);
    }
}
