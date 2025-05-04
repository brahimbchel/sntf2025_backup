<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExplorationFonctionnelle
 * 
 * @property int $id
 * @property int|null $consultationid
 * @property string|null $FRSP
 * @property string|null $FCIR
 * @property string|null $FMOT
 * @property Carbon|null $date_exploration
 * 
 * @property Consultation|null $consultation
 *
 * @package App\Models
 */
class ExplorationFonctionnelle extends Model
{
	protected $table = 'exploration_fonctionnelle';
	public $timestamps = false;

	protected $casts = [
		'consultationid' => 'int',
		'date_exploration' => 'datetime'
	];

	protected $fillable = [
		'consultationid',
		'FRSP',
		'FCIR',
		'FMOT',
		'date_exploration'
	];

	public function consultation()
	{
		return $this->belongsTo(Consultation::class, 'consultationid');
	}
}
