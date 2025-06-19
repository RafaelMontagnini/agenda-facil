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
    <title>Pacientes - Agenda Fácil</title>
    <!-- ======= Estilo ====== -->
    <link rel="stylesheet" href="../assets/css/styleDashboard.css">
    <!-- ======= JQUERY ====== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#id_cpfBusca').mask('000.000.000-00');
        $('#id_celularBusca').mask('(00) 00000-0000');
    });
</script>
<style type="text/css">
    .table-responsive {
        overflow-x: auto;
    }

    .table-responsive table {
        width: 100%;
    }


    @media (min-width: 768px) {
        .table-responsive table td {
            display: table-cell;
            width: auto;
        }
    }


    @media (max-width: 767px) {
        .table-responsive table td {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
        }

        .table-responsive table th {
            display: none;
        }
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

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

    <!-- ========================= Menu Navegação ==================== -->
    <?php include '../../navigation.php'; ?>

    <!-- =========== Container =========  -->
    <div class="main">
        <!-- ====================== Barra Superior ==================== -->
        <?php include '../../topbar.php'; ?>

        <!-- ========================= App_Container ==================== -->
        <div class="app_container">

            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <a href="addPaciente.php" class="btn btn-success"><ion-icon name="person-add-outline"></ion-icon>
                        Adicionar Paciente</a>
                </div>
            </div>

            <?php
            $dadosInputBusca = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            ?>

            <fieldset class="border rounded-3 p-3">
                <legend class="float-none w-auto px-3">Buscar Paciente</legend>
                <div class="container">
                    <form method="POST" action="">
                        <div class="row ">
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" name="nome_paciente" class="form-control" id="id_nomeBusca"
                                        value="<?php if (isset($dadosInputBusca['nome_paciente'])) {
                                            echo $dadosInputBusca['nome_paciente'];
                                        } ?>">
                                    <label class="sm-label" for="id_nomeBusca">Nome</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" name="cpf_paciente" class="form-control" id="id_cpfBusca"
                                        value="<?php if (isset($dadosInputBusca['cpf_paciente'])) {
                                            echo $dadosInputBusca['cpf_paciente'];
                                        } ?>">
                                    <label class="sm-label" for="id_cpfBusca">CPF</label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                <div class="form-floating">
                                    <input type="text" name="celular_paciente" class="form-control" id="id_celularBusca"
                                        value="<?php if (isset($dadosInputBusca['celular_paciente'])) {
                                            echo $dadosInputBusca['celular_paciente'];
                                        } ?>">
                                    <label class="sm-label" for="id_celularBusca">Celular</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">
                                <button type="submit" style="margin-right: 8px;" value="Enviar" name="pesqPaciente"
                                    class="btn btn-primary" id="pesqPaciente"><ion-icon
                                        name="search-outline"></ion-icon> Buscar</button>
                                <button type="submit" name="limpaBusca" class="btn btn-primary"
                                    id="limpaBusca">Limpar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>

            <br />
            <br />

            <?php
            if (isset($_POST['limpaBusca'])) {

                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
            ?>

            <?php
            $result_busca = null;
            $display_busca = "none";

            if (!empty($dadosInputBusca['pesqPaciente'])) {

                if (empty($dadosInputBusca['nome_paciente'])) {
                    $nome = "";
                } else {
                    $nome = "%" . $dadosInputBusca['nome_paciente'] . "%";
                }

                $cpf = $dadosInputBusca['cpf_paciente'];
                $celular = $dadosInputBusca['celular_paciente'];
                $id_medico = $_SESSION['id'];

                $query_pacientes = "SELECT 
                                            T1.id, 
                                            T1.nome,
                                            T1.cpf,
                                            T1.celular,
                                            T1.email,
                                            T1.data_nascimento,
                                            T1.sexo
                                        FROM 
                                            pacientes T1 INNER JOIN medicos T2 ON T2.id = T1.medico_id
                                        WHERE 
                                            T1.medico_id = :medico
                                        AND
                                            T1.nome LIKE :nome
                                        OR
                                            T1.cpf LIKE :cpf
                                        OR
                                            T1.celular LIKE :celular
                                        ORDER BY 
                                            T1.nome 
                                        ASC";

                $result_busca = $conn->prepare($query_pacientes);
                $result_busca->bindParam(':nome', $nome, PDO::PARAM_STR);
                $result_busca->bindParam(':medico', $id_medico, PDO::PARAM_STR);
                $result_busca->bindParam(':cpf', $cpf, PDO::PARAM_STR);
                $result_busca->bindParam(':celular', $celular, PDO::PARAM_STR);

                $result_busca->execute();

                $display_busca = "block";
            }
            ?>

            <div class="container" style="display:<?= $display_busca ?>">
                <h4>Resultado Busca</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Email</th>
                                <th>Celular</th>
                                <th>Data Nascimento</th>
                                <th>Sexo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result_busca): ?>
                                <?php while ($row = $result_busca->fetch(PDO::FETCH_ASSOC)): ?>
                                    <?php $display_resultado = "none"; ?>
                                    <tr>
                                        <td><?= $row['nome'] ?></td>
                                        <td><?= $row['cpf'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['celular'] ?></td>
                                        <td><?= $row['data_nascimento'] ?></td>
                                        <td><?= $row['sexo'] ?></td>
                                        <td>
                                            <a href="infoPaciente.php?id=<?= $row['id']; ?>"
                                                class="btn btn-success btn-sm"><ion-icon name="enter-outline"></ion-icon>
                                                Acessar</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php endif; ?>
                            <tr style="display:<?= $display_resultado ?>">
                                <td colspan="7">Sem Resultados!</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            $id_medico = $_SESSION['id'];

            $query = "SELECT
                        T1.id, 
                        T1.nome,
                        T1.cpf,
                        T1.celular,
                        T1.email,
                        T1.data_nascimento,
                        T1.sexo
                    FROM 
                        pacientes T1
                    INNER JOIN 
                        medicos T2 ON T2.id = T1.medico_id
                    WHERE
                        T1.medico_id = :id_medico
                    ORDER BY 
                        T1.id DESC
                    LIMIT 5";

            $recentPaciente = $conn->prepare($query);
            $recentPaciente->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
            $recentPaciente->execute();
            ?>

            <div class="container">
                <h4>Cadastros Recentes</h4>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-responsive-sm" style="text-align: center;">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Celular</th>
                                <th>Email</th>
                                <th>Data Nascimento</th>
                                <th>Sexo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($recentPaciente->rowCount() > 0): ?>
                                <?php while ($data = $recentPaciente->fetch(PDO::FETCH_ASSOC)): ?>
                                    <tr>
                                        <td><?= $data['nome'] ?></td>
                                        <td><?= $data['cpf'] ?></td>
                                        <td><?= $data['celular'] ?></td>
                                        <td><?= $data['email'] ?></td>
                                        <td><?= date('d/m/Y', strtotime($data['data_nascimento'])) ?></td>
                                        <td><?= $data['sexo'] ?></td>
                                        <td>
                                            <a href="infoPaciente.php?id=<?= $data['id']; ?>" class="btn btn-success btn-sm">
                                                <ion-icon name="enter-outline"></ion-icon> Acessar
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">Nenhum paciente encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../assets/js/main.js"></script>

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