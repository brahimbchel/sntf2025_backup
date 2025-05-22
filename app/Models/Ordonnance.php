<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ordonnance
 * 
 * @property int $id
 * @property int|null $consultation_id
 * @property string|null $recommandations
 * 
 * @property Consultation|null $consultation
 * @property Collection|Medicament[] $medicaments
 *
 * @package App\Models
 */
class Ordonnance extends Model
{
	protected $table = 'ordonnance';
	public $timestamps = false;

	protected $casts = [
		'consultation_id' => 'int',
	];

	protected $fillable = [
		'consultation_id',
		'recommandations'
	];

	public function consultation()
	{
		return $this->belongsTo(Consultation::class);
	}

	public function ordonnance_medicaments()
	{
   		return $this->hasMany(\App\Models\OrdonnanceMedicament::class);
	}

	public function medicaments()
	{
		return $this->belongsToMany(Medicament::class, 'ordonnance_medicament')
					->withPivot('id', 'dosage', 'duree');
	}
}
