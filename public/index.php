<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

// Define the starting time for performance measurement
define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance mode (triggered by the "down" Artisan
| command), we will load this file so that any pre-rendered content can be
| shown to users instead of bootstrapping the entire framework.
|
*/
$maintenance = __DIR__.'/../storage/framework/maintenance.php';

if (file_exists($maintenance)) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides an automatically generated class loader. This includes
| all the classes required for the application, so we can load them
| without having to manually require individual files.
|
*/
require __DIR__.'/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Turn On Error Reporting in Development
|--------------------------------------------------------------------------
|
| In a production environment, we want to suppress detailed errors, but
| during development, we want to make sure we get full error reports.
|
*/
if (env('APP_ENV') !== 'production') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

/*
|--------------------------------------------------------------------------
| Handle The Incoming Request
|--------------------------------------------------------------------------
|
| Once the application has been loaded, we can handle the incoming HTTP
| request through the HTTP Kernel, and then send the response back
| to the browser.
|
*/
try {
    // Initialize the Laravel application
    $app = require_once __DIR__.'/../bootstrap/app.php';

    // Make the HTTP Kernel instance
    $kernel = $app->make(Kernel::class);

    // Capture the incoming request
    $request = Request::capture();

    // Handle the request and send the response
    $response = $kernel->handle($request);

    // Send the response to the browser
    $response->send();

    // Terminate the request after sending the response
    $kernel->terminate($request, $response);

} catch (\Exception $e) {
    // Handle any errors that occur during the request lifecycle

    // Log the error
    Log::error('Error handling request: '.$e->getMessage(), [
        'exception' => $e
    ]);

    // Return a generic error response if the application is in production
    if (env('APP_ENV') === 'production') {
        // Send a generic error response to the browser
        header('HTTP/1.1 500 Internal Server Error');
        echo 'Something went wrong. Please try again later.';
    } else {
        // In development mode, display the full error details
        echo 'Error: '.$e->getMessage().'<br>';
        echo 'File: '.$e->getFile().'<br>';
        echo 'Line: '.$e->getLine().'<br>';
    }

    // Exit the script
    exit(1);
}