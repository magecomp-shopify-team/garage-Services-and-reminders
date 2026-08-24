<?php

$dir = __DIR__ . '/database/migrations';
$files = scandir($dir);

$schemas = [
    'create_customers_table' => <<<'EOT'
            $table->id();
            $table->string('name');
            $table->string('mobile');
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
EOT,
    'create_vehicles_table' => <<<'EOT'
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('registration_number');
            $table->string('brand');
            $table->string('model');
            $table->string('year')->nullable();
            $table->string('fuel_type')->nullable();
            $table->string('color')->nullable();
            $table->integer('current_km')->default(0);
            $table->string('chassis_number')->nullable();
            $table->timestamps();
EOT,
    'create_services_table' => <<<'EOT'
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('duration')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
EOT,
    'create_mechanics_table' => <<<'EOT'
            $table->id();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('specialization')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
EOT,
    'create_spare_parts_table' => <<<'EOT'
            $table->id();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('category')->nullable();
            $table->string('supplier')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->decimal('selling_price', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('low_stock_limit')->default(5);
            $table->timestamps();
EOT,
    'create_job_cards_table' => <<<'EOT'
            $table->id();
            $table->string('job_number')->unique();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('mechanic_id')->nullable()->constrained();
            $table->text('complaint')->nullable();
            $table->text('inspection_notes')->nullable();
            $table->integer('current_km')->nullable();
            $table->decimal('estimated_amount', 10, 2)->nullable();
            $table->string('status')->default('Pending');
            $table->date('received_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->timestamps();
EOT,
    'create_job_card_services_table' => <<<'EOT'
            $table->id();
            $table->foreignId('job_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
EOT,
    'create_job_card_parts_table' => <<<'EOT'
            $table->id();
            $table->foreignId('job_card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('spare_part_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->timestamps();
EOT,
    'create_invoices_table' => <<<'EOT'
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('job_card_id')->constrained();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->string('status')->default('Pending');
            $table->timestamps();
EOT,
    'create_payments_table' => <<<'EOT'
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->string('payment_method')->default('Cash');
            $table->date('payment_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
EOT,
    'create_service_reminders_table' => <<<'EOT'
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('job_card_id')->nullable()->constrained();
            $table->date('last_service_date')->nullable();
            $table->date('next_service_date')->nullable();
            $table->integer('last_service_km')->nullable();
            $table->integer('next_service_km')->nullable();
            $table->integer('reminder_before_days')->default(3);
            $table->string('status')->default('Upcoming');
            $table->text('notes')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
EOT,
];

foreach ($files as $file) {
    if (strpos($file, '.php') === false) continue;
    
    $path = $dir . '/' . $file;
    $content = file_get_contents($path);
    
    foreach ($schemas as $key => $schema) {
        if (strpos($file, $key) !== false) {
            $replacement = <<<'EOT'
    public function up(): void
    {
        Schema::create('REPLACE_TABLE', function (Blueprint $table) {
EOT;
            
            preg_match("/Schema::create\('([^']+)'/", $content, $matches);
            $tableName = $matches[1] ?? '';
            
            if ($tableName) {
                $replacement = str_replace('REPLACE_TABLE', $tableName, $replacement);
                $replacement .= "\n" . $schema . "\n        });\n    }";
                
                $pattern = "/public function up\(\): void\s*\{\s*Schema::create\('[^']+', function \(Blueprint \\\$table\) \{\s*\\\$table->id\(\);\s*\\\$table->timestamps\(\);\s*\}\);\s*\}/s";
                
                $newContent = preg_replace($pattern, $replacement, $content);
                file_put_contents($path, $newContent);
                echo "Updated $file\n";
            }
        }
    }
}
