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

$id_medico = $_SESSION['id'];

$query = "SELECT id, nome, email, crm FROM medicos WHERE id = :id_medico";
$dadosMedico = $conn->prepare($query);
$dadosMedico->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
$dadosMedico->execute();
$infoMedico = $dadosMedico->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Info Médico - Agenda Fácil</title>
    <link rel="stylesheet" href="../assets/css/styleDashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>


    <?php
    if (isset($_SESSION['success_message'])) {
        include_once '../Alerts/toastsSuccess.php';
        unset($_SESSION['success_message']);
    } else if (isset($_SESSION['error_message'])) {
        include_once '../Alerts/toastsError.php';
        unset($_SESSION['error_message']);
    }
    ?>

<?php include '../../navigation.php'; ?>
<div class="main">
    <?php include '../../topbar.php'; ?>

    <div class="app_container">

        <fieldset class="border rounded-3 p-3">
            <legend class="float-none w-auto px-3">Meus Dados</legend>

            <div class="row">
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="editMedico.php?id=<?= $infoMedico['id']; ?>" class="btn btn-success btn-sm">
                        <ion-icon name="create-outline"></ion-icon> Editar
                    </a>
                </div>
            </div>

            <div class="container">
                <h5>Informações Pessoais</h5>
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control inputOnlyRead" value="<?= $infoMedico['nome'] ?>">
                            <label>Nome</label>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control inputOnlyRead" value="<?= $infoMedico['email'] ?>">
                            <label>Email</label>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-6 mb-4">
                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control inputOnlyRead" value="<?= $infoMedico['crm'] ?>">
                            <label>CRM</label>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
