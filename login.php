<?php
session_start();
require 'classes/usuarios.class.php';

if(!empty($_POST['email'])){
    $email = addslashes($_POST['email']);
    $senha = md5($_POST['senha']);

    $usuarios = new Usuarios();
    if($usuarios->fazerLogin($email, $senha)){
        header("Location: index.php");
        exit;
    }else{
        echo '<span style="color: red">'."Usuário e/ou senha incorretos!".'</span>';
    }
}
//echo md5("teste");
?>
<h1>LOGIN</h1>
<form method="POST">
    Email: <br>
    <input type="email" name="email"><br><br>
    Senha: <br>
    <input type="password" name="senha"><br><br>
    <a href="esqueceuSenha.php">ESQUECEU SUA SENHA ? CLICK AQUI</a><br>
    <input type="submit" value="Entrar">
</form>