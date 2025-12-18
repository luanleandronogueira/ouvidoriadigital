<?php
date_default_timezone_set('America/Sao_Paulo');
require_once 'Conexao.php';
require_once 'Interfaces.php';

class Usuario implements usuario_interface
{

    private int $id_usuario;
    private $conexao;
    private $nome_usuario;
    private $sobrenome_usuario;
    private $cpf_usuario;
    private $email_usuario;
    private $senha_usuario;

    public function __construct()
    {
        $this->conexao = new Conexao;
    }

    public function inserir_usuario($nome_usuario, $sobrenome_usuario, $cpf_usuario, $email_usuario, $senha_usuario)
    {

        $query =  "INSERT INTO tb_usuario (nome_usuario, sobrenome_usuario, cpf_usuario, email_usuario,  senha_usuario) VALUES (:nome_usuario, :sobrenome_usuario, :cpf_usuario, :email_usuario, :senha_usuario)";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':nome_usuario', $nome_usuario);
            $stmt->bindValue(':sobrenome_usuario', $sobrenome_usuario);
            $stmt->bindValue(':cpf_usuario', $cpf_usuario);
            $stmt->bindValue(':email_usuario', $email_usuario);
            $stmt->bindValue(':senha_usuario', $senha_usuario);

            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao inserir usuário: ' . $e->getMessage());
        }
    }

    public function consulta_cpf($cpf_usuario)
    {

        $query = "SELECT COUNT(*) AS total_registros FROM tb_usuario WHERE cpf_usuario = :cpf_usuario";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':cpf_usuario', $cpf_usuario);
            $stmt->execute();

            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            return $r['total_registros'];
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }

    public function email_usuario($email_usuario)
    {

        $query = "SELECT COUNT(*) AS total_registros FROM tb_usuario WHERE email_usuario = :email_usuario";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':email_usuario', $email_usuario);
            $stmt->execute();

            $r = $stmt->fetch(PDO::FETCH_ASSOC);
            return $r['total_registros'];
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar email: ' . $e->getMessage());
        }
    }

    public function consulta_usuario($login_usuario)
    {

        if (strlen($login_usuario) == 11) {

            $query = "SELECT * FROM tb_usuario WHERE cpf_usuario = :login_usuario LIMIT 1";
        } else {

            $query = "SELECT * FROM tb_usuario WHERE email_usuario = :login_usuario LIMIT 1";
        }

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':login_usuario', $login_usuario);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }

    public function chama_usuario_perfil($id_usuario){
        $query = "SELECT * FROM tb_usuario WHERE id_usuario = :id_usuario LIMIT 1";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }

    public function conta_manifestacao_usuario($id_usuario){
        $query = "SELECT * FROM tb_manifestacoes WHERE id_usuario_manifestacao = :id_usuario";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_usuario', $id_usuario);
            $stmt->execute();

            $r = [];

            return $r = $stmt->rowCount();

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }

    public function atualizar_usuario($id_usuario, $nome_usuario, $sobrenome_usuario, $email_usuario){
        $query = "UPDATE tb_usuario SET nome_usuario = :nome_usuario, sobrenome_usuario = :sobrenome_usuario, email_usuario = :email_usuario WHERE id_usuario = :id_usuario";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':nome_usuario', $nome_usuario);
            $stmt->bindValue(':sobrenome_usuario', $sobrenome_usuario);
            $stmt->bindValue(':email_usuario', $email_usuario);
            $stmt->bindValue(':id_usuario', $id_usuario);

            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }

    public function atualizar_senha_usuario($senha_usuario, $email_usuario){
        $query = "UPDATE tb_usuario SET senha_usuario = :senha_usuario WHERE email_usuario = :email_usuario";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':senha_usuario', $senha_usuario);
            $stmt->bindValue(':email_usuario', $email_usuario);

            $stmt->execute();
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }
}

class TipoManifestacoes implements tipo_manifestacoes {
    private int $id_tipo_manifestacao;
    private $conexao;
    private $tipo_manifestacao;

    public function __construct()
    {
        $this->conexao = new Conexao;
    }

