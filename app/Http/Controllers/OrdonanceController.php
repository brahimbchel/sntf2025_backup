<?php

namespace App\Http\Controllers;

use App\Models\Ordonnance;
use Illuminate\Http\Request;

class OrdonanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Ordonnance::with('medicaments')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|exists:consultation,id',
            'date_ordonnance' => 'required|date',
            'recommandations' => 'nullable|string',
            'medicaments' => 'required|array', // Array of meds with dosage & durée
            'medicaments.*.id' => 'required|exists:medicament,id',
            'medicaments.*.dosage' => 'required|string',
            'medicaments.*.duree' => 'required|string',
        ]);

        $ordonnance = Ordonnance::create($validated);

        $syncData = [];
        foreach ($validated['medicaments'] as $med) {
            $syncData[$med['id']] = [
                'dosage' => $med['dosage'],
                'duree' => $med['duree'],
            ];
        }

        $ordonnance->medicaments()->sync($syncData);

        return response()->json($ordonnance->load('medicaments'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ordonnance = Ordonnance::with('medicaments')->findOrFail($id);
        return response()->json($ordonnance);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ordonnance = Ordonnance::findOrFail($id);

        $validated = $request->validate([
            'consultation_id' => 'sometimes|exists:consultation,id',
            'date_ordonnance' => 'sometimes|date',
            'recommandations' => 'nullable|string',
            'medicaments' => 'nullable|array',
            'medicaments.*.id' => 'required_with:medicaments|exists:medicament,id',
            'medicaments.*.dosage' => 'required_with:medicaments|string',
            'medicaments.*.duree' => 'required_with:medicaments|string',
        ]);

        $ordonnance->update($validated);

        if (isset($validated['medicaments'])) {
            $syncData = [];
            foreach ($validated['medicaments'] as $med) {
                $syncData[$med['id']] = [
                    'dosage' => $med['dosage'],
                    'duree' => $med['duree'],
                ];
            }
            $ordonnance->medicaments()->sync($syncData);
        }

        return response()->json($ordonnance->load('medicaments'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ordonnance = Ordonnance::findOrFail($id);
        $ordonnance->medicaments()->detach();
        $ordonnance->delete();

        return response()->json(['message' => 'Ordonnance deleted']);
    }
}
