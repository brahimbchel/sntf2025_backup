<?php

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
 * @property Resultat|null $resultat
 *
 * @package App\Models
 */
class Rubrique extends Model
{
    protected $table = 'rubrique';
    public $timestamps = false;

    protected $casts = [
        'App_id' => 'int',
    ];

    protected $fillable = [
        'App_id',
        'titre',
    ];

    public function appareil()
    {
        return $this->belongsTo(Appareil::class, 'App_id'); // Relation correcte avec Appareil
    }

    public function resultat()
{
    return $this->hasOne(Resultat::class, 'rubrique_id'); // à adapter selon ta base
}
}