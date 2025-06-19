<?php
session_start();
include_once '../../conexao.php';
date_default_timezone_set('America/Sao_Paulo');

// --------- NOVO AGENDAMENTO ---------

if (isset($_POST['novo_agendamento'])) {
    try {
        $id_medico = $_SESSION['id'];
        $paciente_id = $_POST['paciente_id'];
        $data_consulta = $_POST['data_agendamento'];
        $hora_consulta = $_POST['hora_agendamento'];
        $observacao = $_POST['observacao'];
        $data_criacao = date("Y-m-d");
        $data_atualizacao = date("Y-m-d");

        $query = "INSERT INTO agendamentos (medico_id, paciente_id, data_consulta, hora_consulta, observacao,  data_criacao, data_atualizacao)
                  VALUES (:medico_id, :paciente_id, :data_consulta, :hora_consulta, :observacao, :data_criacao, :data_atualizacao)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':medico_id', $id_medico);
        $stmt->bindParam(':paciente_id', $paciente_id);
        $stmt->bindParam(':data_consulta', $data_consulta);
        $stmt->bindParam(':hora_consulta', $hora_consulta);
        $stmt->bindParam(':observacao', $observacao);
        $stmt->bindParam(':data_criacao', $data_criacao);
        $stmt->bindParam(':data_atualizacao', $data_atualizacao);

        $stmt->execute();

        $_SESSION['success_message'] = "Agendamento cadastrado com sucesso!";
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Erro ao cadastrar agendamento: " . $e->getMessage();
    }

    header("Location: agendamento.php");
    exit;
}


// --------- EDITAR AGENDAMENTO ---------

if (isset($_POST['salvar_edicao'])) {
    $id = $_POST['edit_id'];
    $data = $_POST['edit_data'];
    $hora = $_POST['edit_hora'];
    $data_atualizacao = date("Y-m-d");

    try {
        $query = "UPDATE agendamentos 
                  SET data_consulta = :data, hora_consulta = :hora, data_atualizacao = :data_atualizacao
                  WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':data_atualizacao', $data_atualizacao);
        $stmt->bindParam(':id', $id);

        $stmt->execute();

        $_SESSION['success_message'] = "Agendamento atualizado com sucesso!";

    } catch (Exception $e) {
        $_SESSION['error_message'] = "Erro ao atualizar agendamento: " . $e->getMessage();
    }

    header("Location: agendamento.php");
    exit;
}

// --------- EXCLUIR AGENDAMENTO ---------
if (isset($_GET['deleteAgendamento'])) {
    $id_agendamento = $_GET['deleteAgendamento'];

    try {
        $del_stmt = $conn->prepare("DELETE FROM agendamentos WHERE id = :id");
        $del_stmt->bindParam(':id', $id_agendamento);
        $del_stmt->execute();

        $_SESSION['success_message'] = 'Agendamento excluído com sucesso!';
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Erro ao excluir agendamento: ' . $e->getMessage();
    }

    header("Location: agendamento.php");
    exit;
}