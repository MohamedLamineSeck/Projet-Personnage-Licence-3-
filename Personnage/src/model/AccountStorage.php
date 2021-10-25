<?php 
    interface AccountStorage{
        public function reinit();
        
        public function read($id);
        
        public function readAll();
        
        public function exists($id);
        
        public function create(Account $account);
        
        public function createPassword($pass); 
        
        public function delete($id);
        
        public function deleteAll();
    }