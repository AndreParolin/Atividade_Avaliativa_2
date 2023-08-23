<?php
include_once('conexao/conexao.php');

$db = new Database();

class Usuario{
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db){
        $this->conn = $db;
    }

    public function create($postValues){
        $nome = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];
        $confSenha = $postValues['confSenha'];

        if($senha === $confSenha){

            $emailExistente = $this->verificarEmailExistente($email);
            $nomeExistente = $this->verificarNomeExistente($nome);
            if($emailExistente || $nomeExistente){
                print "<script> alert('Nome ou Email já cadastrado')</script>";
                return false;
            }

            $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

        $query = "INSERT INTO ". $this->table_name . " (nome, email, senha) VALUES (?, ?, ?)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $senhaCriptografada);

        $rows = $this->read();
        if($stmt->execute()){
            print "<script>alert('Cadastro efetuado com sucesso!')</script>";
            print "<script> location.href='index.php'; </script>";
            return true;
        }else{
            return false;
        }
    }else{
        print "<script>alert('Credenciais invalidas')</script>";
    }
}

    private function verificarNomeExistente($nome){
        $sql = "SELECT COUNT(*) FROM usuarios WHERE nome = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$nome);
        $stmt-> execute();

    return $stmt->fetchColumn() > 0;
    }

    private function verificarEmailExistente($email){
        $sql = "SELECT COUNT(*) FROM usuarios WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1,$email);
        $stmt-> execute();

    return $stmt->fetchColumn() > 0;
    }

    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update($postValues){
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $email = $postValues['email'];
        $senha = $postValues['senha'];

        $query = "UPDATE ". $this->table_name . " SET nome = $nome, email = $email, senha= $senha WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$nome);
        $stmt->bindParam(2,$email);
        $stmt->bindParam(3,$senha);
        $stmt->bindParam(4,$id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function readOne($id){
        $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id){
        $query = "DELETE FROM ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function logar($nome, $senha){
        $sql = "SELECT * FROM usuarios WHERE nome = :nome";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome',$nome);
        $stmt->execute();

        if($stmt->rowCount() == 1){
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if(password_verify($senha, $usuario['senha'])){
                return true;
            }
        }

        return false;
    }
}
?>