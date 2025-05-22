<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use Illuminate\Http\Request;

class EmployeController extends Controller
{

    public function getEmployeByUserId($userId)
{
    $employe = Employe::where('user_id', $userId)->first();

    if (!$employe) {
        return response()->json(['message' => 'Employé not found'], 404);
    }

    return response()->json($employe);
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Employe::with('departement')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'fonction' => 'nullable|string|max:100',
            'departement_id' => 'nullable|exists:departement,id',
            'datedenaissance' => 'nullable|date',
            'gender' => 'nullable|boolean',
            'adresse' => 'nullable|string|max:100',
            'tel' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50',
            'etat' => 'nullable|boolean',
        ]);

        $employe = Employe::create($validated);

        return response()->json($employe, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employe = Employe::with('departement')->find($id);

        if (!$employe) {
            return response()->json(['message' => 'Employé not found'], 404);
        }

        return response()->json($employe, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'employe not found'], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|required|string|max:100',
            'secteur_id' => 'sometimes|required|exists:secteur,id',
        ]);

        $employe->update($validated);

        return response()->json($employe, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employe = Employe::find($id);

        if (!$employe) {
            return response()->json(['message' => 'employe not found'], 404);
        }

        $employe->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> bm_dani
