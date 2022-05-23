<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicles extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'sigles', 'descripcio', 'actiu'];
    protected $table = 'cicles';

    public $timestamps = false;

    public function cursos() {
        return $this->hasMany(Cursos::class, 'cicles_id');
    }

    public function moduls()
    {
        return $this->hasMany(Moduls::class, 'cicles_id');
    }

    /* public function moduls()
    {
        return $this->hasMany(Moduls::class, 'moduls_has_cicles', 'cicles_id', 'moduls_id')->withPivot('cicles_academic_id');
    } */
}
