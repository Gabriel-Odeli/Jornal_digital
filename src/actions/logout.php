<?php
session_start();
session_destroy();
header("Location: ../tela_principal/tela_principal.php");
exit();
