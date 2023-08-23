
<?php
session_start();

require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);

if(isset($_POST['logar'])){
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    if($usuario->logar($nome, $senha)){
        $_SESSION['nome'] = $nome;

        header("Location: dashboard.php");
        exit();
    }else{
        print "<script>alert('Login invalido')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tela de Login</h1>

    <form method="post">

    <label for="Nome">Nome</label>
    <input type="text" name="nome" placeholder="Informe seu nome de usuario">

    <label for="Senha">Senha</label>
    <input type="password" name="senha" placeholder="Informe sua senha">

    <button type="submit" name="logar">Logar</button>

    <a href="cadastro.php">Crie uma conta</a>
    </form>
    
</body>
</html>