<?php

$host = "localhost";
$port = "5432";
$dbname = "ConectaNews";
$user = "postgres";
$password = "betoven2008-1";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Erro na conexão: " . $e->getMessage();
}
?>