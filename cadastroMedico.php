<?php
session_start();
ob_start();
include_once 'conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!empty($dados['SendCadastro'])) {
    if ($dados['senha'] === $dados['confirma_senha']) {
        $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

        $date_now = date("Y-m-d");

        $query = "INSERT INTO medicos (nome, email, crm, senha, data_criacao, data_atualizacao) VALUES (:nome, :email, :crm, :senha, :data_criacao, :data_atualizacao)";
        $cad_medico = $conn->prepare($query);
        $cad_medico->bindParam(':nome', $dados['nome']);
        $cad_medico->bindParam(':email', $dados['email']);
        $cad_medico->bindParam(':crm', $dados['crm']);
        $cad_medico->bindParam(':senha', $senha_hash);
        $cad_medico->bindParam(':data_criacao', $date_now);
        $cad_medico->bindParam(':data_atualizacao', $date_now);

        if ($cad_medico->execute()) {
            $_SESSION['success_message'] = "<p style='color: white'>Cadastro realizado com sucesso!</p>";
            header("Location: index.php");
        } else {
            $_SESSION['msg'] = "<p style='color: red'>Erro ao cadastrar.</p>";
        }
    } else {
        $_SESSION['msg'] = "<p style='color: red'>As senhas não conferem.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/faviconag.png" type="image/x-ico">
    <title>Cadastro Médico - Agenda Fácil</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="bootstrap-5.3.0/css/bootstrap.min.css">
</head>

<body>
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
                            <header>Cadastro Médico</header>
                            <div class="form-floating mb-3">
                                <input type="text" name="nome" class="form-control" required placeholder="Nome completo"
                                    value="<?php if (isset($dados['nome'])) {
                                        echo $dados['nome'];
                                    } ?>">
                                <label class="sm-label">Nome *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" required
                                    placeholder="seu@email.com" value="<?php if (isset($dados['email'])) {
                                        echo $dados['email'];
                                    } ?>">
                                <label class="sm-label">Email *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="crm" class="form-control" required placeholder="1234567" value="<?php if (isset($dados['crm'])) {
                                    echo $dados['crm'];
                                } ?>">
                                <label class="sm-label">CRM *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="senha" class="form-control" required placeholder="Senha">
                                <label class="sm-label">Senha *</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="confirma_senha" class="form-control" required
                                    placeholder="Confirmar senha">
                                <label class="sm-label">Confirmar Senha *</label>
                            </div>
                            <div class="input-field">
                                <input type="submit" class="submit" name="SendCadastro" value="Cadastrar">
                            </div>
                            <div class="input-field" style="margin-top: 10px;">
                                <a href="index.php">Voltar para o Login</a>
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