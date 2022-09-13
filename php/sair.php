<?php
// encerrando a sessão
session_start();
session_unset();
session_destroy();

header("location: login_novo.php");
?>