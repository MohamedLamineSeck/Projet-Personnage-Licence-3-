<?php
    class Personnage{
        // Constructeur Animal génère animal avec nom, espèces, age
        public function __construct($name, $order, $age, $img, $idCreation){
            $this->name = $name;
            $this->order = $order;
            $this->age = $age;
            $this->img = $img;
            $this->idCreation = $idCreation;
        }
        
        // Getter 
        public function getName(){
            return $this->name;
        }

        public function getOrder(){
            return $this->order;
        }

        public function getAge(){
            return $this->age;
        }
        
        public function getImg(){
            return $this->img;
        }
        
        public function getIdCreation(){
            return $this->idCreation;
        }
        
        // Setter
        public function setName($name) {
            $this->name = $name;
        }
        
        public function setOrder($order) {
            $this->order = $order;
        }
        
        public function setAge($age) {
            $this->age = $age;
        }
        
        
        
        
        
    }
