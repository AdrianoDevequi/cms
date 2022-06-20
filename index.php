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
<form action="" method="POST">
    <input type="text" name="first_name">
    <input type="text" name="last_name">
    <input type="text" name="email">
    <input type="text" name="password">
    <input type="submit" name="btn">
    <?php echo $mensagem ?>
</form>
</body>
</html>
