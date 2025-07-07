<?php
declare(strict_types=1);

namespace Database;

/**
 * Classe DAO para operações com tarefas no banco de dados.
 *
 * Fornece métodos para criar, atualizar, excluir e recuperar tarefas do banco de dados.
 *
 * @author Arthur Vieira <aprendizadoarthur@gmail.com>
 */
class TaskDAO
{
    /**
     * Instância da conexão com o banco de dados.
     *
     * @var Database
     */
    private $db;

    /**
     * Construtor da classe TaskDAO.
     *
     * Inicializa a instância do banco de dados para operações.
     *
     * @param Database $db Instância da classe Database para conexão.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    /**
     * Cria uma nova tarefa no banco de dados.
     *
     * Insere uma nova tarefa com título, descrição e status inicial 'to-do'.
     *
     * @param string $title Título da tarefa.
     * @param string $description Descrição da tarefa.
     * @return void
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function newTaskDB(string $title, string $description) : void
    {
        try {
            $PDO = $this->db->getConnection();
            $res = $PDO->prepare("INSERT INTO tasks (title, description, status) VALUES (:t, :d, :s)");
            $res->bindValue(":t", $title);
            $res->bindValue(":d", $description);
            $res->bindValue(":s", 'to-do');
            $res->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Atualiza uma tarefa existente no banco de dados.
     *
     * Atualiza título, descrição e status de uma tarefa com base no ID fornecido.
     *
     * @param int $id ID da tarefa a ser atualizada.
     * @param string $title Novo título da tarefa.
     * @param string $description Nova descrição da tarefa.
     * @param string $status Novo status da tarefa.
     * @return void
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function updateTaskDB(int $id, string $title, string $description, string $status) : void
    {
        try {
            $PDO = $this->db->getConnection();
            $res = $PDO->prepare("UPDATE tasks SET title = :t, description = :d, status = :s WHERE id = :i");
            $res->bindValue(":t", $title);
            $res->bindValue(":d", $description);
            $res->bindValue(":s", $status);
            $res->bindValue(":i", $id);
            $res->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Exclui uma tarefa do banco de dados.
     *
     * Remove uma tarefa com base no ID fornecido.
     *
     * @param int $id ID da tarefa a ser excluída.
     * @return void
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function deleteTaskDB(int $id) : void
    {
        try {
            $PDO = $this->db->getConnection();
            $res = $PDO->prepare("DELETE FROM tasks WHERE id = :i");
            $res->bindValue(":i", $id);
            $res->execute();
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Verifica se uma tarefa existe no banco de dados pelo ID.
     *
     * Retorna true se a tarefa existe, false caso contrário.
     *
     * @param int $id ID da tarefa a ser verificada.
     * @return bool True se a tarefa existe, false se não existe.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function verifyByIdTaskExistsDB(int $id) : bool
    {
        try {
            $PDO = $this->db->getConnection();
            $res = $PDO->prepare("SELECT COUNT(*) AS total FROM tasks WHERE id = :i");
            $res->bindValue(":i", $id);
            $res->execute();
            $data = $res->fetch(\PDO::FETCH_ASSOC);
            $bool = $data['total'] == 0 ? false : true;
            return $bool;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    
    /**
     * Recupera todas as tarefas do banco de dados.
     *
     * Retorna um array com todas as tarefas ordenadas por status (ascendente).
     *
     * @return array Array associativo com os dados de todas as tarefas.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function getAllTasksDataDB() : array
    {
        try {
            $PDO = $this->db->getConnection();
            $res = $PDO->prepare("SELECT * FROM tasks ORDER BY status ASC");
            $res->execute();
            $data = $res->fetchAll(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Recupera os dados de uma tarefa específica pelo ID.
     *
     * Retorna um array com os dados da tarefa correspondente ao ID fornecido.
     *
     * @param int $id ID da tarefa a ser recuperada.
     * @return array Array associativo com os dados da tarefa.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function getAllTaskDataByID(int $id) : array
    {
        try {
            $PDO = $this->db->getConnection();
            $res = $PDO->prepare("SELECT * FROM tasks WHERE id = :i");
            $res->bindValue(":i", $id);
            $res->execute();
            $data = $res->fetch(\PDO::FETCH_ASSOC);
            return $data;
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }
}