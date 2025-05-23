<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appareil
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $examenClinique
 * 
 * @property Collection|Rubrique[] $rubriques
 *
 * @package App\Models
 */
class Appareil extends Model
{
    protected $table = 'appareil';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        // 'examenClinique',
    ];

    public function rubriques()
    {
        return $this->hasMany(Rubrique::class, 'App_id');
    }
}