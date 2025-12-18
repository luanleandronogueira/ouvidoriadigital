<?php 
session_start();

session_destroy();
// header("Location: login.php?id=" . $id_manifestacao . "&&entidade_nome=" . $nome_entidade);
header("Location: login.php?");

die();


?>
