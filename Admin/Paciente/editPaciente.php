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
  <title>Edita Paciente - Agenda Fácil</title>
  <!-- ======= Estilos ====== -->
  <link rel="stylesheet" href="../assets/css/styleDashboard.css">
  <!-- ======= JQUERY ====== -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
  $(document).ready(function () {
    $('#id_cpfCliente').mask('000.000.000-00');
    $('#id_rgCliente').mask('00.000.000-0');
    $('#id_telefoneCliente').mask('(00) 0000-0000');
    $('#id_celularCliente').mask('(00) 00000-0000');
    $('#id_cepCliente').mask('00000-000');
  });
</script>

<body>

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
            <a title="Voltar Página" href="infoPaciente.php?id=<?= $infoPaciente['id']; ?>"><ion-icon
                style="font-size: 25px;color: #2dc997;" name="caret-back-outline"></ion-icon> </a>
            <li class="breadcrumb-item"><a class="styleCrumb" href="paciente.php">Buscar</a></li>
            <li class="breadcrumb-item"><a class="styleCrumb"
                href="infoPaciente.php?id=<?= $infoPaciente['id']; ?>">Info Paciente</a></li>
            <li class="breadcrumb-item active" aria-current="page">Editar Paciente</li>
          </ol>
        </nav>
      </div>

      <fieldset class="border rounded-3 p-3">
        <legend class="float-none w-auto px-3">Editar Paciente</legend>
        <form method="POST" action="modelPaciente.php">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-end">
              <button type="submit" value="Editar" name="editPaciente" class="btn btn-success"><ion-icon
                  name="create-outline"></ion-icon> Salvar</button>
            </div>
          </div>
          <div class="container">
            <h5>Informações Pessoais</h5>
            <div class="row ">
              <div style="display: none;" class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="form-floating mb-3">
                  <input type="text" name="inputId" class="form-control" id="id_idPaciente"
                    value="<?= $infoPaciente['id'] ?>">
                  <label for="id_idPaciente">ID</label>
                </div>
              </div>
              <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="form-floating mb-3">
                  <input type="text" name="inputNome" class="form-control" id="id_nomePaciente"
                    value="<?= $infoPaciente['nome'] ?>">
                  <label for="id_nomePaciente">Nome</label>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="form-floating mb-3">
                  <input type="text" name="inputCPF" class="form-control" id="id_cpfPaciente"
                    value="<?= $infoPaciente['cpf'] ?>">
                  <label for="id_cpfPaciente">CPF</label>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="form-floating mb-3">
                  <input type="date" name="inputDataNascimento" class="form-control" id="id_dataNascimentoPaciente"
                    value="<?= $infoPaciente['data_nascimento'] ?>">
                  <label for="id_dataNascimentoPaciente">Data Nascimento</label>
                </div>
              </div>
            </div>
            <div class="row ">
              <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                <div class="form-floating mb-3">
                  <input type="email" name="inputEmail" class="form-control" id="id_emailPaciente"
                    value="<?= $infoPaciente['email'] ?>">
                  <label for="id_emailPaciente">E-mail</label>
                </div>
              </div>

              <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                <div class="form-floating mb-3">
                  <input type="text" name="inputCelular" class="form-control" id="id_celularPaciente"
                    value="<?= $infoPaciente['celular'] ?>">
                  <label for="id_celularPaciente">Celular</label>
                </div>
              </div>

              <div class="col-xl-2 col-lg-6 col-md-6 mb-4">
                <div class="form-floating">
                  <select name="selectPaciente" class="form-select" id="id_estadoCivilPaciente" aria-label="Select Sexo"
                    required>
                    <option selected>Selecione...</option>
                    <option <?php echo ($infoPaciente['sexo'] === 'MASCULINO') ? 'selected' : ''; ?> value="MASCULINO">
                      MASCULINO</option>
                    <option <?php echo ($infoPaciente['sexo'] === 'FEMININO') ? 'selected' : ''; ?> value="FEMININO">
                      FEMININO</option>
                    <option <?php echo ($infoPaciente['sexo'] === 'OUTRO') ? 'selected' : ''; ?> value="OUTRO">OUTRO
                    </option>
                  </select>
                  <label for="id_estadoCivilPaciente">Sexo*</label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </fieldset>

      <br />

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