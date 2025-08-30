<?php
session_start();
if (isset($_SESSION['ultima_pag'])) {
    $ultima_pag = $_SESSION['ultima_pag'];
}else{
    $ultima_pag = '../index.php';
}
session_destroy();
header("Location:" . $ultima_pag);
exit();
