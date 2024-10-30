<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $dt_nasc = $_POST['dt_nasc'];
    $descricao = $_POST['descricao'];
    $linkedln = $_POST['linkedln'];
    $email = $_POST['email'];
    $foto = $_POST['foto'];
    $id = $_POST['id'];

    if(!empty($email)){
        $contato->editar($nome, $telefone, $endereco, $dt_nasc, $descricao, $linkedln, $email, $foto, $id);
    }
    header("Location: /backsenac");
}
