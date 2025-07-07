<?php
require('../../vendor/autoload.php');

use Models\TaskModel;
use Controllers\TaskController;
use Database\{Database, TaskDAO};

try {
    $Database = new Database("Localhost", "Tasks", "root", "");
} catch (\PDOException $e) {
    echo $e->getMessage();
}

$TaskDAO = new TaskDAO($Database);
$TaskModel = new TaskModel();

$TaskController = new TaskController();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Charset e viewport -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Título, Ícone, Descrição e Cor de tema p/ navegador -->
    <title>Título</title>
    <link rel="icon" type="image/x-icon" href="">
    <meta name="description" content="">
    <meta name="theme-color" content="#FFFFFF">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome JS -->
    <script src="https://kit.fontawesome.com/6afdaad939.js" crossorigin="anonymous">      </script>
    <!-- Folha CSS-->
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-11 col-md-6 py-4">
                <header>
                    <nav class="d-flex justify-content-between align-items-center">
                        <h1 class="dm-sans-bold d-inline">Atualizar Tarefa</h1>
                        <a class="btn btn-secondary" href="../../public/index.php"><h1 class="dm-sans-bold d-inline"><i class="fa-solid fa-xmark fa-sm"></i></h1></a>
                    </nav>
                </header>
                <main>
                    <?php 
                        $TaskUpdateData = $TaskModel->getUpdateDataFromPOST();
                        try {
                            $TaskController->updateTask($TaskModel, $TaskDAO, $TaskUpdateData);
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }

                        try {
                            $TaskController->showUpdateDeleteTaskForm($TaskDAO);
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        
                        try {
                            $TaskController->deleteTask($TaskModel, $TaskDAO);
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                    ?>
                </main>
            </div>
        </div>
    </div>
</body>
</html>