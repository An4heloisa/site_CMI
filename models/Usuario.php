<?php
class Usuario {
    private $conn;
    private $table_name = "usuario";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para autenticação via CPF e Senha (RF02)
    public function autenticar($cpf, $senha) {
        $query = "SELECT id, nome, email, cpf, senha, perfil FROM " . $this->table_name . " WHERE cpf = :cpf LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            // Em produção, use password_verify($senha, $row['senha'])
            if ($senha === $row['senha']) { 
                return $row;
            }
        }
        return false;
    }

    // Método para registar novo utilizador (Professor ou Aluno) - RF01
    public function cadastrar($nome, $email, $cpf, $senha, $data_nascimento, $perfil, $extra_info = []) {
    try {
        $this->conn->beginTransaction();

        // 1. Inserção na tabela base 'usuario'
        $queryUser = "INSERT INTO " . $this->table_name . " 
                      (nome, email, cpf, senha, data_nascimento, perfil) 
                      VALUES (:nome, :email, :cpf, :senha, :data_nascimento, :perfil)";
        
        $stmtUser = $this->conn->prepare($queryUser);
        $stmtUser->bindParam(':nome', $nome);
        $stmtUser->bindParam(':email', $email);
        $stmtUser->bindParam(':cpf', $cpf);
        $stmtUser->bindParam(':senha', $senha); // Em produção, aplicar password_hash()
        $stmtUser->bindParam(':data_nascimento', $data_nascimento);
        $stmtUser->bindParam(':perfil', $perfil);
        $stmtUser->execute();

        $usuario_id = $this->conn->lastInsertId();

        // 2. Inserção na tabela correspondente ao perfil
        if ($perfil === 'Aluno') {
            // Regra RN01 (Idade mínima de 50 anos) é validada automaticamente pela Trigger do MySQL
            $queryAluno = "INSERT INTO aluno (usuario_id, matricula, turma_id) VALUES (:usuario_id, :matricula, :turma_id)";
            $stmtAluno = $this->conn->prepare($queryAluno);
            $stmtAluno->bindParam(':usuario_id', $usuario_id);
            $stmtAluno->bindParam(':matricula', $extra_info['matricula']);
            $stmtAluno->bindParam(':turma_id', $extra_info['turma_id']);
            $stmtAluno->execute();
        } else if ($perfil === 'Professor') {
            $queryProf = "INSERT INTO professor (usuario_id, departamento) VALUES (:usuario_id, :departamento)";
            $stmtProf = $this->conn->prepare($queryProf);
            $stmtProf->bindParam(':usuario_id', $usuario_id);
            $stmtProf->bindParam(':departamento', $extra_info['departamento']);
            $stmtProf->execute();
        }

        $this->conn->commit();
        return true;
    } catch (PDOException $e) {
        $this->conn->rollBack();
        // Captura mensagem de erro da Trigger de idade (< 50 anos)
        throw new Exception($e->getMessage());
    }
}
}