<?php

namespace App\Http\Controllers;

use App\Models\Specialite;
use Illuminate\Http\Request;

class SpecialiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Specialite::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
        ]);

        $Specialite = Specialite::create($validated);

        return response()->json($Specialite, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $Specialite = Specialite::find($id);

        if (!$Specialite) {
            return response()->json(['message' => 'Specialite not found'], 404);
        }

        return response()->json($Specialite, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)  // it support PUT and PATCH
    {
        $Specialite = Specialite::find($id);

        if (!$Specialite) {
            return response()->json(['message' => 'Specialite not found'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:100',
        ]);

        $Specialite->update($validated);

        return response()->json($Specialite, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Specialite = Specialite::find($id);

        if (!$Specialite) {
            return response()->json(['message' => 'Specialite not found'], 404);
        }

        $Specialite->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
