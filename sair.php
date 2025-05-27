<?php

session_start();
ob_start();
//Destroi a sessão
unset($_SESSION['id'], $_SESSION['nome_usuario'], $_SESSION['admin'], $_SESSION['usuario']);

$_SESSION['msg'] = "<p style='color: green'>Deslogado com sucesso!</p>";
header("Location: index.php");