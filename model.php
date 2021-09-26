<?php 
    include('conn.php');

    class friendModels{
        private $db;
        public function __construct(){
            $this->db = new Base;
        }
    public function consulta()
        {
            $this->db->query("select * from amigos");
            return $this->db->getRegistros();
        }
    public function addFriend($datos)
    {
        $this->db->query("INSERT INTO amigos(name, age, gender) VALUES (:name, :age, :gender)");
        $this->db->bind(':name', $datos['name']);
        $this->db->bind(':age', $datos['age']);
        $this->db->bind(':gender', $datos['gender']);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
    public function editFriend($datos)
    {
        $this->db->query('UPDATE amigos set name = :name, age = :age, gender = :gender
        WHERE id = :id ');
        $this->db->bind(':name', $datos['name']);
        $this->db->bind(':age', $datos['age']);
        $this->db->bind(':gender', $datos['gender']);
        $this->db->bind(':id', $datos['id']);
        if($this->db->execute()){
            return true;
        }
        return false;
    }
    public function deleFriend ($id){
        $this->db->query('delete from amigos where id = :id');
        $this->db->bind(':id', $id['id']);
        if($this->db->execute()){
            return true;
        }
        return false;
    }

}
?>