<?php 
session_start();

$id_manifestacao = $_SESSION['id_entidade'];
$nome_entidade = $_SESSION['entidade_nome'];
// echo '<pre>';
//     print_r($_SESSION); 
// echo '</pre>';

session_destroy();
// header("Location: login.php?id=" . $id_manifestacao . "&&entidade_nome=" . $nome_entidade);
header("Location: login.php?id=" . urlencode($id_manifestacao) . '&&id_portal=' . $_SESSION['id_portal'] . '&&entidade_nome=' . urlencode($nome_entidade));

die();


?>
