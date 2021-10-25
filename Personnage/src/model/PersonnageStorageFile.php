<?php
    require_once('Personnage.php');
    require_once('lib/ObjectFileDB.php');
    require_once('PersonnageStorage.php');

    class PersonnageStorageFile implements PersonnageStorage{
        private $db;
        
        public function __construct($file) {
            $this->db = new ObjectFileDB($file);
        }
        
        public function reinit(){
            $this->db->insert(new Personnage('Maître Yoda', 'Maître Jedi', 900, 'img/yoda.png', 'admin')); // add juste le chemin de l'image 
            $this->db->insert(new Personnage('Maître Windu', 'Maître Jedi', 42, 'img/windu.jpg', 'admin'));
            $this->db->insert(new Personnage('Général Kenobi', 'Maître Jedi', 35, 'img/obiwan.jpg', 'admin'));
            $this->db->insert(new Personnage('Anakin Skywalker', 'Simple Jedi', 25, 'img/anakin.png', 'admin'));
            
            $this->db->insert(new Personnage('Dark Maul', 'Seigneur Sith', 35, 'img/maul.jpg', 'admin'));
            $this->db->insert(new Personnage('Dark Vador', 'Seigneur Sith', 40, 'img/vador.jpg', 'admin'));
            $this->db->insert(new Personnage('Dark Sidius', 'Seigneur Sith', 75, 'img/sidius.jpg', 'admin'));
            $this->db->insert(new Personnage('Conte Dooku', 'Seigneur Sith', 55, 'img/dooku.jpg', 'admin'));
            $this->db->insert(new Personnage('Grivious', 'Seigneur Sith', 55, 'img/grivious.jpg', 'admin'));
        }
        
        public function read($id){
            return $this->db->fetch($id);
        }
        
        public function readAll(){
            return $this->db->fetchAll();
        }
        
        public function create(Personnage $perso){
            $newId = $this->db->insert($perso);
            return $newId;
        }
        
        public function exists($id){
            return $this->db->exists($id);
        }
        
        public function delete($id){
            $this->db->delete($id);
        }
        
        public function deleteAll(){
            $this->db->deleteAll();
        }
        
        public function update($id, Personnage $perso){
            $this->db->update($id, $perso);
        }
        
    }




