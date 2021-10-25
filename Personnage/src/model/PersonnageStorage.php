<?php
    interface PersonnageStorage{
        public function read($id);
        
        public function readAll();
        
        public function create(Personnage $a);
        
        public function deleteAll();
        
        public function delete($id);
        
        public function exists($id);
    }
