<?php
declare(strict_types=1);

namespace Controllers;

use Models\TaskModel;
use Database\TaskDao;

/**
 * Controlador para gerenciamento de tarefas.
 *
 * Responsável por operações de criação, atualização, exclusão e exibição de tarefas.
 *
 * @author Arthur Vieira <aprendizadoarthur@gmail.com>
 */
class TaskController
{
    /**
     * Instância do modelo de tarefa.
     *
     * @var TaskModel
     */
    private $TaskModel;

    /**
     * Instância do DAO de tarefa para operações no banco de dados.
     *
     * @var TaskDAO
     */
    private $TaskDAO;

    /**
     * Trait para métodos de autenticação de tarefas.
     */
    use \Traits\TaskAuth;

    /**
     * Cria uma nova tarefa e a salva no banco de dados.
     *
     * Valida o título e a descrição da tarefa antes de salvar. Redireciona para a página inicial em caso de sucesso.
     *
     * @param TaskModel $TaskModel Instância do modelo de tarefa.
     * @param TaskDAO $TaskDAO Instância do DAO de tarefa.
     * @param array $TaskRegisterData Array associativo contendo título e descrição da tarefa.
     * @return void
     * @throws \Exception Se o título ou a descrição tiverem comprimento inválido.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function newTask(TaskModel $TaskModel, TaskDAO $TaskDAO, array $TaskRegisterData) : void
    {
        $this->TaskModel = $TaskModel;
        $this->TaskDAO = $TaskDAO;

        if (!empty($TaskRegisterData)) {
            if (!$this->TaskModel->AuthTitleLength($TaskRegisterData['title'])) {
                throw new \Exception("Título com formato inválido, deve ter entre 1-20 caracteres.", 1);
            }

            if (!$this->TaskModel->AuthDescriptionLength($TaskRegisterData['description'])) {
                throw new \Exception("Descrição com formato inválido, deve ter entre 1-500 caracteres.", 1);
            }

            $this->TaskDAO->newTaskDB($TaskRegisterData['title'], $TaskRegisterData['description']);
            header("Location: ../../public/index.php");
            exit();
        }
    }

    /**
     * Atualiza uma tarefa existente no banco de dados.
     *
     * Valida o título, a descrição e o ID da tarefa antes de atualizar. Redireciona após a atualização.
     *
     * @param TaskModel $TaskModel Instância do modelo de tarefa.
     * @param TaskDAO $TaskDAO Instância do DAO de tarefa.
     * @param array $TaskUpdateData Array associativo contendo título, descrição e status da tarefa.
     * @return void
     * @throws \Exception Se o título ou a descrição tiverem comprimento inválido.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function updateTask(TaskModel $TaskModel, TaskDAO $TaskDAO, array $TaskUpdateData) : void
    {
        $this->TaskModel = $TaskModel;
        $this->TaskDAO = $TaskDAO;

        if (!empty($TaskUpdateData)) {
            if (!$this->TaskModel->AuthTitleLength($TaskUpdateData['title'])) {
                throw new \Exception("Título com formato inválido, deve ter entre 1-20 caracteres.", 1);
            }

            if (!$this->TaskModel->AuthDescriptionLength($TaskUpdateData['description'])) {
                throw new \Exception("Descrição com formato inválido, deve ter entre 1-500 caracteres.", 1);
            }

            $TaskIDFromGet = $_GET['id'];
            $SanitizedTaskID = $this->SanitizeTaskIDFromGET($TaskIDFromGet);

            $this->TaskDAO->updateTaskDB($SanitizedTaskID, $TaskUpdateData['title'], $TaskUpdateData['description'], $TaskUpdateData['status']);
            header("Location: ");
        }
    }

    /**
     * Exclui uma tarefa do banco de dados.
     *
     * Verifica se a requisição é POST e contém o botão de exclusão. Redireciona para a página inicial após a exclusão.
     *
     * @param TaskModel $TaskModel Instância do modelo de tarefa.
     * @param TaskDAO $TaskDAO Instância do DAO de tarefa.
     * @return void
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function deleteTask(TaskModel $TaskModel, TaskDAO $TaskDAO) : void
    {
        $this->TaskModel = $TaskModel;
        $this->TaskDAO = $TaskDAO;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit-delete'])) {
            $TaskIDFromGet = $_GET['id'];
            $SanitizedTaskID = $this->SanitizeTaskIDFromGET($TaskIDFromGet);

            $this->TaskDAO->deleteTaskDB($SanitizedTaskID);
            header("Location: ../../public/index.php");
            exit();
        }
    }

    /**
     * Exibe o formulário para atualização ou exclusão de uma tarefa.
     *
     * Recupera os dados da tarefa pelo ID e gera um formulário HTML com os dados preenchidos.
     *
     * @param TaskDAO $TaskDAO Instância do DAO de tarefa.
     * @return void
     * @throws \Exception Se a tarefa não existe ou o ID é inválido.
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function showUpdateDeleteTaskForm(TaskDAO $TaskDAO) : void
    {
        $this->TaskDAO = $TaskDAO;

        $TaskIDFromGet = $_GET['id'];
        $SanitizedTaskID = $this->SanitizeTaskIDFromGET($TaskIDFromGet);

        if (!$this->TaskDAO->verifyByIdTaskExistsDB($SanitizedTaskID)) {
            throw new \Exception("Task excluída ou ID inválido");
        }

        $TaskData = $this->TaskDAO->getAllTaskDataByID($SanitizedTaskID);
        $TaskBackground = match ($TaskData['status']) {
            'to-do' => '#ff8181',
            'done' => '#60c088'
        };
        $TaskStatus = match ($TaskData['status']) {
            'to-do' => 'Por Fazer',
            'done' => 'Realizado'
        };

        echo "
            <form method='POST' class=\"form dm-sans-regular\" style=\"background-color: ".$TaskBackground."\">
                <div class=\"form-group\">
                    <label class=\"dm-sans-bold\" for=\"status\">Status</label>
                    <select class=\"form-control\" name=\"status\" id=\"status\">
                        <option value=\"".$TaskData['status']."\">".$TaskStatus."</option>
                        <option value=\"done\">Realizado</option>
                        <option value=\"to-do\">Por Fazer</option>
                    </select>
                </div>
                <div class=\"form-group\">
                    <label class=\"dm-sans-bold\" for=\"title\">Título</label>
                    <input value=\"".$TaskData['title']."\" placeholder=\"Título da tarefa\" class=\"form-control\" type=\"text\" name=\"title\" id=\"title\">
                </div>
                <div class=\"form-group\">
                    <label class=\"dm-sans-bold\" for=\"description\">Descrição</label>
                    <textarea placeholder=\"Descrição da tarefa\" class=\"form-control\" name=\"description\" id=\"description\" rows=\"6\">".$TaskData['description']."</textarea>
                </div>
                <small class=\"dm-sans-light d-block mb-3\">Editado em: ".$TaskData['update_date']."</small>
                <button class=\"btn btn-primary w-100 dm-sans-bold\" type=\"submit\" name=\"submit-update\">Atualizar tarefa</button>
                <button class=\"btn btn-delete mt-2 w-100 dm-sans-bold\" type=\"submit\" name=\"submit-delete\">Deletar tarefa</button>
            </form>";
    }

    /**
     * Exibe todas as tarefas do banco de dados.
     *
     * Recupera todas as tarefas e as exibe em formato de caixas HTML com título, descrição e data de atualização.
     *
     * @param TaskDAO $TaskDAO Instância do DAO de tarefa.
     * @return void
     * @author Arthur Vieira <aprendizadoarthur@gmail.com>
     */
    public function showAllTasks(TaskDAO $TaskDAO) : void
    {
        $this->TaskDAO = $TaskDAO;
        $TaskData = $this->TaskDAO->getAllTasksDataDB();

        foreach ($TaskData as $Task) {
            $TaskBackground = match ($Task['status']) {
                'to-do' => '#ff8181',
                'done' => '#60c088'
            };

            echo '
                <div class="box-task col-12 col-md-5 col-lg-5" style="background-color: '.$TaskBackground.'">
                    <a href="../src/views/Task.php?id='.$Task['id'].'">
                        <h2 class="dm-sans-bold">'.$Task['title'].'</h2>
                        <p class="dm-sans-regular">'.$Task['description'].'</p>
                        <small class="dm-sans-light">Editado em : '.$Task['update_date'].'</small>
                    </a>
                </div>
            ';
        }
    }
}