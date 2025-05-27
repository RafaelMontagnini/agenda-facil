<?php

session_start();
ob_start();

include_once '../../conexao.php';


$dados_paciente = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//ADICIONAR PACIENTE.
if(isset($dados_paciente['cadPaciente']))
{
    try {

        $date_now = date("Y-m-d");
        $id_medico = $_SESSION['id'];

        $query_pacientes = "INSERT INTO pacientes 
                     (nome, cpf, email, celular, data_nascimento, sexo, medico_id, data_criacao, data_atualizacao) VALUES
                     (:nome, :cpf, :email, :celular, :data_nascimento, :sexo, :medico_id, :data_criacao, :data_atualizacao)";

         $cad_paciente =  $conn->prepare($query_pacientes);
         $cad_paciente->bindParam(':nome', $dados_paciente['inputNome']);
         $cad_paciente->bindParam(':cpf', $dados_paciente['inputCPF']);
         $cad_paciente->bindParam(':email', $dados_paciente['inputEmail']);
         $cad_paciente->bindParam(':celular', $dados_paciente['inputCelular']);
         $cad_paciente->bindParam(':data_nascimento', $dados_paciente['inputDataNascimento']);
         $cad_paciente->bindParam(':sexo', $dados_paciente['selectSexo']);
         $cad_paciente->bindParam(':medico_id', $id_medico);
         $cad_paciente->bindParam(':data_criacao', $date_now);
         $cad_paciente->bindParam(':data_atualizacao', $date_now);
         $cad_paciente->execute();

         
         $_SESSION['success_message'] = 'Paciente cadastrado com sucesso!';

         header("Location: addPaciente.php");
    }catch(Exception $e){
        $_SESSION['error_message'] = "Erro ao cadastrar: ".$e->getMessage();
        header("Location: addPaciente.php");
    }
}



// --------- EDITAR DADOS DO CLIENTE ---------

if(isset($_POST['editPaciente']))
{
    $id_paciente = $_POST['inputId'];
    $date_now = date("Y-m-d");

    try{

        $update_paciente = "UPDATE pacientes SET 
        nome=:nome, cpf=:cpf, email=:email, celular=:celular, data_nascimento=:data_nascimento, sexo=:sexo, data_atualizacao=:data_atualizacao
        WHERE id = $id_paciente";

        $up_paciente =  $conn->prepare($update_paciente);
        $up_paciente->bindParam(':nome', $_POST['inputNome']);
        $up_paciente->bindParam(':cpf', $_POST['inputCPF']);
        $up_paciente->bindParam(':email', $_POST['inputEmail']);
        $up_paciente->bindParam(':celular', $_POST['inputCelular']);
        $up_paciente->bindParam(':data_nascimento', $_POST['inputDataNascimento']);
        $up_paciente->bindParam(':sexo', $_POST['selectPaciente']);
        $up_paciente->bindParam(':data_atualizacao', $date_now);
        $up_paciente->execute();
        

         $_SESSION['success_message'] = 'Cadastro atualizado com sucesso!';
         header("Location: infoPaciente.php?id=" . $id_paciente);

    }catch(Exception $e){

         $_SESSION['error_message'] = 'Erro ao atualizar: '.$e->getMessage();
         header("Location: infoPaciente.php?id=" . $id_paciente);
    }

}

// --------- EXCLUIR PACIENTE ---------

if (isset($_GET['deletePaciente'])) {
    $id_paciente = $_GET['deletePaciente'];

    try {
        $del_stmt = $conn->prepare("DELETE FROM pacientes WHERE id = :id");
        $del_stmt->bindParam(':id', $id_paciente);
        $del_stmt->execute();

        $_SESSION['success_message'] = 'Paciente excluído com sucesso!';
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Erro ao excluir paciente: ' . $e->getMessage();
    }

    header("Location: paciente.php");
    exit;
}





?>