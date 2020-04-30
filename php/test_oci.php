<?php

require __DIR__ . '/pais_ciudad.php';

//oci
$connectionData = ['username' => "hr", 'password' => "welcome", 'connectionString' => "localhost/XE"];
$paisCiudad = new Pais_Ciudad($connectionData, 'oci', 'os.');
$paises = $paisCiudad->getPaises();
print_r($paises);
