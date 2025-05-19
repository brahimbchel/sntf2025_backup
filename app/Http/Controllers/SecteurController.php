<?php

namespace App\Http\Controllers;

use App\Models\Secteur;
use Illuminate\Http\Request;

class SecteurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Secteur::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
        ]);

        $secteur = Secteur::create($validated);

        return response()->json($secteur, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $secteur = Secteur::find($id);

        if (!$secteur) {
            return response()->json(['message' => 'secteur not found'], 404);
        }

        return response()->json($secteur, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)  // it support PUT and PATCH
    {
        $secteur = Secteur::find($id);

        if (!$secteur) {
            return response()->json(['message' => 'secteur not found'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:100',
        ]);

        $secteur->update($validated);

        return response()->json($secteur, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $secteur = Secteur::find($id);

        if (!$secteur) {
            return response()->json(['message' => 'secteur not found'], 404);
        }

        $secteur->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> bm_dani
