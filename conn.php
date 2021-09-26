<?php 
    class Base{
        private $host = 'localhost';
        private $user = 'root';
        private $pass = '';
        private $data_base = 'taller_php';
        private $dbh;
        private $stmt;
        private $error;

        public function __construct()
        {
            $dsn = 'mysql:host='.$this->host.';dbname='.$this->data_base;
            $opciones = array(
                PDO::ATTR_PERSISTENT=>true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try{
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $opciones);
                $this->dbh->exec('set names utf8');
            }catch(PDOException $e){
                    $this->error = $e->getMessage();
                    echo $this->error;
            }
        }
        //Creando la función donde se gestionara los querys
        public function query($sql)
        {   
            $this->stmt= $this->dbh->prepare($sql);
        }
        //declarando el tipo de dato que entrara en la funcion bind
        public function bind($parametro, $valor, $tipo=null){
            if(is_null($tipo)){
                switch(true){
                    case is_int($valor):
                        $tipo = PDO::PARAM_INT;
                    break;
                    case is_bool($valor):
                        $tipo = PDO::PARAM_BOOL;
                    break;
                    case is_null($valor):
                        $tipo = PDO::PARAM_NULL;
                    break;
                    default:
                        $tipo = PDO::PARAM_NULL;
                    break;
                }
            }
            return $this->stmt->bindValue($parametro, $valor, $tipo);
        }
        //creamos la función donde se ejecutara el query
        public function execute()
        {
            return $this->stmt->execute();
        }

        public function getRegistros()
        {
            $this->execute();
            return $this->stmt->fetchALL(PDO::FETCH_OBJ);
        }
        public function getarray()
        {
            $this->execute();
            return $this->stmt->fetchALL(PDO::FETCH_ASSOC);
        }
        public function getRegistro()
        {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_OBJ);
        }
        public function rowCount()
        {
            $this->execute();
            return $this->stmt->rowCount();
        }


        

}