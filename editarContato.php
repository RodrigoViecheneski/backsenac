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

if(!empty($_POST['id'])){
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $dt_nasc = $_POST['dt_nasc'];
    $descricao = $_POST['descricao'];
    $linkedln = $_POST['linkedln'];
    $email = $_POST['email'];
    if(isset($_FILES['foto'])){
        $foto = $_FILES['foto'];
    }else{
        $foto = array();
    }
    

    if(!empty($email)){
        $contato->editar($nome, $telefone, $endereco, $dt_nasc, $descricao, $linkedln, $email, $foto, $_GET['id']);
    }
    header("Location: /backsenac");
}
if(isset($_GET['id']) && !empty($_GET['id'])){
    $info = $contato->getContato($_GET['id']);
}else{
    ?>
    <script type="text/javascript">window.location.href="index.php";</script>
    <?php
    exit;
}

?>

<h1>EDITAR CONTATO</h1>

<form method="POST" enctype="multipart/form-data"><!--permite adicionar imagens no form-->
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
    <input type="file" name="foto[]" multiple /><br>

    <div class="grupo">
        <div class="cabecalho">Foto Contato</div>
        <div class="corpo">
        <?php foreach($info['foto'] as $fotos):?>
            <div class="foto_item">
                <img src="img/contatos/<?php echo $fotos['url']; ?>"/>
                <a href="excluir_foto.php?id=<?php $fotos['id'];?>">Excluir Imagem</a>
            </div> 
            <?php endforeach; ?> 
        </div>
    </div>
    <input type="submit" name="btAlterar" value="ALTERAR"/>
</form>