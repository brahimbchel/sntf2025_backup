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
 * @property Carbon|null $date_ordonnance
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
		'date_ordonnance' => 'datetime'
	];

	protected $fillable = [
		'consultation_id',
		'date_ordonnance',
		'recommandations'
	];

	public function consultation()
	{
		return $this->belongsTo(Consultation::class);
	}

	public function medicaments()
	{
		return $this->belongsToMany(Medicament::class, 'ordonnance_medicament')
					->withPivot('id', 'dosage', 'duree');
	}
}
