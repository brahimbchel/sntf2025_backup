<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return response()->json(Departement::all(), 200);
        return response()->json(Departement::with('secteur')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'secteur_id' => 'required|exists:secteur,id',
        ]);

        $departement = Departement::create($validated);

        return response()->json($departement, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $departement = Departement::find($id);
        $departement = Departement::with('secteur')->find($id);

        if (!$departement) {
            return response()->json(['message' => 'Departement not found'], 404);
        }

        return response()->json($departement, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)  // it support PUT and PATCH
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json(['message' => 'Departement not found'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:100',
            'secteur_id' => 'sometimes|required|exists:secteur,id',
        ]);

        $departement->update($validated);

        return response()->json($departement, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departement = Departement::find($id);

        if (!$departement) {
            return response()->json(['message' => 'Departement not found'], 404);
        }

        $departement->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}