<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Bootstrap application database/configurations
$consoleKernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$consoleKernel->bootstrap();

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Get a user and authenticate
$user = User::first();
if ($user) {
    Auth::login($user);
}

$request = Request::create('/menu/1', 'GET');
$request->headers->set('Accept', 'application/json');

// Handle request through HTTP Kernel
$response = $kernel->handle($request);

echo "Actual Route Response status: " . $response->getStatusCode() . "\n";
echo "Actual Route Response content: " . $response->getContent() . "\n";

$kernel->terminate($request, $response);
