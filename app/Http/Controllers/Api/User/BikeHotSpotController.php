<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\BikeHotspot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BikeHotSpotController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Tag(
     *     name="Bike Hotspots",
     *     description="Operations related to bike shops"
     * )
     */


    /**
     * @OA\Get(
     *     path="/api/bike-hotspots",
     *     tags={"Bike Hotspots"},
     *     summary="Get bike hotspots",
     *     description="Retrieve a list of bike hotspots with pagination.",
     *     @OA\Response(
     *         response=200,
     *         description="List of bike hotspots retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="bike_hot_spots",
     *                 type="array",
     *                 description="List of bike hotspots",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Bike Hotspot 1"),
     *                     @OA\Property(property="description", type="string", example="Description of Bike Hotspot 1"),
     *                     @OA\Property(
     *                         property="location",
     *                         type="object",
     *                         @OA\Property(property="lat", type="number", format="float", example=123.456),
     *                         @OA\Property(property="long", type="number", format="float", example=78.90),
     *                         description="Location of the bike hotspot"
     *                     ),
     *                     @OA\Property(property="image", type="string", example="http://example.com/image1.jpg"),
     *                     @OA\Property(property="uploader_id", type="integer", example=1),
     *
     *                 )
     *             )
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */
    public function index()
    {
        $bikeHotSpots = BikeHotspot::latest()->paginate(10);

        return response([
            'bike_hot_spots' => $bikeHotSpots
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
     *     path="/api/bike-hotspots",
     *     tags={"Bike Hotspots"},
     *     summary="Create a new bike hotspot",
     *     description="Add a new bike hotspot with provided information.",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Bike hotspot data",
     *         @OA\JsonContent(
     *             required={"name", "description", "location", "image"},
     *             @OA\Property(property="name", type="string", example="Bike Hotspot Name"),
     *             @OA\Property(property="description", type="string", example="Description of the bike hotspot"),
     *             @OA\Property(property="location", type="object", example={"lat": 123.456, "long": 78.90}, description="Location of the bike hotspot"),
     *             @OA\Property(property="image", type="string", format="binary", description="Image file (PNG, JPG) of the bike hotspot")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike hotspot added successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bike Hotspot Added Success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="The given data was invalid.")
     *         )
     *     ),
     *     security={{ "bearerAuth":{} }}
     * )
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'descriptions' => 'required',
            'location' => 'required',
            'image' => 'required|mimes:png,jpg'
        ]);

        $imageName = 'HTSPT-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/hotspot/', $imageName, 'public');


        $user = Auth::user();

        BikeHotspot::create([
            'name' => $request->name,
            'description' => $request->description,
            'location' => json_encode($request->location),
            'image' => asset('/storage/' . $dir),
            'uploader_id' => $user->id
        ]);


        return response([
            'message' => 'Bike Hotspot Added Success'
        ], 200);
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *     path="/api/bike-hotspots/{id}",
     *     tags={"Bike Hotspots"},
     *     summary="Get a bike hotspot by ID",
     *     description="Retrieve a bike hotspot by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bike hotspot to retrieve",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike hotspot retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Bike Hotspot Name"),
     *             @OA\Property(property="description", type="string", example="Description of the bike hotspot"),
     *             @OA\Property(
     *                 property="location",
     *                 type="object",
     *                 @OA\Property(property="lat", type="number", format="float", example=123.456),
     *                 @OA\Property(property="long", type="number", format="float", example=78.90),
     *                 description="Location of the bike hotspot"
     *             ),
     *             @OA\Property(property="image", type="string", example="http://example.com/image1.jpg"),
     *             @OA\Property(property="uploader_id", type="integer", example=1),
     *             @OA\Property(property="uploader", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2022-03-20T12:00:00Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2022-03-20T12:00:00Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bike hotspot not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bike hotspot not found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $bikeHotSpot = BikeHotspot::with('uploader')->whereId($id)->first();


        return response([
            'bike_hot_spot' => $bikeHotSpot
        ], 200);
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
     *     path="/api/bike-hotspots/{id}",
     *     tags={"Bike Hotspots"},
     *     summary="Update a bike hotspot by ID",
     *     description="Update a bike hotspot by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bike hotspot to update",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Bike hotspot data to update",
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Name of the bike hotspot"),
     *             @OA\Property(property="description", type="string", description="Description of the bike hotspot"),
     *             @OA\Property(property="location", type="object", description="Location of the bike hotspot",
     *                 @OA\Property(property="lat", type="number", format="float", description="Latitude"),
     *                 @OA\Property(property="long", type="number", format="float", description="Longitude")
     *             ),
     *             @OA\Property(property="image", type="string", format="binary", description="Image file of the bike hotspot (PNG, JPG, JPEG)")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike hotspot updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bike hotspot information updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid image format")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bike hotspot not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bike hotspot not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {

        $bikeHotSpot = BikeHotspot::find($id);


        if ($request->image !== null) {

            $request->validate([
                'image' => 'mimes:png,jpg,jpeg',
            ]);

            $imageName = 'HTSPT-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/hotspot/', $imageName, 'public');


            $bikeHotSpot->update([
                'image' => asset('/storage/' . $dir),
            ]);
        }

        $bikeHotSpot->update([
            'name' => $request->name ?? $bikeHotSpot->name,
            'description' => $request->description ?? $bikeHotSpot->description,
            'location' => $request->location !== null ? json_encode($request->location) : $bikeHotSpot->location
        ]);


        return response([
            'message' => 'Bike Hotspot Information Updated Success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *     path="/api/bike-hotspots/{id}",
     *     tags={"Bike Hotspots"},
     *     summary="Delete a bike hotspot by ID",
     *     description="Delete a bike hotspot by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the bike hotspot to delete",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Bike hotspot deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bike hotspot deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Bike hotspot not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Bike hotspot not found")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $bikeHotSpot = BikeHotspot::find($id);

        $bikeHotSpot->delete();



        return response([
            'message' => 'Bike Hotspot Deleted'
        ], 200);
    }
}
