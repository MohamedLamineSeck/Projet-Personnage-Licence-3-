<?php
    require_once('PersonnageStorage.php');
    require_once('lib/ObjectFileDB.php');

    class PersonnageStorageStub implements PersonnageStorage{        
        public function __construct(){
            $this->starWars = array(
                'yoda' => new Personnage('Maître Yoda', 'Maître Jedi', 900),
                'windu' => new Personnage('Maître Windu', 'Maître Jedi', 42),
                'obiwan' => new Personnage('Général Kenobi', 'Maître Jedi', 35),
                'anakin' => new Personnage('Anakin Skywalker', 'Simple Jedi', 25),

                'maul' => new Personnage('Dark Maul', 'Seigneur Sith', 35),
                'vador' => new Personnage('Dark Vador', 'Seigneur Sith', 40),
                'sidius' => new Personnage('Dark Sidius', 'Seigneur Sith', 75),
                'dooku' => new Personnage('Conte Dooku', 'Seigneur Sith', 55),
                'grivious' => new Personnage('Grivious', 'Seigneur Sith', 55),
            );
        }
        
        public function read($id){
            if(key_exists($id, $this->starWars)){
                return $this->starWars[$id];
            }
            else{
                return null;
            }
        }
        
        public function readAll(){
            return $this->starWars;
        }
    
        
        public function create(Personnage $perso){
            $newId = $this->db->insert($perso);
            return $newId;
        }
        
        public function deleteAll(){
            $this->db->deleteAll();
        }
        
        public function delete($id){
            $this->db->delete($id);
        }
        
        public function exists($id){
            return $this->db->exists($id);
        }

    }


