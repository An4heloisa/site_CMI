<?php
class Atividade {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function listarPorAluno($aluno_id) {
        $query = "SELECT a.id, a.titulo, a.descricao, a.data_entrega, 
                         COALESCE(p.status, 'Pendente') AS status
                  FROM atividade a
                  LEFT JOIN progresso p ON a.id = p.atividade_id AND p.aluno_id = :aluno_id
                  ORDER BY a.data_entrega ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->execute();

        $pendentes = [];
        $concluidas = [];

        while ($row = $stmt->fetch()) {
            if ($row['status'] === 'Finalizada') {
                $concluidas[] = $row;
            } else {
                $pendentes[] = $row;
            }
        }

        return ['pendentes' => $pendentes, 'concluidas' => $concluidas];
    }
}