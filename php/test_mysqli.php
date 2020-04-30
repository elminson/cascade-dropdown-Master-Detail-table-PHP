<?php

require __DIR__ . '/pais_ciudad.php';

//mysqli
$connectionData = ['host' => '127.0.0.1:12764', 'username' => "root", 'password' => "root", 'database' => "ciudad"];
$paisCiudad = new Pais_Ciudad($connectionData, 'mysql');
$paises = $paisCiudad->getPaises();
print_r($paises);
