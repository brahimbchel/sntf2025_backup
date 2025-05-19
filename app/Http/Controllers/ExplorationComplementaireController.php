<?php

namespace App\Http\Controllers;

use App\Models\ExplorationComplementaire;
use Illuminate\Http\Request;

class ExplorationComplementaireController extends Controller
{
    public function index()
    {
        return response()->json(ExplorationComplementaire::all());
    }

    // Store a new record
    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultationidC' => 'required|integer|exists:consultation,id',
            'radio' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:100',
            'toxic' => 'nullable|string|max:100',
            'date_exploration' => 'nullable|date',
        ]);

        $exploration = ExplorationComplementaire::create($validated);

        return response()->json($exploration, 201);
    }

    // Show a specific record
    public function show($id)
    {
        $exploration = ExplorationComplementaire::findOrFail($id);
        return response()->json($exploration);
    }

    // Update a specific record
    public function update(Request $request, $id)
    {
        $exploration = ExplorationComplementaire::findOrFail($id);

        $validated = $request->validate([
            'consultationidC' => 'sometimes|integer|exists:consultation,id',
            'radio' => 'nullable|string|max:100',
            'bio' => 'nullable|string|max:100',
            'toxic' => 'nullable|string|max:100',
            'date_exploration' => 'nullable|date',
        ]);

        $exploration->update($validated);

        return response()->json($exploration);
    }

    // Delete a record
    public function destroy($id)
    {
        $exploration = ExplorationComplementaire::findOrFail($id);
        $exploration->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}