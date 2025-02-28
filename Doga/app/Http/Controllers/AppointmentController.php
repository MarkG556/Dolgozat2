<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Barber;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /*if($request->has("id")){
            try {
                $appointment = Appointment::findOrFail($request->id);
            } catch (\Throwable $th) {
                return response()->json(["success" => false, "uzenet" => "Nincs ilyen azonosítójú foglalás!"], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
            }
            
            return response()->json(["success" => true, "uzenet" => $appointment->jsonSerialize()], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }*/

        $appointment = Appointment::all();
        return response()->json(["success" => true, "uzenet" => $appointment->jsonSerialize()], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
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
                "barber_id"=> "required|int",
                "appointment" => "required|date"
            ],[
                "name.max" =>"A(z) :attribute túl hosszú! Max hossz: 255!",
                "required" =>"A(z) :attribute kitöltése kötelező!",
                "string" =>"A(z) :attribute szöveges értéket vár!",
                "int" => "A(z) :attribute szám értéket vár!"
            ],[
                "name" => "név",
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "uzenet" => $e->errors()], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }
        try {
            $barber = Barber::findOrFail($request->barber_id);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "uzenet" => "A választott barber nem létezik!"], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        $appointment = Appointment::create([
            "name" => $request->name,
            "barber_id" => $barber->id,
            "appointment" =>$request->appointment
        ]);

        return response()->json(["success" => true, "uzenet" => "Foglalás " . $appointment->name . " névere rögzítve!"], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $appointment = Appointment::findOrFail($request->id);
        } catch (\Throwable $th) {
            return response()->json(["success" => false, "uzenet" => "Nincs ilyen azonosítójú foglalás!"], 400, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
        }

        $appointment->delete();
        return response()->json(["success" => true, "uzenet" => "Foglalás törölve!"], 200, ["Access-Control-Allow-Origin" => "*"], JSON_UNESCAPED_UNICODE);
    }
}
