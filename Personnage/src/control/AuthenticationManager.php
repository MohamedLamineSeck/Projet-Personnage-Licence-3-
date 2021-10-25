<?php 
    require_once('model/Account.php');
    require_once("model/AccountStorage.php");

    class AuthenticationManager{
        public function __construct($model){
            $this->model = $model;
        }
        
        public function checkAuth($login, $password){
            $id = $this->model->exists($login);
            if($id ==! false){
                $account = $this->model->read($id);
                $user = (array) $account;
                if(password_verify($password, $user['password'])){
                    $_SESSION['user'] = $user;
                    return $account;
                }
                else{
                    return 'password';   
                } 
            }
            else{
                return 'login';    
            }
        }
        
        public function create(Account $account){
            $this->model->create($account);
        }
        
        public function disconnectUser(){
            session_destroy();
        }
        
        public function readAllAccount(){
            return $this->model->readAll();
        }
        
        public function UserAccountSuppression($id){
            $this->model->delete($id);
        }
        
        public function isAdminAccount($login){
            $id = $this->model->exists($login);
            $user = (array) $this->model->read($id);
            if($user['statut'] === 'admin'){
                return true;
            }
            else{
                return false;
            }
        }
        
        public function isUserConnected(){
            if(key_exists('user', $_SESSION)){
                return true;
            }
            else{
                return false;
            }
        }
        
        public function isAdminConnected(){
            if(key_exists('user', $_SESSION)){
                if($_SESSION['user']['statut'] === 'admin'){  
                    return true;
                }
            }
            else{
                return false;
            }
        } 
    }
