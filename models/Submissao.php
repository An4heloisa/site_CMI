<?php
class Submissao {
    private $conn;
    private $table_name = "progresso";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function enviarAtividade($aluno_id, $atividade_id, $texto_resposta, $arquivo_resposta) {
        $checkQuery = "SELECT id FROM " . $this->table_name . " WHERE aluno_id = :aluno_id AND atividade_id = :atividade_id";
        $stmtCheck = $this->conn->prepare($checkQuery);
        $stmtCheck->bindParam(':aluno_id', $aluno_id);
        $stmtCheck->bindParam(':atividade_id', $atividade_id);
        $stmtCheck->execute();

        $data_envio = date('Y-m-d H:i:s');
        $status = 'Enviada / Aguardando Avaliacao';

        if ($stmtCheck->rowCount() > 0) {
            $query = "UPDATE " . $this->table_name . " 
                      SET texto_resposta = :texto, arquivo_resposta = :arquivo, status = :status, data_envio = :data_envio 
                      WHERE aluno_id = :aluno_id AND atividade_id = :atividade_id";
        } else {
            $query = "INSERT INTO " . $this->table_name . " 
                      (aluno_id, atividade_id, texto_resposta, arquivo_resposta, status, data_envio) 
                      VALUES (:aluno_id, :atividade_id, :texto, :arquivo, :status, :data_envio)";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':atividade_id', $atividade_id);
        $stmt->bindParam(':texto', $texto_resposta);
        $stmt->bindParam(':arquivo', $arquivo_resposta);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':data_envio', $data_envio);

        return $stmt->execute();
    }
}