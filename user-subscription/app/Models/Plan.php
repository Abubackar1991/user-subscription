<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = "plans";

    protected $fillable = [
        'plan_name',
        'days',
        'created',
    ];
}
