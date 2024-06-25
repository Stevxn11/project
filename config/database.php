<?php

class Database {
    private $hostname= "localhost";
    private $dbname= "tienda_online1";
    private $username= "root";
    private $password= "";
    private $charset= "utf8";

    function conectar(){
        try{
        $conexion= "mysql:host=" . $this->hostname ."; dbname=" . $this->dbname . ";
        charset=" . $this->charset;
        $options =[
            PDO ::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO :: ATTR_EMULATE_PREPARES => false
        ];

        $pdo= new PDO($conexion, $this->username, $this->password, $options);

         return $pdo;
        }catch(PDOException $e){
            echo "Error conexion". $e->getMessage();
            exit;
    }
}
}