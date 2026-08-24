<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\WorkshopScope;

class Payment extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new WorkshopScope);
    }


    public function workshop() { return $this->belongsTo(Workshop::class); }
    public function invoice() { return $this->belongsTo(Invoice::class); }
}
