<?php
// Script para realizar logout do admin
session_start();
session_unset();
session_destroy();
// Inicia nova sessão para mensagem de logout
session_start();
$_SESSION['msg_id'] = 9; // 9 = Logout realizado

header("Location: ../index.php");
exit();