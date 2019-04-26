<?php

$host = 'localhost';
$porta = 3306;
$usuario = 'root';
$senha = '';
$dbNome = 'bdados';

$pdo = new PDO("mysql:host=$host:$porta; dbname=$dbNome;charset=latin1", $usuario, $senha);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


