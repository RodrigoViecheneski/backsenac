<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if(!empty($_POST['email'])){
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $dt_nasc = $_POST['dt_nasc'];
    $descricao = $_POST['descricao'];
    $linkedln = $_POST['linkedln'];
    $email = $_POST['email'];
    $foto = $_POST['foto'];
    $contato->adicionar($email, $nome, $telefone, $endereco, $dt_nasc, $descricao, $linkedln, $foto);
    header('Location: index.php');
}else{
    echo '<script type="text/javascript">alert("Email já cadastrado!");</script>';
}

