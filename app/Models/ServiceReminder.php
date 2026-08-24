<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\WorkshopScope;

class ServiceReminder extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new WorkshopScope);
    }


    public function workshop() { return $this->belongsTo(Workshop::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function jobCard() { return $this->belongsTo(JobCard::class); }
}
