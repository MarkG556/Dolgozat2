<?php

namespace App\Http\Controllers;

use App\Models\Barber;
use App\Http\Requests\StoreBarberRequest;
use App\Http\Requests\UpdateBarberRequest;
use Illuminate\Validation\ValidationException;
use Request;

class BarberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->has("id")){
            try {
                $barber = Barber::findOrFail($request->id);
            } catch (\Throwable $th) {
                return response()->json(["success" => false, "uzenet" => "Nincs ilyen azonosítójú barber!"], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
            }
            
            return response()->json(["success" => true, "uzenet" => $barber->jsonSerialize()], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        $barbers = Barber::all();
        return response()->json(["success" => true, "uzenet" => $barbers->jsonSerialize()], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
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
    public function store(Request $request) {
        try {
            $request->validate([
                "name" => "required|string|max:255",
            ],[
                "name.max" =>"A(z) :attribute túl hosszú! Max hossz: 255!",
                "required" =>"A(z) :attribute kitöltése kötelező!",
                "string" =>"A(z) :attribute szöveges értéket vár!",
            ],[
                "name" => "név",
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "uzenet" => $e->errors()], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        $barber = Barber::create([
            "name" => $request->name,
        ]);

        return response()->json(["success" => true, "uzenet" => "Barber " . $barber->name . " rögzítve!"], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $barber = Barber::findOrFail($request->id);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "uzenet" => "Nincs ilyen azonosítójú barber!"], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }
        
        return response()->json(["success" => true, "uzenet" => $barber->jsonSerialize()], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barber $barber)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarberRequest $request, Barber $barber)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $barber = Barber::findOrFail($request->id);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "uzenet" => "Nincs ilyen azonosítójú barber!"], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        $barber->delete();
        return response()->json(["success" => true, "uzenet" => "Barber elbocsátva!"], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }
}
