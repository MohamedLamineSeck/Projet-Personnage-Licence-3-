<?php
    require_once('view/View.php');
    require_once('view/PrivateView.php');
    require_once('control/Controller.php');
    require_once('model/PersonnageStorageFile.php');
    require_once('model/PersonnageBuilder.php');
    require_once('model/AccountStorageFile.php');
    require_once('model/AccountBuilder.php');
    session_start();

    class Router{    
        public function main($model, $model2){ 
            //$model2->deleteAll();
            //$model2->reinit();
                
            $router = new Router();
            
            $feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
            $_SESSION['feedback'] = '';
            
            if(key_exists('user', $_SESSION)){
                $view = new PrivateView($router, $feedback);
            }
            else{
                $view = new View($router, $feedback);
            }
            
            $authManager = new AuthenticationManager($model2);
            $control = new Controller($view, $model, $authManager);
            
            $feedback = "";
            
            $data = array("name" => "", "species" => "", "age" => "", 'idCreation' => "");
            $builder = new PersonnageBuilder($data, null);
            
            
            if(key_exists('liste', $_GET)){
                $control->showList(); 
            }
            else if(key_exists('action', $_GET)){
                $action = $_GET['action'];
        // ################ URL ID ################ //
                if(key_exists('id', $_GET)){  
                    $id = $_GET['id'];
            // ################ Affichage Personnage ################ //
                    if($action === 'affichage'){
                        if(key_exists('user', $_SESSION)){
                            $control->showInformation($id);
                        }
                        else{
                            $view->displayRequireConnexion();
                        }  
                    }        
            // ################ Suppression Personnage ################ //
                    else if($action === 'supprime'){
                        $idUser = $_SESSION['user']['login'];
                        $control->askPersonnageDeletion($id, $idUser);
                    }
                    else if($action === 'supprimeConfirme'){
                        $control->deletePersonnage($id);
                    }
            // ################ Modification Personnage ################ //
                    else if($action === 'modifier'){
                        $idUser = $_SESSION['user']['login'];
                        $control->askPersonnageModifcation($id, $idUser);
                    }
                    else if($action === 'modifierConfirme'){
                        $control->savePersonnageModification($id, $_POST);
                    }
            // ################ Suppression User Account ################ //
                    else if($action === 'UserAccountSuppression'){
                        $control->AskUserAccountSuppression($id);
                    }
                    else if($action === 'UserAccountSuppressionConfirme'){
                        $control->UserAccountSuppression($id);
                    }
                    else{
                        $view->makeUnknownActionPage();
                    } 
                }
        // ################ URL No ID ################ //
                else{
          // ################ Création Personnage ################ // 
                    if($action === 'nouveau'){
                        if(key_exists('user', $_SESSION)){
                            $control->newPersonnage();
                        }
                        else{
                            $view->displayRequireConnexion();
                        }
                    }
                    else if($action === 'sauverNouveau'){
                        $control->saveNewPersonnage($_POST);
                    }
            // ################ Inscription ################ //
                    else if($action === 'inscription'){
                        $control->askInscription();
                    }
                    else if($action === 'inscriptionConfirme'){
                        $control->saveInscription($_POST);
                    }
            // ################ Connexion ################ //
                    else if($action === 'connexion'){
                        if(key_exists('user', $_SESSION)){
                            if($_SESSION['user']['statut'] === 'admin'){
                                $control->myAccountAdmin();
                            }
                            else{
                                $control->myAccountUser();
                            }
                        }
                        else{
                            $control->askConnexion(); 
                        }

                    }
                    else if($action === 'connexionConfirme'){
                        $control->connexion($_POST);
                    }
                    else if($action === 'deconnexion'){
                        $control->deconnexion();
                    }
            // ################ Mon Compte ################ //
                    else if($action === 'myAccount'){
                        if($_SESSION['user']['statut'] === 'admin'){
                            $control->myAccountAdmin();
                        }
                        else{
                            $control->myAccountUser();
                        }

                    }
                    else if($action === 'accountSuppression'){
                        $control->askAccountSuppression();
                    }
                    else if($action === 'accountSuppressionConfirme'){
                        $control->accountSuppression();
                    }
                    else if($action === 'suppressionAll'){
                        $control->listSuppressionAll();
                    }
                    else if($action === 'reinit'){
                        $control->listReinit();
                    }
                    else{
                        $view->makeUnknownActionPage();
                    }
                }    
            }
            else{   
                $view->makeAccueilPage();
            }       
            $view->render('Squelette.php'); // Appel methode d'affichage 
        }
        
        public function POSTredirect($url, $feedback){
            $_SESSION['feedback'] = $feedback;
            header("Location: ".htmlspecialchars_decode($url), true, 303);
            die;
        }
        
        // Getter Url
        public function getAccueilURL(){
            return "Personnages.php";
        }
        
        public function getListURL(){
            return "Personnages.php?liste";
        }
        
        public function getListAdminDeletionAllURL(){
            return "Personnages.php?action=suppressionAll";
        }
        
        public function getListAdminReinitURl(){
            return "Personnages.php?action=reinit";
        }
        
        public function getPersonnageURL($id){
            return "Personnages.php?action=affichage&id=".$id;
        }
        
        public function getPersonnageSaveURL(){
            return 'Personnages.php?action=nouveau';
        }
        
        public function getPersonnageCreationURL(){
            return 'Personnages.php?action=sauverNouveau';
        }
        
        public function getPersonnageAskDeletionURL($id){
            return 'Personnages.php?action=supprime&id='.$id;
        }
        
        public function getPersonnageDeletionURL($id){
            return 'Personnages.php?action=supprimeConfirme&id='.$id;
        }
        
        public function getPersonnageAskModificationURL($id){
            return 'Personnages.php?action=modifier&id='.$id;
        }
        
        public function getPersonnageModificationURL($id){
            return 'Personnages.php?action=modifierConfirme&id='.$id;
        }
        
        public function getConnexionURL(){
            return 'Personnages.php?action=connexion';
        }
        
        public function getConnexionConfirmeURL(){
            return 'Personnages.php?action=connexionConfirme';
        }
        
        public function getDeconnexionURL(){
            return 'Personnages.php?action=deconnexion';
        }
        
        public function getInscriptionURL(){
            return 'Personnages.php?action=inscription';
        }
        
        public function getInscriptionConfirmeURL(){
            return 'Personnages.php?action=inscriptionConfirme';
        }
        
        public function getMyAccountURL(){
            return 'Personnages.php?action=myAccount';
        }
        
        public function getAccountSuppresionURL(){
            return 'Personnages.php?action=accountSuppression';
        }
        
        public function getAccountSuppresionConfirmeURL(){
            return 'Personnages.php?action=accountSuppressionConfirme';
        }
        
        public function getUserAccountSuppresionURL($id){
            return 'Personnages.php?action=UserAccountSuppression&id='.$id.'';
        }
        
        public function getUserAccountSuppresionConfirmeURL($id){
            return 'Personnages.php?action=UserAccountSuppressionConfirme&id='.$id.'';
        }
    }




