<?php
include 'classes/contatos.class.php';
$com = new Contatos();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $com->deletar($id);
    header("Location: /backsenac");
}else{
    echo '<script type="text/javascript">alert("Erro ao excluir contato!");</script>';
    header("Location: /backsenac");
}