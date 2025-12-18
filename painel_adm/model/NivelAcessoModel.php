<?php 

require_once 'ConexaoModel.php';

class NivelAcessoAdm {

    private int $id;
    private Conexao $conexao;
    private $conn;
    private $id_usuario_adm;
    private $id_entidade;
    private $status_ativo;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conn = $this->conexao->Conectar();
        $this->status_ativo = 'S';
    }

    public function consulta_nivel_acesso($id)
    {
        $query = "SELECT na.id_entidade, e.nome_entidade, e.id_entidade FROM tb_nivel_acesso na JOIN tb_entidades e ON e.id_entidade = na.id_entidade WHERE na.id_usuario_adm = :id ORDER BY e.nome_entidade ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function nivel_acesso_adm()
    {
        $query = "SELECT id_entidade, nome_entidade, id_portal_entidade FROM tb_entidades ORDER BY nome_entidade ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function inclui_nivel_acesso($id_usuario_adm, $id_entidade)
    {
        $query = "INSERT INTO tb_nivel_acesso (id_usuario_adm, id_entidade, status_ativo) VALUES (:id_usuario_adm, :id_entidade, :status_ativo)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_usuario_adm', $id_usuario_adm);
        $stmt->bindValue(':id_entidade', $id_entidade);
        $stmt->bindValue(':status_ativo', $this->status_ativo);
        $stmt->execute();

        return true;
    }

    public function exclui_nivel_acesso($id_usuario_adm, $id_entidade)
    {
        $query = "DELETE FROM tb_nivel_acesso WHERE id_usuario_adm = :id_usuario_adm AND id_entidade = :id_entidade";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_usuario_adm', $id_usuario_adm);
        $stmt->bindValue(':id_entidade', $id_entidade);
        $stmt->execute();

        return true;
    }

    public function consulta_nivel($id, $id_nivel)
    {
        $query = "SELECT COUNT(*) as total FROM tb_nivel_acesso WHERE id_usuario_adm = :id AND id_entidade = :id_nivel";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_nivel', $id_nivel);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'];

        } catch (PDOException $e) {
            throw new Exception('Erro ao contar os usuários: ' . $e->getMessage());
        }
    }
}