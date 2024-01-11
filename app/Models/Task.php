<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;


    protected  $fillable=[
        'title',
        'is done'
    ];
    protected $casts=[
        'is_done'=> 'boolean',
    ];
    protected $hidden=[
        'updated_at',
        'created_at',
    ];
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    protected static function Boosted() : void
    {
        static::addGlobalScope('creator',function (Builder $builder){
            $builder->where('creator_id',Auth::id());
        });


    }
}
