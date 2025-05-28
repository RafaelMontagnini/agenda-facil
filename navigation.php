<!-- =============== Navegação ================ -->
 <style>
@import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap');
</style>

<div class="navigation" >
    <ul >
        <li>
            <a href="#">
                <span class="icon" style="display: flex;justify-content: center;align-items: center;">
                    <img width="45" height="45" src="../../images/faviconagWhite.png" alt="Logo">
                </span>
                <span style="font-family: 'Quicksand', sans-serif;font-size: 25px;" class="titleLogo">Agenda Fácil</span>
            </a>
        </li>

        <li class="<?php echo ($selectedMenu == 'paciente') ? 'hovered' : ''; ?>">
            <a href="../Paciente/paciente.php">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <span class="title">Pacientes</span>
            </a>
        </li>

        <li class="<?php echo ($selectedMenu == 'agendamento') ? 'hovered' : ''; ?>">
            <a href="../Agendamento/agendamento.php">
                <span class="icon">
                    <ion-icon name="calendar"></ion-icon>
                </span>
                <span class="title">Agendamentos</span>
            </a>
        </li>

        <li class="<?php echo ($selectedMenu == 'configuracao') ? 'hovered' : ''; ?>">
            <a href="../Configuracao/configuracao.php">
                <span class="icon">
                    <ion-icon name="settings"></ion-icon>
                </span>
                <span class="title">Configurações</span>
            </a>
        </li>

        <li>
            <a href="../../sair.php">
                <span class="icon">
                    <ion-icon name="log-out-outline"></ion-icon>
                </span>
                <form method="get">
                    <span type="submit" name="deslogar" class="title">Sair</span>
                </form> 
            </a>
        </li>           
    </ul>
</div>



