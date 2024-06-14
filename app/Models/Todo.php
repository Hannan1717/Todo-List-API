<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Todo extends Model
{
    use HasFactory;

    // bisa pake Model::unguard() di AppServiceprovider
    // protected $fillable = ['user_id','name','status']; 

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
