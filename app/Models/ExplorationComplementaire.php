<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ExplorationComplementaire
 * 
 * @property int $id
 * @property int|null $consultationidC
 * @property string|null $radio
 * @property string|null $bio
 * @property string|null $toxic
 * @property Carbon|null $date_exploration
 * 
 * @property Consultation|null $consultation
 *
 * @package App\Models
 */
class ExplorationComplementaire extends Model
{
	protected $table = 'exploration_complementaire';
	public $timestamps = false;

	protected $casts = [
		'consultationidC' => 'int',
		'date_exploration' => 'datetime'
	];

	protected $fillable = [
		'consultationidC',
		'radio',
		'bio',
		'toxic',
		'date_exploration'
	];

	public function consultation()
	{
		return $this->belongsTo(Consultation::class, 'consultationidC');
	}
}
