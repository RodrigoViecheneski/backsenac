<?php
require 'conexao.class.php';
class Contatos {
    private $id;
    private $nome;
    private $telefone;
    private $endereco;
    private $dt_nasc;
    private $descricao;
    private $linkedln;
    private $email;
    private $foto;
    
    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }
    private function existeEmail($email){
        $sql =$this->con->conectar()->prepare("SELECT id FROM contatos WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(); //fetch retorna o email encontrado
        }else{
            $array = array();
        }
        return $array;
    }
    public function adicionar($email, $nome, $telefone, $endereco, $dt_nasc, $descricao, $linkedln, $foto){
        $emailExistente = $this->existeEmail($email);
        if(count($emailExistente) == 0){
            try{
                $this->nome = $nome;
                $this->telefone = $telefone;
                $this->endereco = $endereco;
                $this->dt_nasc = $dt_nasc;
                $this->descricao = $descricao;
                $this->linkedln = $linkedln;
                $this->email = $email;
                $this->foto = $foto;
                $sql = $this->con->conectar()->prepare("INSERT INTO contatos(nome, telefone, endereco, dt_nasc, descricao, linkedln, email, foto) VALUES(:nome, :telefone, :endereco, :dt_nasc, :descricao, :linkedln, :email, :foto)");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
                $sql->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
                $sql->bindParam(":dt_nasc", $this->dt_nasc, PDO::PARAM_STR);
                $sql->bindParam(":descricao", $this->descricao, PDO::PARAM_STR);
                $sql->bindParam(":linkedln", $this->linkedln, PDO::PARAM_STR);
                $sql->bindParam(":email", $this->email, PDO::PARAM_STR);
                $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR);
                $sql->execute();
                return TRUE;
            }catch(PDOException $ex){
                return 'ERRO: '.$ex->getMessage();
            }
        }else{
            return FALSE;
        }
    }
    public function listar() {
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM contatos");
            $sql->execute();
            return $sql->fetchAll();
        }catch(PDOException $ex){
            echo "ERRO: ".$ex->getMessage();
        }
    }
    public function buscar($id){
        try{
            $sql = $this->con->conectar()->prepare("SELECT * FROM contatos WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                return $sql->fetch();
            }else{
                return array();
            }
        }catch(PDOException $ex){
            echo "ERRO: ".$ex->getMessage();
        }
    }
    public function editar($nome, $telefone, $endereco, $dt_nasc, $descricao, $linkedln, $email, $foto, $id){
        $emailExistente = $this->existeEmail($email);
        if(count($emailExistente) > 0 && $emailExistente['id'] != $id){
            return FALSE;
        }else{
            try{

                $sql = $this->con->conectar()->prepare("UPDATE contatos SET nome = :nome, telefone = :telefone, endereco = :endereco, dt_nasc = :dt_nasc, descricao = :descricao, linkedln = :linkedln, email = :email WHERE id = :id");
                $sql->bindValue(':nome', $nome);
                $sql->bindValue(':telefone', $telefone);
                $sql->bindValue(':endereco', $endereco);
                $sql->bindValue(':dt_nasc', $dt_nasc);
                $sql->bindValue(':descricao', $descricao);
                $sql->bindValue(':linkedln', $linkedln);
                $sql->bindValue(':email', $email);
               // $sql->bindValue(':foto', $foto);
                $sql->bindValue(':id', $id);
                $sql->execute();
                //inserir imagens
                if(count($foto) > 0){
                    for($q=0;$q<count($foto['tmp_name']); $q++){
                        $tipo = $foto['type'][$q];
                        if(in_array($tipo, array('image/jpeg', 'image/png'))){
                            $tmpname = md5(time().rand(0, 9999)).'.jpg';
                            move_uploaded_file($foto['tmp_name'][$q], 'img/contatos/'.$tmpname);
                            list($width_orig, $height_orig) = getimagesize('img/contatos/'.$tmpname);
                            $ratio = $width_orig/$height_orig;

                            $width = 500;
                            $height = 500;

                            if($width/$height > $ratio){
                                $width = $height*$ratio;
                            }else{
                                $height = $width/$ratio;
                            }

                            $img = imagecreatetruecolor($width, $height);
                            if($tipo === 'image/jpeg'){
                                $origi = imagecreatefromjpeg('img/contatos/'.$tmpname);
                            }elseif($tipo == 'image/png'){
                                $origi = imagecreatefrompng('img/contatos/'.$tmpname);
                            }
                            imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                            //imagem salva no servidor
                            imagejpeg($img, 'img/contatos/'.$tmpname, 80);
                            //salvar no banco de dados a url da foto
                            $sql = $this->con->conectar()->prepare("INSERT INTO foto_contato SET id_contato = :id_contato, url = :url");
                            $sql->bindValue(":id_contato", $id);
                            $sql->bindValue(":url", $tmpname);
                            $sql->execute();
                        }
                    }
                }
                return TRUE;               
            }catch(PDOException $ex) {
                echo 'ERRO: '.$ex->getMessage();
            }
        }
    }
    public function deletar($id){
        $sql = $this->con->conectar()->prepare("DELETE FROM contatos WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
    }
    public function getContato($id){
        $array = array();
        $sql = $this->con->conectar()->prepare("SELECT * FROM contatos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        if($sql->rowCount() > 0){
            $array = $sql->fetch();
            //mostrar todas as imagens cadastradas
            $array['foto'] = array();
            $sql = $this->con->conectar()->prepare("SELECT id, url FROM foto_contato WHERE id_contato = :id_contato");
            $sql->bindValue("id_contato", $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $array['foto'] = $sql->fetchAll();
            }
        }
        return $array;
    }
}






