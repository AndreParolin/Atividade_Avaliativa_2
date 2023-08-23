<?php

require_once('classes/Usuario.php');
require_once('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$usuario = new Usuario($db);


if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $usuario->create($_POST);
            $rows = $usuario->read();
            break;
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Tela de Cadastro</h1>

    <form action="?action=create" method="POST">
         
        <label for="">Nome de Usuario</label>
        <input type="text" name="nome" required>

        <label for="">Email</label>
        <input type="email" name="email" required>

        <label for="">Senha</label>
        <input type="password" name="senha" minlength="8" required>

        <label for="">Confirmar Senha</label>
        <input type="password" name="confSenha" required>

        <button type="submit" name="cadastro">Cadastrar</button>

        <a href="index.php">Voltar a tela de login</a>
    </form>

    
</body>
</html>