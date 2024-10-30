<?php
session_start();
include 'classes/usuarios.class.php';
if(!isset($_SESSION['logado'])){
    header("Location: login.php");
    exit;
}
$usuarios = new Usuarios();
?>
<h1>Agenda Senac</h1>
<hr>
<button><a href="#">ADICIONAR</a></button>
<br><br>
<table border="3" width="100%">
<tr>
    <th>ID</th>
    <th>NOME</th>
    <th>EMAIL</th>
    <th>SENHA</th>
    <th>PERMISSÕES</th>
    <th>AÇÔES</th>
</tr>
<?php
$lista = $usuarios->listar();
foreach($lista as $item):
?>
<tbody>
    <tr>
        <td><?php echo $item['id']?></td>
        <td><?php echo $item['nome']?></td>
        <td><?php echo $item['email']?></td>
        <td><?php echo $item['senha']?></td>
        <td><?php echo $item['permissoes']?></td>
        <td>
            <a href="#">EDITAR</a>
            <a href="#"> | EXCLUIR</a>
        </td>
    </tr>
</tbody>
<?php
endforeach;
?>
</table>
