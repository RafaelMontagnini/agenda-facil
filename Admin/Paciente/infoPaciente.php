<?php
session_start();
ob_start();
include_once '../../conexao.php';

if ((!isset($_SESSION['id'])) and (!isset($_SESSION['usuario']))) {
    header("Location: ../../index.php");
    $_SESSION['msg'] = "<p style='color: #ff0000'>Erro: Necessário realizar login!</p>";
}

$selectedMenu = 'paciente';
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../images/faviconag.png" type="image/x-icon">
    <title>Info Paciente - Agenda Fácil</title>
    <!-- ======= Estilos ====== -->
    <link rel="stylesheet" href="../assets/css/styleDashboard.css">
    <!-- ======= JQUERY ====== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
</script>

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

    <?php

    if (isset($_GET['id'])) {
        $id_paciente = $_GET['id'];

        try {
            $queryInfoPaciente = $conn->query("SELECT
                    *
                FROM 
                    pacientes
                WHERE
                    id = $id_paciente");
        } catch (Exception $e) {
            $_SESSION['error_message'] = "Erro na consulta com o Banco!";
            header("Location: paciente.php");
        }

        $infoPaciente = $queryInfoPaciente->fetch(PDO::FETCH_ASSOC);

        if (empty($infoPaciente['id'])) {
            $_SESSION['error_message'] = "ID do Paciente Inexistente!";
            header("Location: paciente.php");
        }
    } else {
        $_SESSION['error_message'] = "Erro na solicitação GET!";
        header("Location: paciente.php");
    }

    ?>

    <!-- ========================= Menu Navegação ==================== -->
    <?php include '../../navigation.php'; ?>

    <!-- =========== Container =========  -->
    <div class="main">
        <!-- ====================== Barra Superior ==================== -->
        <?php include '../../topbar.php'; ?>

        <!-- ========================= App_Container ==================== -->
        <div class="app_container">

            <div class="row">
                <nav aria-label="breadcrumb">

                    <ol class="breadcrumb">
                        <a title="Voltar Página" href="paciente.php"><ion-icon style="font-size: 25px;color: #2dc997;"
                                name="caret-back-outline"></ion-icon> </a>
                        <li class="breadcrumb-item"><a class="styleCrumb" href="paciente.php">Buscar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Info Paciente</li>
                    </ol>
                </nav>
            </div>

            <fieldset class="border rounded-3 p-3">
                <legend class="float-none w-auto px-3">Dados Paciente</legend>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end">
                        <a href="editPaciente.php?id=<?= $infoPaciente['id']; ?>"
                            class="btn btn-success btn-sm"><ion-icon name="create-outline"></ion-icon> Editar</a>
                        <a href="#" class="btn btn-danger btn-sm ms-2"
                            onclick="confirmarExclusao(<?= $infoPaciente['id']; ?>)"><ion-icon
                                name="trash-outline"></ion-icon> Excluir</a>
                    </div>
                </div>
                <div class="container">
                    <h5>Informações Pessoais</h5>
                    <div class="row ">
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control inputOnlyRead" id="id_nomeInfo"
                                    value="<?= $infoPaciente['nome'] ?>">
                                <label for="id_nomeInfo">Nome</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control inputOnlyRead" id="id_cpfInfo"
                                    value="<?= $infoPaciente['cpf'] ?>">
                                <label for="id_cpfInfo">CPF</label>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control inputOnlyRead"
                                    id="id_dataNascimentoInfo"
                                    value="<?= date('d/m/Y', strtotime($infoPaciente['data_nascimento'])) ?>">
                                <label for="id_dataNascimentoInfo">Data Nascimento</label>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control inputOnlyRead" id="id_emailInfo"
                                    value="<?= $infoPaciente['email'] ?>">
                                <label for="id_emailInfo">E-mail</label>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control inputOnlyRead" id="id_celularInfo"
                                    value="<?= $infoPaciente['celular'] ?>">
                                <label for="id_celularInfo">Celular</label>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-6 col-md-6 mb-4">
                            <div class="form-floating mb-3">
                                <input type="text" readonly class="form-control inputOnlyRead" id="id_sexo"
                                    value="<?= $infoPaciente['sexo'] ?>">
                                <label for="id_sexo">Sexo</label>
                            </div>
                        </div>
                    </div>

                </div>
                </form>
            </fieldset>

        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../assets/js/main.js"></script>

    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este paciente?")) {
                window.location.href = "modelPaciente.php?deletePaciente=" + id;
            }
        }
    </script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
</body>

</html>