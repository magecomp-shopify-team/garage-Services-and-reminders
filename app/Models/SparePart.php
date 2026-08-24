<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\WorkshopScope;

class SparePart extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new WorkshopScope);
    }


    public function workshop() { return $this->belongsTo(Workshop::class); }
    public function jobCardParts() { return $this->hasMany(JobCardPart::class); }
}
