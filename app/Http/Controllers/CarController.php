<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpsertCarRequest;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $cars = Auth::user()
            ->cars()
            ->latest('id')
            ->paginate(10);

        return CarResource::collection($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UpsertCarRequest $request): CarResource
    {
        $car = Auth::user()->cars()->create([
            ...$request->validated(),
            'image' => $request->file('image')?->storePublicly('cars'),
        ]);

        return CarResource::make($car);
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car): CarResource
    {
        Gate::authorize('manage', $car);

        return CarResource::make($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpsertCarRequest $request, Car $car): CarResource
    {
        Gate::authorize('manage', $car);

        $car->fill($request->only(['make', 'model', 'year', 'price', 'description']));

        if ($request->hasFile('image')) {
            if ($car->image && Storage::exists($car->image)) {
                Storage::delete($car->image);
            }

            $car->image = $request->file('image')->storePublicly('cars');
        }

        $car->save();

        return CarResource::make($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car): Response
    {
        Gate::authorize('manage', $car);

        $car->delete();

        return response()->noContent();
    }
}
