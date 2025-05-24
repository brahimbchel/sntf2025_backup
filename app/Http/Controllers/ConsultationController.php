<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ConsultationController extends Controller
{
     public function index()
    {
        return response()->json(Consultation::all(), 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dossier_id' => 'required|exists:dossier_medical,id',
            'medecin_id' => 'required|exists:medecin,id',
            'date_consultation' => 'required|date',
            'diagnostic' => 'nullable|string',
        ]);

        $consultation = Consultation::create($validated);

        return response()->json($consultation, 201);
    }

    public function show(string $id)
    {
        $consultation = Consultation::find($id);
        // $consultation = Consultation::with('medecin')->find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        return response()->json($consultation, 200);
    }

    public function update(Request $request, string $id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        $validated = $request->validate([
            'dossier_id' => 'sometimes|required|exists:dossier_medical,id',
            'medecin_id' => 'sometimes|required|exists:medecin,id',
            'date_consultation' => 'sometimes|required|date',
            'diagnostic' => 'nullable|string',
        ]);

        $consultation->update($validated);

        return response()->json($consultation, 200);
    }

    public function destroy(string $id)
    {
        $consultation = Consultation::find($id);

        if (!$consultation) {
            return response()->json(['message' => 'Consultation not found'], 404);
        }

        $consultation->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }

    public function historique($dossierId)
    {
        $today = Carbon::today();

        $consultations = Consultation::with('medecin')->where('dossier_id', $dossierId)
                                    ->whereDate('date_consultation', '<', $today)
                                    ->orderBy('date_consultation', 'desc')
                                    ->get();

        return response()->json($consultations, 200);
    }

    public function future($dossierId)
{
    $today = Carbon::today();

    $consultations = Consultation::with('medecin')
        ->where('dossier_id', $dossierId)
        ->whereDate('date_consultation', '>=', $today)
        ->orderBy('date_consultation', 'asc')
        ->get();

    return response()->json($consultations, 200);
}

    //     public function future($dossierId)
    // {
    //     $today = Carbon::today();

    //     $consultations = Consultation::where('dossier_id', $dossierId)
    //                                 ->whereDate('date_consultation', '>=', $today)
    //                                 ->orderBy('date_consultation', 'asc')
    //                                 ->get();

    //     return response()->json($consultations, 200);
    // }

}