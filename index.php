<?php
require __DIR__ . "/Source/autoload.php";

$user = new \Source\Models\User();
$mensagem = '';

if (isset($_POST['btn'])) {

    $user->bootstrap($firstName = $_POST['first_name'], $lastName = $_POST['last_name'], $email = $_POST['email'], $password = $_POST['password']);
    $user->save();
    $mensagem = $user->message();
}

?>
<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 painel-sidebar p-3">
            <?php include_once "Source/View/_sidebar.php"; ?>
        </div>
        <div class="col-10 p-5">

            <?php
            if (isset($_GET["dashboard"])) {
                include_once "Source/View/dashboard.php";
            }
            if (isset($_GET["usuarios"])) {
                include_once "Source/View/lista_usuarios.php";
            }
            if (isset($_GET["novo_usuario"])) {
                include_once "Source/View/novo_usuario.php";
            }
            ?>

        </div>
    </div>
</div>

</body>
</html>
