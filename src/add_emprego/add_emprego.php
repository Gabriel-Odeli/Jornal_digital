<?php
include __DIR__ . '/conect_pgsql/conn.php';

session_start();
if (!$_SESSION) {
    header("Location: ../login/login.php");
}
if (!$_SESSION['tipo'] == 1) {
    header("Location: ../tela_empregos/tela_empregos.php?erro=notadm");
}
?>