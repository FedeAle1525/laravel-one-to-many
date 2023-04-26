<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    // Indico una Relazione: Type [1:N] Project(s), cioe' una Tipologia puo' essere assegnata a piu' Progetti 
    public function projects()
    {

        return $this->hasMany(Project::class);
    }
}
