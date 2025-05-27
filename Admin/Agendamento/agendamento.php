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
    <title>Paciente - Agenda Fácil</title>
    <!-- ======= Estilos ====== -->
    <link rel="stylesheet" href="../assets/css/styleDashboard.css">
    <!-- ======= JQUERY ====== -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<style type="text/css">
    .no_wrap_cell {
        white-space: nowrap;
    }

    .clickable-row {
        cursor: pointer;
    }
</style>

<body>

    <!-- ========================= Alerts ==================== -->
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
        <!-- ========================= Barra Superior ==================== -->
        <?php include '../../topbar.php'; ?>

        <div class="salutation">
            <h5></h5>
        </div>


        <!-- ======================= Cards ================== -->
        <div class="app_container mt-4">
            <div class="container">
                <div class="card shadow rounded-4">
                    <div style="background-color: #10303d;"
                        class="card-header text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Agendamentos Médico</h5>
                        <button class="btn btn-light btn-sm" onclick="abrirModalNovo()">
                            <ion-icon name="add-circle-outline"></ion-icon> Novo Agendamento
                        </button>
                    </div>

                    <?php

                    $id_medico = $_SESSION['id'];

                    $query = "SELECT 
                            T1.id,
                            T2.nome,
                            T1.data_consulta,
                            T1.hora_consulta,
                            T2.celular
                        FROM 
                            agendamentos T1 LEFT JOIN pacientes T2 ON T2.id = T1.paciente_id
                                            LEFT JOIN medicos T3 ON T3.id = T1.medico_id
                        WHERE
                            T1.medico_id = :id_medico
                        ORDER BY
                            T1.data_consulta ASC, T1.hora_consulta ASC
                        
                        ";

                    $agendamento = $conn->prepare($query);
                    $agendamento->bindParam(':id_medico', $id_medico, PDO::PARAM_INT);
                    $agendamento->execute();

                    ?>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead class="table-light">
                                <tr>
                                    <th>Paciente</th>
                                    <th>Data</th>
                                    <th>Horário</th>
                                    <th>Contato</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="tabela-agendamentos">
                                <?php if ($agendamento->rowCount() > 0): ?>
                                    <?php while ($data = $agendamento->fetch(PDO::FETCH_ASSOC)): ?>
                                        <tr>
                                            <td><?= $data['nome'] ?></td>
                                            <td><?= date('d/m/Y', strtotime($data['data_consulta'])) ?></td>
                                            <td><?= $data['hora_consulta'] ?></td>
                                            <td><?= $data['celular'] ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary me-2" onclick="editarAgendamento(
                                                    <?= $data['id'] ?>,
                                                    '<?= $data['nome'] ?>',
                                                    '<?= $data['data_consulta'] ?>',
                                                    '<?= $data['hora_consulta'] ?>',
                                                    '<?= $data['celular'] ?>'
                                                )">
                                                    <ion-icon name="create-outline"></ion-icon>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger"
                                                    onclick="excluirAgendamento(<?= $data['id'] ?>)">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum agendamento encontrado.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- MODAL NOVO PACIENTE -->
            <?php include 'modalNovoAgendamento.php'; ?>

            <!-- MODAL EDITA PACIENTE  -->
            <?php include 'modalEditaAgendamento.php'; ?>

            <!-- MODAL EXCLUI PACIENTE -->
            <?php include 'modalExcluiAgendamento.php'; ?>

        </div>

    </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="../assets/js/main.js"></script>

    <script>

        function abrirModalNovo() {
            var modal = new bootstrap.Modal(document.getElementById('modalNovoAgendamento'));
            modal.show();
        }

        function editarAgendamento(id, nome, data, hora, telefone) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nome').value = nome;
            document.getElementById('edit-data').value = data;
            document.getElementById('edit-horario').value = hora;
            document.getElementById('edit-telefone').value = telefone;

            var modal = new bootstrap.Modal(document.getElementById('modalEditarAgendamento'));
            modal.show();
        }

        function excluirAgendamento(id) {
            document.getElementById('delete-id').value = id;

            const modal = new bootstrap.Modal(document.getElementById('modalExcluirAgendamento'));
            modal.show();
        }

        function confirmarExclusao() {
            const id = document.getElementById('delete-id').value;
            window.location.href = "modelAgendamento.php?deleteAgendamento=" + id;
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