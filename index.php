<?php
session_start();
include 'classes/contatos.class.php';
include 'classes/usuarios.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}

$usuarios = new Usuarios();
$usuarios->setUsuario($_SESSION['logado']);
$contato = new Contatos();
?>
<h1>Agenda Senac</h1>
<hr>
<?php if($usuarios->temPermissoes("ADD")): ?><button><a href="adicionarContato.php">ADICIONAR</a></button><?php endif; ?>
<button><a href="sair.php">SAIR</a></button>
<?php if($usuarios->temPermissoes('SUPER')):?><button><a href="gestaoUsuarios.php">GESTÃO USUÁRIOS</a></button><?php endif;?>
<br><br>
<table border="3" width="100%">
<tr>
    <th>ID</th>
    <th>NOME</th>
    <th>TELEFONE</th>
    <th>ENDEREÇO</th>
    <th>NASCIMENTO</th>
    <th>DESCRIÇÂO</th>
    <th>LINKEDIN</th>
    <th>EMAIL</th>
    <th>FOTO</th>
    <th>AÇÔES</th>
</tr>
<?php
$lista = $contato->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['telefone']?></td>
        <td><?php echo $item['endereco']?></td>
        <td><?php echo $item['dt_nasc']?></td>
        <td><?php echo $item['descricao']?></td>
        <td><?php echo $item['linkedln']?></td>
        <td><?php echo $item['email']?></td>
        <td><?php echo $item['foto']?></td>
        <td>
            <a href="editarContato.php?id=<?php echo $item['id']; ?>">EDITAR</a>
            <a href="excluirContato.php?id=<?php echo $item['id']?>" onclick="return confirm('Tem certeza que quer excluir este contato?')"> | EXCLUIR</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>
