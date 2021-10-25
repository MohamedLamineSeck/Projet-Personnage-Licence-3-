<?php
    require_once('Personnage.php');
    require_once('PersonnageStorage.php');

    class PersonnageStorageMySQL implements PersonnageStorage{
        protected $bd;
        protected $dsn;
        protected $user;
        protected $pass;
        
        public function __construct(){
            $dsn = 'mysql:host=localhost;dbname=personnages';
            $user = 'root';
            $pass = '';
            try{
                $this->db = new PDO($dsn, $user, $pass);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(Exception $e){
                die('ERROR : '.$e->getMessage());
            }
        }
        
        public function reinit(){
            $rqDelete = "DELETE FROM personnages;";
            $rqInsert = "INSERT INTO personnages VALUES 
                (1, 'Maître Yoda', 'Maître Jedi', 900, 'img/yoda.png', 'admin'),
                (2, 'Maître Windu', 'Maître Jedi', 42, 'img/windu.jpg', 'admin'),
                (3, 'Général Kenobi', 'Maître Jedi', 35, 'img/obiwan.jpg', 'admin'),
                (4, 'Anakin Skywalker', 'Simple Jedi', 25, 'img/anakin.png', 'admin'),
                                 
                (5, 'Dark Maul', 'Seigneur Sith', 35, 'img/maul.jpg', 'admin'),
                (6, 'Dark Vador', 'Seigneur Sith', 40, 'img/vador.jpg', 'admin'),
                (7, 'Dark Sidius', 'Seigneur Sith', 75, 'img/sidius.jpg', 'admin'),
                (8, 'Conte Dooku', 'Seigneur Sith', 55, 'img/dooku.jpg', 'admin'),
                (9, 'Grivious', 'Seigneur Sith', 55, 'img/grivious.jpg', 'admin')";

            $this->db->query($rqDelete);
            $this->db->query($rqInsert);
        }
        
        public function read($id):Personnage{            
            $rq = "SELECT * FROM personnages WHERE id = :id";
            $stmt = $this->db->prepare($rq);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch();

            return new Personnage($result['name'], $result['ordre'], $result['age'], $result['img'], $result['idCreation']);
        }
        
        public function readAll(){
            $res = $this->db->query('SELECT * FROM personnages');
            return $res->fetchAll();
        }
    
        public function create(Personnage $a){    
            $rq = "INSERT INTO personnages (name, ordre, age, img, idCreation) VALUES (:name, :ordre, :age, :img, :idCreation)";
            $stmt = $this->db->prepare($rq);
            $stmt->bindValue(":name", $a->getName(), PDO::PARAM_STR);
            $stmt->bindValue(":ordre", $a->getOrder(), PDO::PARAM_STR);
            $stmt->bindValue(":age", $a->getAge(), PDO::PARAM_INT);
            $stmt->bindValue(":img", $a->getImg(), PDO::PARAM_STR);
            $stmt->bindValue(":idCreation", $a->getIdCreation(), PDO::PARAM_STR);
            $stmt->execute();
            
            return $this->db->lastInsertId();
        }
        
        public function deleteAll(){
            $rqDelete = "DELETE FROM personnages;";
            $this->db->query($rqDelete);
        }
        
        public function delete($id){
            $rq = "DELETE FROM personnages WHERE id = :id";
            $stmt = $this->db->prepare($rq);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        }
        
        public function exists($id){
            $rq = "SELECT * FROM personnages WHERE id = {$id}";
            $res = $this->db->query($rq);
            if($res->rowCount() === 0){
                return false;
            } 
            else{
                return true;
            }
        }
        
        public function update($id, Personnage $a){
            $rq = "UPDATE personnages SET name = :name, ordre = :ordre, age = :age, img = :img, idCreation = :idCreation WHERE id = :id ;";
            $stmt = $this->db->prepare($rq);
            $stmt->bindValue(":name", $a->getName(), PDO::PARAM_STR);
            $stmt->bindValue(":ordre", $a->getOrder(), PDO::PARAM_STR);
            $stmt->bindValue(":age", $a->getAge(), PDO::PARAM_INT);
            $stmt->bindValue(":img", $a->getImg(), PDO::PARAM_STR);
            $stmt->bindValue(":idCreation", $a->getIdCreation(), PDO::PARAM_STR);
            $stmt->bindValue(":id", (int)$id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        }
    }



