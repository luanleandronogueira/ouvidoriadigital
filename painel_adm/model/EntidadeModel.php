<?php

require_once 'ConexaoModel.php';

class Entidade
{

    private int $id;
    private Conexao $conexao;
    private $conn;
    private $nome_entidade;
    private $email_entidade;
    private $telefone_entidade;
    private $id_portal_entidade;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conn = $this->conexao->Conectar();
    }

    public function chama_nome_entidade($id)
    {
        try {

            $query = "SELECT nome_entidade FROM tb_entidades WHERE id_entidade  = :id_entidade";

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id_entidade', $id);

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao chamar os dados: ' . $e->getMessage());
        }
    }
}
