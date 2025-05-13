<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Medecin::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'gender' => 'required|boolean',
            'tel' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50',
            'cm' => 'required|exists:centre_medical,id',
            'specialite' => 'required|exists:specialite,id',
        ]);

        $medecin = Medecin::create($validated);

        return response()->json($medecin, 201);
    }

    public function show(string $id)
    {
        $medecin = Medecin::find($id);

        if (!$medecin) {
            return response()->json(['message' => 'Médecin not found'], 404);
        }

        return response()->json($medecin, 200);
    }

    public function update(Request $request, string $id)
    {
        $medecin = Medecin::find($id);

        if (!$medecin) {
            return response()->json(['message' => 'Médecin not found'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:100',
            'prenom' => 'sometimes|required|string|max:100',
            'gender' => 'sometimes|required|boolean',
            'tel' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50',
            'cm' => 'sometimes|required|exists:centre_medical,id',
            'specialite' => 'sometimes|required|exists:specialite,id',
        ]);

        $medecin->update($validated);

        return response()->json($medecin, 200);
    }

    public function destroy(string $id)
    {
        $medecin = Medecin::find($id);

        if (!$medecin) {
            return response()->json(['message' => 'Médecin not found'], 404);
        }

        $medecin->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
