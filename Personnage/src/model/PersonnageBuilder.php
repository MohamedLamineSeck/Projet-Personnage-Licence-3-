<?php
    require_once('model/Personnage.php');

    class PersonnageBuilder{  
        const NAME_REF = "name";
        const ORDER_REF = "order";
        const AGE_REF = "age";
        const IMG_REF = "img";
        const IDCREATION_REF = "idCreation";
        
        public function __construct($data=null){
            if($data === null) {
                $data = array(
                    self::NAME_REF => '',
                    self::ORDER_REF => '',
                    self::AGE_REF => '',
                    self::IMG_REF => 'img/default.jpg',
                    self::IDCREATION_REF => $_SESSION['user']['login'],
                );
            }
            $this->data = $data;
            $this->errors = array();
        }
        
        public function getData(){
           return $this->data;
        }
        
        public function getErrors($ref){
            return key_exists($ref, $this->errors)? $this->errors[$ref]: null;
        }
        
        public function getNameRef(){
            return self::NAME_REF;
        }
        
        public function getOrderRef(){
            return self::ORDER_REF;
        }
        
        public function getAgeRef(){
            return self::AGE_REF;
        }
        
        public function getImgRef(){
            return self::IMG_REF;
        }
        
        public function getIdCreationRef(){
            return self::IDCREATION_REF;
        }
        
        public function createPersonnage(){   
            $newPersonnage = new Personnage($this->data[self::NAME_REF], $this->data[self::ORDER_REF], $this->data[self::AGE_REF], $this->data[self::IMG_REF], $this->data[self::IDCREATION_REF]);
            return $newPersonnage;
        }
        
        public static function buildFromPersonnage(Personnage $personnage){
            return new PersonnageBuilder(array(
                self::NAME_REF => $personnage->getName(),
                self::ORDER_REF => $personnage->getOrder(),
                self::AGE_REF => $personnage->getAge(),
                self::IMG_REF => $personnage->getImg(),
                self::IDCREATION_REF => $personnage->getAge(),
            ));
        }
        
        public function updatePersonnage(Personnage $personnage) {
            if(key_exists(self::NAME_REF, $this->data)){
                $personnage->setName($this->data[self::NAME_REF]);
            }  
            if(key_exists(self::ORDER_REF, $this->data)){
                $personnage->setOrder($this->data[self::ORDER_REF]);
            }
            if(key_exists(self::AGE_REF, $this->data)){
                $personnage->setAge($this->data[self::AGE_REF]);
            }
                
        }

        public function isValid(){
            $this->mbstrlen(self::NAME_REF);
            if($this->data[self::NAME_REF] === ""){
                $this->errors[self::NAME_REF] = "Vous devez entrer un nom ";
            }
            $this->mbstrlen(self::ORDER_REF);
            if($this->data[self::ORDER_REF] === ""){
                $this->errors[self::ORDER_REF] = "Vous devez entrer une espèce ";
            }
            $this->mbstrlen(self::AGE_REF);
            if($this->data[self::AGE_REF] <= 0){
                $this->errors[self::AGE_REF] = "Vous devez entrer un nombre positif ";
            }
            return count($this->errors) === 0;
        }
        
        public function mbstrlen($ref){
            if(mb_strlen($this->data[$ref], 'UTF-8') >= 30){
                $this->errors[$ref] = "Le nom doit faire moins de 30 caractères";
            }
        }
    }




