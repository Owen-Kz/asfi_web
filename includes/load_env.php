<?php

function loadEnv($path) {
    if (!file_exists($path)) {
        return false;
    }

    
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue; // Skip comments
        }
        
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);

     
        
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        
        }
    }
    return true;
} 

// Load environment variables
// loadEnv(__DIR__ . '/../.env');
// Get the root directory of the project
$rootPath = realpath(__DIR__ . '/../');
loadEnv($rootPath . '/.env');

// // Then use as before:
// $brevo_api_key = $_ENV['BREVO_API_KEY'] ?? getenv('BREVO_API_KEY');