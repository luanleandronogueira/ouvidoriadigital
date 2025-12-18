<?php
// Inicia a sessão e inclui o cabeçalho (assumindo que estão na pasta 'controladores')
// Começa a sessão
session_start();

// Carrega a Model e valida a sessão
require 'model/SessaoModel.php';
valida_sessao();

require 'controladores/header.php';
require 'model/UsuarioAdmModel.php';

$UsuarioAdm = new UsuarioAdm;
$usuarios = $UsuarioAdm->chama_usuarios();

?>

<div class="container my-5">

    <div class="solicitacoes-titlo">
        <h5>Listagem de Usuários</h5>
    </div>

    <hr>

    <div>
        <table class="table table-striped sua-tabela" id="myTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Usuário</th>
                    <th>CPF</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario) { ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= $usuario['usuario'] ?></td>
                        <td><?= $usuario['cpf'] ?></td>
                        <td><a href="editar_usuario.php?id=<?= $usuario['id']?>">Editar</a></td>
                        <td><a href="altera_nivel_acesso.php?id=<?= $usuario['id']?>">Altera Nível de Acesso</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>


</div>

<?php include_once 'controladores/Footer.php' ?>