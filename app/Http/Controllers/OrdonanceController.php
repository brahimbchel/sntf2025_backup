<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use App\Models\Employe;
use App\Models\Ordonnance;
use Illuminate\Http\Request;

class OrdonanceController extends Controller
{

    public function getOrdonnancesWithMedicaments($employeId)
{
    $employe = Employe::find($employeId);

    if (!$employe) {
        return response()->json(['message' => 'Employé non trouvé'], 404);
    }

    $dossier = DossierMedical::where('emp_id', $employeId)->first();

    if (!$dossier) {
        return response()->json(['message' => 'Dossier médical non trouvé'], 404);
    }

    $consultations = $dossier->consultations;

    $ordonnances = collect();

    foreach ($consultations as $consultation) {
        foreach ($consultation->ordonnances as $ordonnance) {
            $ordonnances->push([
                'ordonnance_id' => $ordonnance->id,
                'date' => $ordonnance->created_at,
                'recomendations' => $ordonnance->recommandations,
                'medicaments' => $ordonnance->medicaments->map(function ($med) {
                    return [
                        'id' => $med->id,
                        'nom' => $med->nom,
                        'dosage' => $med->pivot->dosage ?? null,
                    ];
                }),
            ]);
        }
    }

    $ordonnances = $ordonnances->sortByDesc('date')->values();

    return response()->json([
        'employe_id' => $employe->id,
        'ordonnances' => $ordonnances
    ]);
}
    
    // // return ordonnances for an employee, including their medicaments 
    // public function getOrdonnancesWithMedicaments($employeId)
    // {
    //     $employe = Employe::find($employeId);

    //     $dossier = DossierMedical::where('employe_id', $employeId);

        
    //     if (!$employe) {
    //         return response()->json(['message' => 'Employé non trouvé'], 404);
    //     }

    // // if (!$dossier) {
    // //     return response()->json(['error' => 'Dossier not found'], 404);
    // // }

    //     // Get consultations related to the dossier
    //     $consultations = $dossier->consultations; 

    //     // $consultations = $employe->dossier_medicals->pluck('consultations')->flatten();


    //     $ordonnances = collect();
    //     $ordonnances = $ordonnances->sortByDesc('date')->values();


    //     foreach ($consultations as $consultation) {
    //         foreach ($consultation->ordonnances as $ordonnance) {
    //             $ordonnances->push([
    //                 'ordonnance_id' => $ordonnance->id,
    //                 'date' => $ordonnance->created_at,
    //                 'medicaments' => $ordonnance->medicaments->map(function($med) {
    //                     return [
    //                         'id' => $med->id,
    //                         'nom' => $med->nom,
    //                         'dosage' => $med->pivot->dosage ?? null, // only if you have dosage in pivot
    //                     ];
    //                 }),
    //             ]);
    //         }
    //     }

    //     return response()->json([
    //         'employe_id' => $employe->id,
    //         'ordonnances' => $ordonnances
    //     ]);
    // }


    // ###########################

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