<?php

namespace App\Http\Controllers;

use App\Models\BikeRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BikeRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bike_routes = BikeRoute::latest()->paginate(20);

        return response($bike_routes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:60',
            'description' => 'string|max:300|nullable',
            'waypoints' => 'array'
        ]);

        $user = Auth::user();

        $bike_route = BikeRoute::create(
            collect(['user_id' => $user->id])
                ->merge($validated)
                ->toArray()
        );

        return response([
            'message' => 'bike route is added',
            'bike_route' => $bike_route
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(BikeRoute $bikeRoute)
    {
        $bikeRoute->load('user');

        return response([
            'bike_route' => $bikeRoute
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BikeRoute $bikeRoute)
    {
        $validated = $request->validate([
            'name' => 'required|max:60',
            'description' => 'string|max:300|nullable',
            'waypoints' => 'array'
        ]);

        $bikeRoute->update($validated);


        return response([
            'message' => 'bike route updated',
            'bike_route' => $bikeRoute->fresh()
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BikeRoute $bikeRoute)
    {
        $bikeRoute->delete();

        return response([
            'message' => 'bike route deleted',
            'bike_route' => $bikeRoute
        ]);
    }
}
