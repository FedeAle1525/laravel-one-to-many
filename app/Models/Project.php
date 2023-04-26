<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'client',
        'url',
        'type_id'
    ];

    // Indico una Relazione: Project(s) [N:1] Type, cioe' un Progetto puo' avere una sola Tipologia 
    public function type()
    {

        return $this->belongsTo(Type::class);
    }
}
