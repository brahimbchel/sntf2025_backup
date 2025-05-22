<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CentreMedicalController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\ExplorationFonctionnelleController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\MedicamentController;
use App\Http\Controllers\OrdonanceController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\SpecialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

Route::apiResource('secteur', SecteurController::class);

// Route::apiResource('departement', DepartementC::class);

Route::apiResource('employes', EmployeController::class);

Route::apiResource('centres-medicaux', CentreMedicalController::class);

Route::apiResource('specialite', SpecialiteController::class);

Route::apiResource('medecin', MedecinController::class);

Route::apiResource('dossier-medical', DossierMedicalController::class);
Route::get('/dossier-medical/employe/{emp_id}', [DossierMedicalController::class, 'getByEmployeId']);

Route::apiResource('consulation', ConsultationController::class);
Route::get('/consultations/historique/{dossierId}', [ConsultationController::class, 'historique']);
Route::get('/consultations/future/{dossierId}', [ConsultationController::class, 'future']);

Route::apiResource('exploration-fonctionelle', ExplorationFonctionnelleController::class);

Route::apiResource('medicaments', MedicamentController::class);

Route::apiResource('ordonnances', OrdonanceController::class);
Route::get('employes/{id}/ordonnances', [OrdonanceController::class, 'getOrdonnancesWithMedicaments']); // getOrdonnancesWithMedicaments

// ---
