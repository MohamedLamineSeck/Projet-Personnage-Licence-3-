<?php 
    require_once('model/Account.php');

    class AccountBuilder{
        const NAME_REF = "name";
        const LOGIN_REF = "login";
        const PASSWORD_REF = "password";
        const STATUT_REF = "statut";
        
        public function __construct($data=null){
            if($data === null){
                $data = array(
                    self::NAME_REF => "",
                    self::LOGIN_REF => "",
                    self::PASSWORD_REF => "",
                    self::STATUT_REF => "",
                );
            }
            $this->data = $data;
            $this->data[self::STATUT_REF] = 'user';
            $this->errors = array();
        }
        
        // Getter
        public function getData(){
           return $this->data;
        }
        
        public function getErrors($ref){
            return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
        }
        
        public function getLoginRef(){
            return self::LOGIN_REF;
        }
        
        public function getPasswordRef(){
            return self::PASSWORD_REF;
        }
        
        public function getNameRef(){
            return self::NAME_REF;
        }
        
        public function getStatutRef(){
            return self::STATUT_REF;
        }
        
        // Setter
        public function setError($ref, $error){
            $this->errors[$ref] = $error;
        }
        
        public function createAccount(){    
            $newAccount = new Account($this->data[self::LOGIN_REF], $this->data[self::PASSWORD_REF], $this->data[self::NAME_REF], $this->data[self::STATUT_REF]);
            return $newAccount;
        }
        
        // Incscription    
        public function isValidInscription(){
            $this->mbstrlen(self::LOGIN_REF);
            if($this->data[self::LOGIN_REF] === ""){
                $this->errors[self::LOGIN_REF] = "Vous devez entrer un login ";
            }
            $this->mbstrlen(self::PASSWORD_REF);
            if($this->data[self::PASSWORD_REF] === ""){
                $this->errors[self::PASSWORD_REF] = "Vous devez entrer une password ";
            }
            $this->mbstrlen(self::NAME_REF);
            if($this->data[self::NAME_REF] === ""){
                $this->errors[self::NAME_REF] = "Vous devez entrer un nombre name ";
            }
            return count($this->errors) === 0;
        }
        
        public function mbstrlen($ref){
            if(mb_strlen($this->data[$ref], 'UTF-8') >= 30){
                $this->errors[$ref] = "Le nom doit faire moins de 30 caractères";
            }
        }
        

    }
