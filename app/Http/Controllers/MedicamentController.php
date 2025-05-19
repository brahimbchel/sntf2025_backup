<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    public function index()
    {
        return response()->json(Medicament::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $med = Medicament::create($validated);
        return response()->json($med, 201);
    }

    public function show($id)
    {
        return response()->json(Medicament::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $med = Medicament::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:100',
            'description' => 'nullable|string',
        ]);

        $med->update($validated);
        return response()->json($med);
    }

    public function destroy($id)
    {
        $med = Medicament::findOrFail($id);
        $med->delete();

        return response()->json(['message' => 'Deleted']);
    }
}