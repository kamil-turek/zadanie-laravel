<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['currency', 'amount', 'user_id', 'date'];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
