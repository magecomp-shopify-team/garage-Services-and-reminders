<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\WorkshopScope;

class JobCard extends Model
{
    protected $guarded = [];

    protected static function booted(): void
    {
        static::addGlobalScope(new WorkshopScope);
    }


    public function workshop() { return $this->belongsTo(Workshop::class); }
    public function customer() { return $this->belongsTo(Customer::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function mechanic() { return $this->belongsTo(Mechanic::class); }
    public function jobCardServices() { return $this->hasMany(JobCardService::class); }
    public function jobCardParts() { return $this->hasMany(JobCardPart::class); }
    public function invoice() { return $this->hasOne(Invoice::class); }
    public function serviceReminder() { return $this->hasOne(ServiceReminder::class); }
}
