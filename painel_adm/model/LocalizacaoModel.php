<?php

require_once 'ConexaoModel.php';

class Localizacao
{

    private int $id;
    private Conexao $conexao;
    private $conn;
    private $manifestacao_id;
    private $latitude;
    private $longitude;
    private $ip;

    public function __construct()
    {
        $this->conexao = new Conexao;
        $this->conn = $this->conexao->Conectar();
    }

    public function chama_localizacao($id_entidade)
    {
        try {

            $query = "SELECT l.id, l.latitude, l.longitude, m.protocolo_manifestacao, m.id_manifestacao
                        FROM tb_localizacao l 
                        JOIN tb_manifestacoes m ON l.manifestacao_id = m.id_manifestacao 
                        WHERE m.id_entidade_manifestacao = :id_entidade"; 

            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id_entidade', $id_entidade);

            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao chamar os dados: ' . $e->getMessage());
        }
    }
}
