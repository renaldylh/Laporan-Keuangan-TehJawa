<?php

// Simple test to verify Laravel is working
echo "Laravel Test Page<br>";
echo "Time: " . date('Y-m-d H:i:s') . "<br>";

// Test database connection
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=tehjawa', 'root', '');
    echo "Database: Connected<br>";
} catch(PDOException $e) {
    echo "Database: Failed - " . $e->getMessage() . "<br>";
}

// Test if Laravel bootstrap works
try {
    require_once __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    echo "Laravel: Bootstrap OK<br>";
    
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "Laravel: Kernel OK<br>";
    
} catch(Exception $e) {
    echo "Laravel: Failed - " . $e->getMessage() . "<br>";
}

echo "<br><a href='/sales'>Test Sales Route</a>";
echo "<br><a href='/login'>Go to Login</a>";
?>