    public function chama_tipo_manifestacoes(){
        $query = "SELECT * FROM tb_tipo_manifestacoes";

        try{
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $r = [];
            $stmt->execute();

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            throw new Exception('Erro ao chamar os tipos de manifestações: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao($id_nome_manifestacao){
        $query = "SELECT * FROM tb_tipo_manifestacoes WHERE id_tipo_manifestacao = :id_nome_manifestacao";
        try{
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_nome_manifestacao', $id_nome_manifestacao);

            $r = [];
            $stmt->execute();

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            throw new Exception('Erro ao chamar o tipo de manifestação: ' . $e->getMessage());
        }

    }
}

class Manifestacoes implements interface_manifestacoes {

    private int $id_manifestacao;
    private $conexao;
    private $motivo_manifestacao;
    private $id_entidade_manifestacao;
    private $id_tipo_manifestacao;
    private $conteudo_manifestacao;
    private $observacoes_manifestacao;
    private $local_manifestacao;
    private $arquivo_manifestacao;
    private $id_usuario_manifestacao;
    private $status_manifestacao;
    private $data_manifestacao;
    private $protocolo_manifestacao;

    public function __construct()
    {
        $this->conexao = new Conexao;
    }

    public function inserir_manifestacao($motivo_manifestacao, $id_entidade_manifestacao, $id_tipo_manifestacao, $conteudo_manifestacao, $observacoes_manifestacao, $local_manifestacao, $arquivo_manifestacao, $id_usuario_manifestacao, $status_manifestacao, $data_manifestacao, $protocolo_manifestacao){

        $query = "INSERT INTO tb_manifestacoes (motivo_manifestacao, id_entidade_manifestacao, id_tipo_manifestacao, conteudo_manifestacao, observacoes_manifestacao, local_manifestacao, arquivo_manifestacao, id_usuario_manifestacao, status_manifestacao, data_manifestacao, protocolo_manifestacao) values (:motivo_manifestacao, :id_entidade_manifestacao, :id_tipo_manifestacao, :conteudo_manifestacao, :observacoes_manifestacao, :local_manifestacao, :arquivo_manifestacao, :id_usuario_manifestacao, :status_manifestacao, :data_manifestacao, :protocolo_manifestacao)";
    
        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':motivo_manifestacao', $motivo_manifestacao);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao);
            $stmt->bindValue(':id_tipo_manifestacao', $id_tipo_manifestacao);
            $stmt->bindValue(':conteudo_manifestacao', $conteudo_manifestacao);
            $stmt->bindValue(':observacoes_manifestacao', $observacoes_manifestacao);
            $stmt->bindValue(':local_manifestacao', $local_manifestacao);
            $stmt->bindValue(':arquivo_manifestacao', $arquivo_manifestacao);
            $stmt->bindValue(':id_usuario_manifestacao', $id_usuario_manifestacao);
            $stmt->bindValue(':status_manifestacao', $status_manifestacao);
            $stmt->bindValue(':data_manifestacao', $data_manifestacao);
            $stmt->bindValue(':protocolo_manifestacao', $protocolo_manifestacao);
    
            $stmt->execute();
    
        } catch (PDOException $e) {
            throw new Exception('Erro ao inserir o tipo de manifestação: ' . $e->getMessage());
        }
    
    }

    public function chama_minhas_manifestacoes($id_usuario_manifestacao){

        $query = "SELECT m.id_manifestacao, 
                        m.protocolo_manifestacao, 
                        m.motivo_manifestacao, 
                        m.status_manifestacao, 
                        e.nome_entidade 
                FROM tb_manifestacoes m
                JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao
                WHERE m.id_usuario_manifestacao = :id_usuario_manifestacao";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_usuario_manifestacao', $id_usuario_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar as manifestações: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao($id_manifestacao){
        $query = "SELECT m.* , tm.nome_tipo_manifestacao, e.nome_entidade
                FROM tb_manifestacoes m
                JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao JOIN tb_tipo_manifestacoes tm ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
                WHERE m.id_manifestacao = :id_manifestacao";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_manifestacao', $id_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

}

class Entidades implements interface_entidades{

    private int $id_entidade;
    private $conexao;
    private $nome_entidade;
    private $email_entidade;
    private $telefone_entidade;

    public function __construct()
    {
        $this->conexao = new Conexao;
    }

    public function chama_email_entidade($id_entidade){
        $query = "SELECT email_entidade FROM tb_entidades WHERE id_entidade = :id_entidade";

        try{
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade', $id_entidade);

            $r = [];
            $stmt->execute();

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            throw new Exception('Erro ao chamar o e-mail da entidade: ' . $e->getMessage());
        }
    }

    public function chama_entidades(){
        $query = "SELECT * FROM tb_entidades";

        try{
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $r = [];
            $stmt->execute();

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            throw new Exception('Erro ao chamar o e-mail da entidade: ' . $e->getMessage());
        }
    }

    public function chama_entidade($id_entidade){
        $query = "SELECT id_entidade, nome_entidade FROM tb_entidades WHERE id_entidade = :id_entidade";

        try{
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade', $id_entidade);

            $r = [];
            $stmt->execute();

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e){
            throw new Exception('Erro ao chamar a entidade da entidade: ' . $e->getMessage());
        }
    }
}

