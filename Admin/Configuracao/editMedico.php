<?php
session_start();
ob_start();
include_once '../../conexao.php';

if ((!isset($_SESSION['id'])) and (!isset($_SESSION['usuario']))) {
    $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Necessário realizar login!</p>";
    header("Location: ../../index.php");
    exit();
}

$selectedMenu = 'configuracao';

if (isset($_GET['id'])) {
    $id_medico = $_GET['id'];

    $queryInfo = $conn->prepare("SELECT id, nome, email, crm FROM medicos WHERE id = :id");
    $queryInfo->bindParam(':id', $id_medico, PDO::PARAM_INT);
    $queryInfo->execute();
    $infoMedico = $queryInfo->fetch(PDO::FETCH_ASSOC);

    if (!$infoMedico) {
        $_SESSION['msg'] = "Médico não encontrado!";
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    $_SESSION['msg'] = "Erro: ID não enviado!";
    header("Location: ../dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Médico - Agenda Fácil</title>
    <link rel="stylesheet" href="../assets/css/styleDashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include '../../navigation.php'; ?>

<div class="main">
    <?php include '../../topbar.php'; ?>

    <div class="app_container">

        <div class="row">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <a title="Voltar Página" href="configuracao.php"><ion-icon style="font-size: 25px;color: #2dc997;" name="caret-back-outline"></ion-icon></a>
                    <li class="breadcrumb-item"><a class="styleCrumb" href="configuracao.php">Info Médico</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Editar Médico</li>
                </ol>
            </nav>
        </div>

        <fieldset class="border rounded-3 p-3">
            <legend class="float-none w-auto px-3">Editar Médico</legend>

            <form method="POST" action="modelConfiguracao.php">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="submit" name="editMedico" class="btn btn-success">
                            <ion-icon name="create-outline"></ion-icon> Salvar
                        </button>
                    </div>
                </div>

                <div class="container">
                    <h5>Informações Pessoais</h5>
                    <div class="row">
                        <input type="hidden" name="inputId" value="<?= $infoMedico['id']; ?>">

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" name="inputNome" class="form-control" value="<?= $infoMedico['nome']; ?>" required>
                                <label>Nome</label>
                            </div>
                        </div>

                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="email" name="inputEmail" class="form-control" value="<?= $infoMedico['email']; ?>" required>
                                <label>Email</label>
                            </div>
                        </div>

                        <div class="col-xl-2 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" name="inputCRM" class="form-control" value="<?= $infoMedico['crm']; ?>" required>
                                <label>CRM</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </fieldset>
    </div>
</div>

<script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
