<?php
session_start();
ob_start();
include_once '../../conexao.php';

if(isset($_POST['editMedico']))
{
    $id_medico = $_POST['inputId'];
    $date_now = date("Y-m-d");

    try {
        $update_medico = "UPDATE medicos SET 
            nome = :nome,
            email = :email,
            crm = :crm,
            data_atualizacao = :data_atualizacao
            WHERE id = :id";

        $stmt = $conn->prepare($update_medico);
        $stmt->bindParam(':nome', $_POST['inputNome']);
        $stmt->bindParam(':email', $_POST['inputEmail']);
        $stmt->bindParam(':crm', $_POST['inputCRM']);
        $stmt->bindParam(':data_atualizacao', $date_now);
        $stmt->bindParam(':id', $id_medico, PDO::PARAM_INT);
        $stmt->execute();

        $_SESSION['success_message'] = 'Médico atualizado com sucesso!';
        header("Location: configuracao.php?id=" . $id_medico);
    } catch(Exception $e) {
        $_SESSION['error_message'] = 'Erro ao atualizar: '.$e->getMessage();
        header("Location: configuracao.php?id=" . $id_medico);
    }
}
?>
