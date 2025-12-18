<?php 


class Conexao {

    private $host = "br1048.hostgator.com.br";
    private $dbnome = "l3tecn91_ouvidoriaweb";
    private $usuariodb = "l3tecn91_ouvidoriaweb";
    private $senha = "0admdesenv0";


    public function Conectar(){

        try {
            $conexao = new PDO(

                "mysql:host=$this->host;
                       dbname=$this->dbnome", 
                       "$this->usuariodb", 
                       "$this->senha",
                       [
                           PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                           PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                           PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                       ]

            );
            return $conexao;
            
        } 
        catch (PDOException $e){

            echo '<p>' .$e->getMessage() . ' </p>';
            
        }

        
    }

}