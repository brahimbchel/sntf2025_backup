<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Resultat
 * 
 * @property int $rubrique_id
 * @property int $consultation_id
 * @property Carbon $dateR
 * @property string|null $resultat
 * 
 * @property Rubrique $rubrique
 * @property Consultation $consultation
 *
 * @package App\Models
 */
class Resultat extends Model
{
	protected $table = 'resultat';
	// public $incrementing = false;
	public $timestamps = true;

	protected $casts = [
		'rubrique_id' => 'int',
		'consultation_id' => 'int',
		'dateR' => 'datetime'
	];

	protected $fillable = [
		'resultat',
		'rubrique_id',
		'consultation_id',
		'dateR'
	];

	public function rubrique()
	{
		return $this->belongsTo(Rubrique::class);
	}

	public function consultation()
	{
		return $this->belongsTo(Consultation::class);
	}
}
