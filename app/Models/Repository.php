<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repository extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
        'website',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
