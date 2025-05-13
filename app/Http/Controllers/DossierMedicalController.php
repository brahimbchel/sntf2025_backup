<?php

namespace App\Http\Controllers;

use App\Models\DossierMedical;
use Illuminate\Http\Request;

class DossierMedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(DossierMedical::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:100',
            'emp_id' => 'required|exists:employe,id',
        ]);

        $dossier = DossierMedical::create($validated);

        return response()->json($dossier, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dossier = DossierMedical::find($id);

        if (!$dossier) {
            return response()->json(['message' => 'Dossier not found'], 404);
        }

        return response()->json($dossier, 200);
    }

    public function getByEmployeId($emp_id)
    {
        $dossier = DossierMedical::where('emp_id', $emp_id)->first();

        if (!$dossier) {
            return response()->json(['message' => 'Dossier not found for this employé'], 404);
        }

        return response()->json($dossier, 200);
    }

    public function update(Request $request, string $id)
    {
        $dossier = DossierMedical::find($id);

        if (!$dossier) {
            return response()->json(['message' => 'Dossier not found'], 404);
        }

        $validated = $request->validate([
            'description' => 'sometimes|required|string|max:100',
            'emp_id' => 'sometimes|required|exists:employe,id',
        ]);

        $dossier->update($validated);

        return response()->json($dossier, 200);
    }

    public function destroy(string $id)
    {
        $dossier = DossierMedical::find($id);

        if (!$dossier) {
            return response()->json(['message' => 'Dossier not found'], 404);
        }

        $dossier->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
