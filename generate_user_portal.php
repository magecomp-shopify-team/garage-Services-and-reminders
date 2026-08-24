<?php

$adminControllersDir = __DIR__ . '/app/Http/Controllers/Admin';
$userControllersDir = __DIR__ . '/app/Http/Controllers/User';

if (!is_dir($userControllersDir)) {
    mkdir($userControllersDir, 0777, true);
}

$controllers = [
    'CustomerController.php',
    'VehicleController.php',
    'ServiceController.php',
    'SparePartController.php',
    'JobCardController.php',
    'InvoiceController.php',
    'PaymentController.php',
    'ServiceReminderController.php',
];

foreach ($controllers as $controller) {
    if (file_exists("$adminControllersDir/$controller")) {
        $content = file_get_contents("$adminControllersDir/$controller");
        
        // Replace namespace
        $content = str_replace('namespace App\Http\Controllers\Admin;', 'namespace App\Http\Controllers\User;', $content);
        
        // Replace view paths
        $content = preg_replace("/view\('admin\./", "view('user.", $content);
        
        // Replace route names
        $content = preg_replace("/route\('admin\./", "route('", $content);
        
        file_put_contents("$userControllersDir/$controller", $content);
    }
}

$adminViewsDir = __DIR__ . '/resources/views/admin';
$userViewsDir = __DIR__ . '/resources/views/user';

function copy_views($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..') && ($file != 'auth') && ($file != 'dashboard.blade.php')) {
            if (is_dir($src . '/' . $file)) {
                copy_views($src . '/' . $file, $dst . '/' . $file);
            } else {
                $content = file_get_contents($src . '/' . $file);
                
                // Replace layout
                $content = str_replace("@extends('layouts.admin')", "@extends('layouts.user')", $content);
                
                // Replace routes
                $content = preg_replace("/route\('admin\./", "route('", $content);
                
                file_put_contents($dst . '/' . $file, $content);
            }
        }
    }
    closedir($dir);
}

copy_views($adminViewsDir, $userViewsDir);
echo "User controllers and views generated successfully!\n";
