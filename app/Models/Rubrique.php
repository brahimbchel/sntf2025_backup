<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rubrique
 * 
 * @property int $id
 * @property int|null $App_id
 * @property string|null $titre
 * @property bool|null $visible
 * 
 * @property Appareil|null $appareil
 * @property Collection|Resultat[] $resultats
 *
 * @package App\Models
 */
class Rubrique extends Model
{
	protected $table = 'rubrique';
	public $timestamps = false;

	protected $casts = [
		'App_id' => 'int',
		'visible' => 'bool'
	];

	protected $fillable = [
		'App_id',
		'titre',
		'visible'
	];

	public function appareil()
	{
		return $this->belongsTo(Appareil::class, 'App_id');
	}

	public function resultats()
	{
		return $this->hasMany(Resultat::class);
	}
}
