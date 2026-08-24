<?php

$models = [
    'Customer' => [
        'relationships' => '
    public function vehicles() { return $this->hasMany(Vehicle::class); }
    public function jobCards() { return $this->hasMany(JobCard::class); }
    public function invoices() { return $this->hasMany(Invoice::class); }
    public function serviceReminders() { return $this->hasMany(ServiceReminder::class); }
'
    ],
    'Vehicle' => [
        'relationships' => '
    public function customer() { return $this->belongsTo(Customer::class); }
    public function jobCards() { return $this->hasMany(JobCard::class); }
    public function serviceReminders() { return $this->hasMany(ServiceReminder::class); }
'
    ],
    'Mechanic' => [
        'relationships' => '
    public function jobCards() { return $this->hasMany(JobCard::class); }
'
    ],
    'Service' => [
        'relationships' => '
    public function jobCardServices() { return $this->hasMany(JobCardService::class); }
'
    ],
    'SparePart' => [
        'relationships' => '
    public function jobCardParts() { return $this->hasMany(JobCardPart::class); }
'
    ],
    'JobCard' => [
        'relationships' => '
    public function customer() { return $this->belongsTo(Customer::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function mechanic() { return $this->belongsTo(Mechanic::class); }
    public function jobCardServices() { return $this->hasMany(JobCardService::class); }
    public function jobCardParts() { return $this->hasMany(JobCardPart::class); }
    public function invoice() { return $this->hasOne(Invoice::class); }
    public function serviceReminder() { return $this->hasOne(ServiceReminder::class); }
'
    ],
    'Invoice' => [
        'relationships' => '
    public function jobCard() { return $this->belongsTo(JobCard::class); }
    public function payments() { return $this->hasMany(Payment::class); }
'
    ],
    'Payment' => [
        'relationships' => '
    public function invoice() { return $this->belongsTo(Invoice::class); }
'
    ],
    'ServiceReminder' => [
        'relationships' => '
    public function customer() { return $this->belongsTo(Customer::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }
    public function jobCard() { return $this->belongsTo(JobCard::class); }
'
    ],
    'JobCardService' => [
        'relationships' => '
    public function jobCard() { return $this->belongsTo(JobCard::class); }
    public function service() { return $this->belongsTo(Service::class); }
'
    ],
    'JobCardPart' => [
        'relationships' => '
    public function jobCard() { return $this->belongsTo(JobCard::class); }
    public function sparePart() { return $this->belongsTo(SparePart::class); }
'
    ]
];

foreach ($models as $name => $data) {
    $content = "<?php\n\nnamespace App\Models;\n\nuse Illuminate\Database\Eloquent\Model;\n\nclass $name extends Model\n{\n    protected \$guarded = [];\n" . $data['relationships'] . "}\n";
    file_put_contents(__DIR__ . "/app/Models/$name.php", $content);
}

echo "Models updated successfully.\n";
