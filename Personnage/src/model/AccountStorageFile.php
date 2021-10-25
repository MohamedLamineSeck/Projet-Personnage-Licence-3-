<?php 
    require_once('model/Account.php');
    require_once('lib/ObjectFileDB.php');
    require_once('model/AccountStorage.php');

    class AccountStorageFile implements AccountStorage{
        private $db;

        public function __construct($file){
            $this->db = new ObjectFileDB($file);  
        }
        
        public function reinit(){
            $this->db->insertAccount(new Account('jack', '$2y$10$vecze/V//nVxqjpk2VqMOuk46PoPs/ol.xdB4.0OTtj1Z.ee0W4a.', 'Jack Sparrow', 'admin'));
            $this->db->insertAccount(new Account('robin', '$2y$10$lZbZu2mDUjfhE.wJDNsBR.x7M5udZi3XmlxGNycm26wBiqtIVFw2W', 'Master Robin', 'admin'));
        }
        
        public function read($id){
            return $this->db->fetch($id);
        }
        
        public function readAll(){
            if(!$this->db->fetchAll()){
                $this->reinit();
            }
            return $this->db->fetchAll();
        }
        
        public function exists($id){
            return $this->db->exists($id);
        }
        
        public function create(Account $account){
            $passwordHash = $this->createPassword($account->getPassword());
            $account->setPassword($passwordHash);
            $newId = $this->db->insertAccount($account);
            return $newId;
        }
        
        public function createPassword($pass){
            $hash = password_hash($pass, PASSWORD_BCRYPT);
            return $hash;
        }
        
        public function delete($id){
            $this->db->delete($id);
        }
        
        public function deleteAll(){
            $this->db->deleteAll();
        }
        
        public function update($id, Account $account){
            $this->db->update($id, $account);
        }
    }