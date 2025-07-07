<?php
declare(strict_types=1);

namespace Models;

/**
 * Modelo para manipulação de dados de tarefas.
 *
 * Fornece métodos para recuperar e validar dados de tarefas a partir de requisições POST.
 *
 * @author Arthur Vieira <aprendizadoarthur@gmail.com>
 */
class TaskModel
{
    /**
     * ID da tarefa.
     *
     * @var int
     */
    private int $id;

    /**
     * Título da tarefa.
     *
     * @var string
     */
    private string $title;

    /**
     * Descrição da tarefa.
     *
     * @var string
     */
    private string $description;

    /**
     * Status da tarefa.
     *
     * @var string
     */
    private string $status;

    /**
     * Trait para métodos de autenticação de tarefas.
     */
    use \Traits\TaskAuth;

    /**
     * Construtor da classe TaskModel.
     *
     * Inicializa uma instância vazia do modelo de tarefa.
     *
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function __construct()
    {
    }

    /**
     * Recupera dados de registro de uma nova tarefa a partir de uma requisição POST.
     *
     * Valida e sanitiza os dados de título e descrição enviados via POST.
     *
     * @return array Array associativo com título e descrição da tarefa, ou array vazio se a requisição não for válida.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function getRegisterDataFromPOST() : array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-create'])) {
            $title = htmlspecialchars(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
            $description = htmlspecialchars(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
            return [
                'title' => $title,
                'description' => $description
            ];
        }
        return [];
    }

    /**
     * Recupera dados de atualização de uma tarefa a partir de uma requisição POST.
     *
     * Valida e sanitiza os dados de título, descrição e status enviados via POST.
     *
     * @return array Array associativo com título, descrição e status da tarefa, ou array vazio se a requisição não for válida.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function getUpdateDataFromPOST() : array
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-update'])) {
            $title = htmlspecialchars(filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING));
            $description = htmlspecialchars(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
            $status = htmlspecialchars(filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING));

            return [
                'title' => $title,
                'description' => $description,
                'status' => $status
            ];
        }
        return [];
    }
}