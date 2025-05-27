<?php
session_start();
ob_start();
include_once 'conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="images/faviconag.png" type="image/x-ico">
    <title>Login - Agenda Fácil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.0/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php
    //Criptografa senha
    //echo password_hash('1234', PASSWORD_DEFAULT);
    ?>

    <?php
    if (isset($_SESSION['success_message'])) {
        include_once 'Admin/Alerts/toastsSuccess.php';
        unset($_SESSION['success_message']);
    } else if (isset($_SESSION['error_message'])) {
        include_once 'Admin/Alerts/toastsError.php';
        unset($_SESSION['error_message']);
    }
    ?>

    <?php
    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    if (!empty($dados['SendLogin'])) {


        $query = "SELECT id, nome, email, senha FROM medicos WHERE email = :usuario LIMIT 1";
        $result = $conn->prepare($query);
        $result->bindParam(':usuario', $dados['usuario']);
        $result->execute();

        if (($result) && ($result->rowCount() != 0)) {
            $row = $result->fetch(PDO::FETCH_ASSOC);

            if (password_verify($dados['senha_usuario'], $row['senha'])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['nome_usuario'] = $row['nome'];
                $_SESSION['usuario'] = $row['email'];

                header("Location: Admin/Paciente/paciente.php");

            } else {
                $_SESSION['msg'] = "<p style='color: #ff0000'>Usuário ou senha inválida!</p>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: #ff0000'>Usuário ou senha inválida!</p>";
        }
    }
    ?>

    <form method="POST" action="">
        <div class="wrapper">
            <div class="container main">
                <div class="row">
                    <div class="col-md-6 side-image">
                        <img src="images/faviconagWhite.png" alt="">
                        <div class="text">
                            <p>Simplificando a Gestão com Tecnologia. <i>Agenda Fácil--</i> </p>
                        </div>
                    </div>
                    <div class="col-md-6 right">
                        <div class="input-box">
                            <header>Login</header>
                            <div class="form-floating mb-3">
                                <input type="email" name="usuario" class="form-control" id="floatingInputUser" required
                                    placeholder="name@example.com" value="<?php if (isset($dados['usuario'])) {
                                        echo $dados['usuario'];
                                    } ?>">
                                <label class="sm-label" for="floatingInputUser">Email *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="senha_usuario" class="form-control" id="floatingInput"
                                    required value="<?php if (isset($dados['senha_usuario'])) {
                                        echo $dados['senha_usuario'];
                                    } ?>">
                                <label class="sm-label" for="floatingInput">Senha *</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" value="Acessar" name="SendLogin">
                            </div>
                            <div id="cadastroMedicoLink" style="margin-top: 10px; text-align: center;">
                                <a href="cadastroMedico.php">Criar cadastro médico</a>
                            </div>
                            <div class="input-field">
                                <?php
                                if (isset($_SESSION['msg'])) {
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>