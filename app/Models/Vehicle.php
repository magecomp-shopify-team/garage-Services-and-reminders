<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\WorkshopScope;

class Vehicle extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new WorkshopScope);
    }


    public function workshop() { return $this->belongsTo(Workshop::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function jobCards() { return $this->hasMany(JobCard::class); }
    public function serviceReminders() { return $this->hasMany(ServiceReminder::class); }
}
