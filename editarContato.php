<?php
include 'classes/contatos.class.php';
$contato = new Contatos();

if(!empty($_GET['id'])){
    $id = $_GET['id'];
    $info = $contato->buscar($id);
    if(empty($info['email'])){
        header("Location: /backsenac");
        exit;
    }
}else{
    header("Location: /backsenac");
    exit;
}

?>

<h1>EDITAR CONTATO</h1>

<form method="POST" action="editarContatoSubmit.php">
    <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
    Nome: <br>
    <input type="text" name="nome" value="<?php echo $info['nome'] ;?>"/><br><br>
    Telefone: <br>
    <input type="text" name="telefone" value="<?php echo $info['telefone'] ;?>"/><br><br>
    Endereço: <br>
    <input type="text" name="endereco" value="<?php echo $info['endereco'] ;?>"/><br><br>
    Nascimento: <br>
    <input type="date" name="dt_nasc" value="<?php echo $info['dt_nasc'] ;?>"/><br><br>
    Descrição <br>
    <input type="text" name="descricao" value="<?php echo $info['descricao'] ;?>"/><br><br>
    Linkedin: <br>
    <input type="text" name="linkedln" value="<?php echo $info['linkedln'] ;?>"/><br><br>
    Email: <br>
    <input type="mail" name="email" value="<?php echo $info['email'] ;?>"/><br><br>
    Foto: <br>
    <input type="text" name="foto" value="<?php echo $info['foto'] ;?>"/><br><br>
    <input type="submit" name="btAlterar" value="ALTERAR"/>
</form>