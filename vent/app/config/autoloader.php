<?php
namespace App\Config;

// Enregistre l'autoloader
spl_autoload_register(function ($class) {
    // Remplace le namespace 'App\' par le chemin de base du dossier
    $class = str_replace('App\\', '', $class);
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);

    // Spécifie le dossier de base où se trouvent tes classes
    $file = __DIR__ . '/../' . $class . '.php';

    // Si le fichier existe, on l'inclut
    if (file_exists($file)) {
        require_once $file;
    }
});
