<?php

namespace App\Http\Controllers;

use App\Models\ExplorationFonctionnelle;
use Illuminate\Http\Request;

class ExplorationFonctionnelleController extends Controller
{
    public function index()
    {
        return response()->json(ExplorationFonctionnelle::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultationid' => 'required|exists:consultation,id',
            'FRSP' => 'nullable|string',
            'FCIR' => 'nullable|string',
            'FMOT' => 'nullable|string',
            'date_exploration' => 'required|date',
        ]);

        $exploration = ExplorationFonctionnelle::create($validated);

        return response()->json($exploration, 201);
    }

    public function show(string $id)
    {
        $exploration = ExplorationFonctionnelle::find($id);

        if (!$exploration) {
            return response()->json(['message' => 'Exploration not found'], 404);
        }

        return response()->json($exploration, 200);
    }

    public function update(Request $request, string $id)
    {
        $exploration = ExplorationFonctionnelle::find($id);

        if (!$exploration) {
            return response()->json(['message' => 'Exploration not found'], 404);
        }

        $validated = $request->validate([
            'consultationid' => 'sometimes|required|exists:consultation,id',
            'FRSP' => 'nullable|string',
            'FCIR' => 'nullable|string',
            'FMOT' => 'nullable|string',
            'date_exploration' => 'sometimes|required|date',
        ]);

        $exploration->update($validated);

        return response()->json($exploration, 200);
    }

    public function destroy(string $id)
    {
        $exploration = ExplorationFonctionnelle::find($id);

        if (!$exploration) {
            return response()->json(['message' => 'Exploration not found'], 404);
        }

        $exploration->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}