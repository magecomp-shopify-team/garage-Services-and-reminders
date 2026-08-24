<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\WorkshopScope;

class JobCardPart extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new WorkshopScope);
    }


    public function jobCard() { return $this->belongsTo(JobCard::class); }
    public function sparePart() { return $this->belongsTo(SparePart::class); }
}
