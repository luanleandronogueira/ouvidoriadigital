<?php

require_once 'ConexaoModel.php';

class UsuarioAdm
{

    private int $id;
    private $conexao;
    private $conn;
    private $usuario;
    private $cpf;
    private $email;
    private $nivel_acesso;
    private $status_atividade;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conn = $this->conexao->Conectar();
        $this->status_atividade = 'A';
    }

    public function consulta_usuario_adm($login_usuario)
    {

        if (strlen($login_usuario) <= 11) {

            $query = "SELECT * FROM tb_usuario_adm WHERE cpf = :login_usuario LIMIT 1";
        } else {

            $query = "SELECT * FROM tb_usuario_adm WHERE email = :login_usuario LIMIT 1";
        }

        try {

            $stmt = $this->conn->prepare($query);

            $stmt->bindValue(':login_usuario', $login_usuario);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao consultar CPF: ' . $e->getMessage());
        }
    }

    public function chama_usuario($id) 
    {
        $query = "SELECT usuario, cpf, email, nivel_acesso, status_atividade FROM tb_usuario_adm WHERE id = :id";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar o usuários: ' . $e->getMessage());
        }
    }

    public function chama_usuarios() 
    {
        $query = "SELECT id, usuario, cpf FROM tb_usuario_adm";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            //$stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar o usuários: ' . $e->getMessage());
        }
    }

    public function chama_usuario_nivel_acesso($id) 
    {
        $query = "SELECT nivel_acesso FROM tb_usuario_adm WHERE id = :id";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar o usuários: ' . $e->getMessage());
        }
    }

    public function consulta_senha($id)
    {
        $query = "SELECT senha FROM tb_usuario_adm WHERE id = :id";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar o usuários: ' . $e->getMessage());
        }
    }

    public function chama_cpf($id)
    {
        $query = "SELECT cpf, email FROM tb_usuario_adm WHERE id = :id LIMIT 1";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar o usuários: ' . $e->getMessage());
        }
    }

    public function consulta_cpf($cpf)
    {
        $query = "SELECT COUNT(*) as total FROM tb_usuario_adm WHERE cpf = :cpf";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':cpf', $cpf);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];

        } catch (PDOException $e) {
            throw new Exception('Erro ao contar os usuários: ' . $e->getMessage());
        }
    }

    public function consulta_email($email)
    {
        $query = "SELECT COUNT(*) as total FROM tb_usuario_adm WHERE email = :email";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':email', $email);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];

        } catch (PDOException $e) {
            throw new Exception('Erro ao contar os usuários: ' . $e->getMessage());
        }
    }

    public function altera_senha_usuario($id, $senha)
    {
        $query = "UPDATE tb_usuario_adm SET senha = :senha WHERE id = :id";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':senha', $senha);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao mudar a senha: ' . $e->getMessage());
        }
    }

    public function altera_dados_usuario_adm($id, $usuario, $nivel_acesso, $status_atividade)
    {
        $query = "UPDATE tb_usuario_adm SET usuario = :usuario, nivel_acesso = :nivel_acesso, status_atividade = :status_atividade WHERE id = :id";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':usuario', $usuario);
            $stmt->bindValue(':nivel_acesso', $nivel_acesso);
            $stmt->bindValue(':status_atividade', $status_atividade);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao mudar o dados: ' . $e->getMessage());
        }
    }

    public function altera_dados_usuario($id, $nome, $email)
    {
        $query = "UPDATE tb_usuario_adm SET usuario = :usuario, email = :email WHERE id = :id";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':usuario', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->execute();

            return true;

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao mudar o dados: ' . $e->getMessage());
        }
    }

    public function inclui_novo_usuario($usuario, $cpf, $senha, $email, $nivel_acesso)
    {
        $query = "INSERT INTO tb_usuario_adm (usuario, cpf, senha, email, nivel_acesso, status_atividade) VALUES (:usuario, :cpf, :senha, :email, :nivel_acesso, :status_atividade)";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':usuario', $usuario);
            $stmt->bindValue(':cpf', $cpf);
            $stmt->bindValue(':senha', $senha);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':nivel_acesso', $nivel_acesso);
            $stmt->bindValue(':status_atividade', $this->status_atividade);
            $stmt->execute();
            
            $id = $conn->lastInsertId();
            return $id;

        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao cadastrar o usuario: ' . $e->getMessage());
        }
    }

}
