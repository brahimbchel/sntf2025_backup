<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrdonnanceMedicament
 * 
 * @property int $id
 * @property int|null $ordonnance_id
 * @property int|null $medicament_id
 * @property string|null $dosage
 * @property string|null $duree
 * 
 * @property Ordonnance|null $ordonnance
 * @property Medicament|null $medicament
 *
 * @package App\Models
 */
class OrdonnanceMedicament extends Model
{
	protected $table = 'ordonnance_medicament';
	public $timestamps = false;

	protected $casts = [
		'ordonnance_id' => 'int',
		'medicament_id' => 'int'
	];

	protected $fillable = [
		'ordonnance_id',
		'medicament_id',
		'dosage',
		'duree'
	];

	public function ordonnance()
	{
		return $this->belongsTo(Ordonnance::class);
	}

	public function medicament()
	{
		return $this->belongsTo(Medicament::class);
	}
}
