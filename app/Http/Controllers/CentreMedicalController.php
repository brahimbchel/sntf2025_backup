<?php

namespace App\Http\Controllers;

use App\Models\CentreMedical;
use Illuminate\Http\Request;

class CentreMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CentreMedical::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $centre = CentreMedical::create($validated);

        return response()->json($centre, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $centre = CentreMedical::find($id);

        if (!$centre) {
            return response()->json(['message' => 'Centre médical not found'], 404);
        }

        return response()->json($centre, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $centre = CentreMedical::find($id);

        if (!$centre) {
            return response()->json(['message' => 'Centre médical not found'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:100',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:20',
        ]);

        $centre->update($validated);

        return response()->json($centre, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $centre = CentreMedical::find($id);

        if (!$centre) {
            return response()->json(['message' => 'Centre médical not found'], 404);
        }

        $centre->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