class CodigoRecuperacao implements interface_codigo_recuperacao {
    private int $id_codigo_recuperacao;
    private $conexao;
    private $codigo_codigo_recuperacao;
    private $email_codigo_recuperacao;
    private $data_codigo_recuperacao;
    private $status_codigo_recuperacao;
    private $cod_validador_codigo_recuperacao;

    public function __construct()
    {
        $this->conexao = new Conexao;
    }

    public function registra_codigo_recuperacao($codigo_codigo_recuperacao, $email_codigo_recuperacao, $data_codigo_recuperacao, $status_codigo_recuperacao, $cod_validador_codigo_recuperacao){
            $query = "INSERT INTO tb_codigo_recuperacao (codigo_codigo_recuperacao, email_codigo_recuperacao, data_codigo_recuperacao, status_codigo_recuperacao, cod_validador_codigo_recuperacao) VALUES (:codigo_codigo_recuperacao, :email_codigo_recuperacao, :data_codigo_recuperacao, :status_codigo_recuperacao, :cod_validador_codigo_recuperacao)";

            try {
                $conn = $this->conexao->Conectar();
                $stmt = $conn->prepare($query);
                $stmt->bindValue(':codigo_codigo_recuperacao', $codigo_codigo_recuperacao);
                $stmt->bindValue(':email_codigo_recuperacao', $email_codigo_recuperacao);
                $stmt->bindValue(':data_codigo_recuperacao', $data_codigo_recuperacao);
                $stmt->bindValue(':status_codigo_recuperacao', $status_codigo_recuperacao);
                $stmt->bindValue(':cod_validador_codigo_recuperacao', $cod_validador_codigo_recuperacao);
        
                $stmt->execute();
        
            } catch (PDOException $e) {
                throw new Exception('Erro ao inserir o código de recuperação: ' . $e->getMessage());
            }
    }

    public function consulta_codigo($email_codigo_recuperacao, $status_codigo_recuperacao, $data_codigo_recuperacao, $cod_validador_codigo_recuperacao){
        $query = "SELECT * FROM tb_codigo_recuperacao WHERE email_codigo_recuperacao = :email_codigo_recuperacao AND status_codigo_recuperacao = :status_codigo_recuperacao AND data_codigo_recuperacao = :data_codigo_recuperacao AND cod_validador_codigo_recuperacao = :cod_validador_codigo_recuperacao LIMIT 1";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':email_codigo_recuperacao', $email_codigo_recuperacao);
            $stmt->bindValue(':status_codigo_recuperacao', $status_codigo_recuperacao);
            $stmt->bindValue(':data_codigo_recuperacao', $data_codigo_recuperacao);
            $stmt->bindValue(':cod_validador_codigo_recuperacao', $cod_validador_codigo_recuperacao);

            $r = [];
            $stmt->execute();
            return $r = $stmt->fetch(PDO::FETCH_ASSOC);  

        } catch (PDOException $e) {
            throw new Exception('Erro ao inserir o código de recuperação: ' . $e->getMessage());
        }

    }

    public function atualiza_status($status_codigo_recuperacao, $id_codigo_recuperacao){
        $query = "UPDATE tb_codigo_recuperacao SET status_codigo_recuperacao = :status_codigo_recuperacao WHERE id_codigo_recuperacao = :id_codigo_recuperacao";

        try{
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':status_codigo_recuperacao', $status_codigo_recuperacao);
            $stmt->bindValue(':id_codigo_recuperacao', $id_codigo_recuperacao);

            $stmt->execute();
        } catch(PDOException $e){
            throw new Exception('Erro ao inserir o código de recuperação: ' . $e->getMessage());
        }
    }


}


// Função para gerar um token aleatório
function gerarTokenCSRF()
{
    return bin2hex(random_bytes(32));
}

// Função para verificar o token
function verificarTokenCSRF()
{
    if (!isset($_POST['csrf_token'])  || $_POST['csrf_token'] !== $_POST['csrf_token']) {
        header("Location: ../login.php?status=Ataque_CSRF_detectado");
        die('Ataque CSRF detectado!');
    }
}

function verificaSessao($mensagemErro = 'Sessão inválida. Faça login novamente.')
{
    if (!isset($_SESSION) || !isset($_SESSION['csrf_token'])) {
        // Verificar se o token CSRF enviado na requisição é válido (se aplicável)
        if (empty($_SESSION['csrf_token'])) {
            $mensagemErro = 'Token CSRF inválido. Possível ataque.';
        }

        // Redirecionar para a página de login com a mensagem de erro personalizada
        header("Location: login.php?status=$mensagemErro");
        die();
    }
}
