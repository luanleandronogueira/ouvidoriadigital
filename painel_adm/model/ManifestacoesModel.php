<?php

require_once 'ConexaoModel.php';

/**
 * Classe responsável por gerenciar as manifestações no sistema.
 * * ATENÇÃO: Novas funções foram adicionadas para atender aos requisitos
 * de análises e dashboard, sem alterar as funções já existentes.
 */
class Manifestacoes
{

    private int $id_manifestacao;
    private Conexao $conexao;
    private $conn;
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
        $this->conn = $this->conexao->Conectar();
    }

    // --- FUNÇÕES EXISTENTES (NÃO ALTERADAS) ---

    public function chama_manifestacao_protocolo($protocolo_manifestacao)
    {
        $query = "SELECT m.* , tm.nome_tipo_manifestacao, e.nome_entidade, u.nome_usuario, u.sobrenome_usuario, l.latitude, l.longitude, l.ip
          FROM tb_manifestacoes m
          JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao 
          JOIN tb_tipo_manifestacoes tm ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
          JOIN tb_usuario u ON m.id_usuario_manifestacao = u.id_usuario
          LEFT JOIN tb_localizacao l ON m.id_manifestacao = l.manifestacao_id 
          WHERE m.protocolo_manifestacao = :protocolo_manifestacao";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':protocolo_manifestacao', $protocolo_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao_lista($id_entidade_manifestacao)
    {
        $query = "SELECT protocolo_manifestacao, id_manifestacao, data_manifestacao, status_manifestacao FROM tb_manifestacoes WHERE id_entidade_manifestacao = :id_entidade_manifestacao ORDER BY data_manifestacao DESC LIMIT 5";

        try {

            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao($id_entidade_manifestacao)
    {
        $query = "SELECT m.* , tm.nome_tipo_manifestacao, e.nome_entidade
                FROM tb_manifestacoes m
                JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao JOIN tb_tipo_manifestacoes tm ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
                WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao ORDER BY m.data_manifestacao DESC";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao_anonima($id_entidade_manifestacao)
    {
        $query = "SELECT m.* , tm.nome_tipo_manifestacao, e.nome_entidade
                FROM tb_manifestacoes m
                JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao JOIN tb_tipo_manifestacoes tm ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
                WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao AND m.id_usuario_manifestacao = 15 ORDER BY m.data_manifestacao DESC";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao_aberto_analise($id_entidade_manifestacao)
    {
        $query = "SELECT m.* , tm.nome_tipo_manifestacao, e.nome_entidade
                FROM tb_manifestacoes m
                JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao JOIN tb_tipo_manifestacoes tm ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
                WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao AND m.status_manifestacao != 'Concluído' ORDER BY m.data_manifestacao DESC";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

    public function chama_manifestacao_concluida($id_entidade_manifestacao)
    {
        $query = "SELECT m.* , tm.nome_tipo_manifestacao, e.nome_entidade
                FROM tb_manifestacoes m
                JOIN tb_entidades e ON e.id_entidade = m.id_entidade_manifestacao JOIN tb_tipo_manifestacoes tm ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
                WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao AND m.status_manifestacao = 'Concluído' ORDER BY m.data_manifestacao DESC";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);

            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao);
            $stmt->execute();

            $r = [];

            return $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro chamar a manifestação: ' . $e->getMessage());
        }
    }

    

    // --- NOVAS FUNÇÕES PARA ANÁLISE E DASHBOARD ---

    /**
     * Retorna a contagem total de manifestações para a entidade especificada.
     * @param int $id_entidade_manifestacao O ID da entidade.
     * @return int O número total de manifestações.
     */
    public function getTotalManifestacoes(int $id_entidade_manifestacao): int
    {
        $query = "SELECT COUNT(*) FROM tb_manifestacoes WHERE id_entidade_manifestacao = :id_entidade_manifestacao";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao buscar o total de manifestações: ' . $e->getMessage());
        }
    }

    /**
     * Retorna a contagem de manifestações com um status específico ('A' para Aberto, 'F' para Finalizado, etc.).
     * @param int $id_entidade_manifestacao O ID da entidade.
     * @param string $status O status da manifestação ('A', 'F', etc.).
     * @return int O número de manifestações com o status especificado.
     */
    public function getTotalManifestacoesPorStatus(int $id_entidade_manifestacao, string $status): int
    {
        $query = "SELECT COUNT(*) FROM tb_manifestacoes WHERE id_entidade_manifestacao = :id_entidade_manifestacao AND status_manifestacao = :status";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao buscar o total de manifestações por status: ' . $e->getMessage());
        }
    }

    /**
     * Retorna a contagem de manifestações consideradas anônimas.
     * * ATENÇÃO: Assume-se que 'anônimo' corresponde a um ID de usuário específico, como 1,
     * que é comumente usado como placeholder para usuários não logados/anônimos.
     * Se a lógica for diferente (por exemplo, id_usuario_manifestacao = NULL ou outro valor),
     * a condição SQL deve ser ajustada.
     * * @param int $id_entidade_manifestacao O ID da entidade.
     * @return int O número de manifestações anônimas.
     */
    public function getTotalManifestacoesAnonimas(int $id_entidade_manifestacao): int
    {
        // Se a entidade usa um ID de usuário específico (ex: 1) para anônimos
        $id_usuario_anonimo = 15;

        $query = "SELECT COUNT(*) FROM `tb_manifestacoes` WHERE `id_entidade_manifestacao` = :id_entidade_manifestacao AND `id_usuario_manifestacao` = :id_usuario_anonimo ORDER BY id_manifestacao DESC;";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->bindValue(':id_usuario_anonimo', $id_usuario_anonimo, PDO::PARAM_INT);
            $stmt->execute();
            return (int)$stmt->fetchColumn();
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao buscar o total de manifestações anônimas: ' . $e->getMessage());
        }
    }

    /**
     * Retorna a contagem de manifestações agrupadas por mês e ano.
     * @param int $id_entidade_manifestacao O ID da entidade.
     * @return array Um array de resultados com 'mes', 'ano' e 'total'.
     */
    public function getManifestacoesPorMes(int $id_entidade_manifestacao): array
    {
        // Assume-se MySQL para as funções MONTH() e YEAR()
        $query = "SELECT MONTH(data_manifestacao) as mes, YEAR(data_manifestacao) as ano, COUNT(*) as total 
                  FROM tb_manifestacoes 
                  WHERE id_entidade_manifestacao = :id_entidade_manifestacao
                  GROUP BY ano, mes 
                  ORDER BY ano ASC, mes ASC";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao buscar manifestações por mês: ' . $e->getMessage());
        }
    }

    /**
     * Retorna a contagem de manifestações agrupadas por tipo (ELOGIO, RECLAMAÇÃO, etc.) - Sugestão criativa.
     * @param int $id_entidade_manifestacao O ID da entidade.
     * @return array Um array de resultados com 'nome_tipo_manifestacao' e 'total'.
     */
    public function getManifestacoesPorTipo(int $id_entidade_manifestacao): array
    {
        $query = "SELECT tm.nome_tipo_manifestacao, COUNT(m.id_manifestacao) as total
                  FROM tb_tipo_manifestacoes tm
                  LEFT JOIN tb_manifestacoes m ON m.id_tipo_manifestacao = tm.id_tipo_manifestacao 
                                              AND m.id_entidade_manifestacao = :id_entidade_manifestacao
                  GROUP BY tm.id_tipo_manifestacao, tm.nome_tipo_manifestacao
                  ORDER BY total DESC";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Tratar exceções
            throw new Exception('Erro ao buscar manifestações por tipo: ' . $e->getMessage());
        }
    }

    public function getContagemAnonimasIdentificadas(int $id_entidade_manifestacao): array
    {
        // A query abaixo SIMULA que 'id_usuario' = 0 ou um campo 'anonima' = 'S'
        // indica uma manifestação anônima. Por favor, ajuste a condição WHERE
        // de acordo com a sua estrutura REAL de banco de dados.
        $query = "SELECT SUM(CASE WHEN m.id_usuario_manifestacao = 15 THEN 1 ELSE 0 END) as anonimas,
                         SUM(CASE WHEN m.id_usuario_manifestacao != 15 THEN 1 ELSE 0 END) as identificadas
                  FROM tb_manifestacoes m
                  WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->execute();
            // Retorna um único objeto com as contagens
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar contagem de manifestações (anônimas/identificadas): ' . $e->getMessage());
        }
    }

    public function getManifestacoesIdentificadas(int $id_entidade_manifestacao){

        $query = "SELECT COUNT(*) FROM `tb_manifestacoes` WHERE `id_entidade_manifestacao` = :id_entidade_manifestacao AND `id_usuario_manifestacao` != 15";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->execute();
            // Retorna um único objeto com as contagens
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Erro ao buscar contagem de manifestações (anônimas/identificadas): ' . $e->getMessage());
        }

    }

    public function getContagemRespostas(int $id_entidade_manifestacao): array
    {
        // Consulta 1.1: Contagem total de Manifestações
        $totalManifestacoesQuery = "
            SELECT COUNT(id_manifestacao) AS total
            FROM tb_manifestacoes
            WHERE id_entidade_manifestacao = :id_entidade_manifestacao
        ";

        // Consulta 1.2: Contagem de Manifestações Respondidas
        $respondidasQuery = "
            SELECT COUNT(DISTINCT m.id_manifestacao) AS respondidas
            FROM tb_manifestacoes m
            INNER JOIN tb_respostas_manifestacoes r ON m.id_manifestacao = r.id_manifestacao
            WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao
        ";

        try {
            $conn = $this->conexao->Conectar();

            // 1. Busca Respondidas
            $stmtRespondidas = $conn->prepare($respondidasQuery);
            $stmtRespondidas->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmtRespondidas->execute();
            $respondidas = $stmtRespondidas->fetchColumn();

            // 2. Busca Total
            $stmtTotal = $conn->prepare($totalManifestacoesQuery);
            $stmtTotal->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmtTotal->execute();
            $total = $stmtTotal->fetchColumn();

            // 3. Calcula Não Respondidas
            $naoRespondidas = $total - $respondidas;

            return [
                'respondidas' => (int)$respondidas,
                'nao_respondidas' => (int)$naoRespondidas,
                'total' => (int)$total,
            ];

        } catch (PDOException $e) {
            // Em ambiente de produção, logar o erro e retornar um array vazio ou lançar uma exceção genérica.
            throw new Exception('Erro ao buscar contagem de manifestações respondidas: ' . $e->getMessage());
        }
    }

    public function getManifestacoesNaoRespondidasPorTipo(int $id_entidade_manifestacao): array
    {
        $query = "
            SELECT
                t.nome_tipo_manifestacao,
                COUNT(m.id_manifestacao) AS total_nao_respondidas
            FROM tb_manifestacoes m
            
            INNER JOIN tb_tipo_manifestacoes t ON m.id_tipo_manifestacao = t.id_tipo_manifestacao
            
            -- LEFT JOIN e IS NULL é a chave para encontrar as manifestações sem resposta
            LEFT JOIN tb_respostas_manifestacoes r ON m.id_manifestacao = r.id_manifestacao
            
            WHERE m.id_entidade_manifestacao = :id_entidade_manifestacao
              AND r.id_resposta_manifestacoes IS NULL 
              
            GROUP BY t.nome_tipo_manifestacao
            ORDER BY total_nao_respondidas DESC
        ";

        try {
            $conn = $this->conexao->Conectar();
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_entidade_manifestacao', $id_entidade_manifestacao, PDO::PARAM_INT);
            $stmt->execute();
            
            // Retorna a lista de objetos { nome_tipo_manifestacao, total_nao_respondidas }
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Em ambiente de produção, logar o erro.
            throw new Exception('Erro ao buscar manifestações não respondidas por tipo: ' . $e->getMessage());
        }
    }
}
