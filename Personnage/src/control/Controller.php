<?php
    require_once('view/View.php');
    require_once('model/Personnage.php');
    require_once('model/PersonnageStorage.php');
    require_once('model/PersonnageBuilder.php');
    require_once('control/AuthenticationManager.php');
    require_once('model/AccountBuilder.php');
    
    class Controller{
        protected $currentConnexionBuilder;
        protected $currentInscriptionBuilder;
        protected $currentPersonnageBuilder;
        protected $modifiedPersonnageBuilders;
        
        public function __construct($view, $PersonnageStorage, $authManager){
            $this->view = $view;
            $this->authManager = $authManager;
            $this->PersonnageStorage = $PersonnageStorage;
            $this->currentConnexionBuilder = key_exists('currentConnexionBuilder', $_SESSION) ? $_SESSION['currentConnexionBuilder'] : null;
            $this->currentInscriptionBuilder = key_exists('currentInscriptionBuilder', $_SESSION) ? $_SESSION['currentInscriptionBuilder'] : null;
            $this->currentPersonnageBuilder = key_exists('currentPersonnageBuilder', $_SESSION) ? $_SESSION['currentPersonnageBuilder'] : null;
            $this->modifiedPersonnageBuilders = key_exists('modifiedPersonnageBuilders', $_SESSION) ? $_SESSION['modifiedPersonnageBuilders'] : array();
            
        }
        
        public function __destruct(){
            $_SESSION['currentConnexionBuilder'] = $this->currentConnexionBuilder;
            $_SESSION['currentInscriptionBuilder'] = $this->currentInscriptionBuilder;
            $_SESSION['currentPersonnageBuilder'] = $this->currentPersonnageBuilder;
            $_SESSION['modifiedPersonnageBuilders'] = $this->modifiedPersonnageBuilders;
        }
        
    // ################ Affichage Personnages ################ // 
        
        public function showInformation($id){
            if($this->PersonnageStorage->read($id)){
                $this->view->makePersonnagePage($this->PersonnageStorage->read($id), $id);
            }
            else{
                $this->view->makeUnknownPersonnagePage();
            }
        }
        
        public function showList(){
            if(key_exists('user', $_SESSION)){
                if($_SESSION['user']['statut'] === 'admin'){
                    $this->view->makeAdminListPage($this->PersonnageStorage->readAll());
                }
                else{
                    $this->view->makeListPage($this->PersonnageStorage->readAll());
                }
            }
            else{
                $this->view->makeListPage($this->PersonnageStorage->readAll());
            }
        }
        
        public function listSuppressionAll(){
            $this->PersonnageStorage->deleteAll();
            $this->view->displayListSuppressionAllSucces();
        }
        
        public function listReinit(){
            $this->PersonnageStorage->reinit();
            $this->view->displayListReinitSucces();
        }
        
        
    // ################ Creation Personnage ################ //
        
        public function newPersonnage(){ 
            if($this->currentPersonnageBuilder === null){
                $this->currentPersonnageBuilder = new PersonnageBuilder();
            }
            $this->view->makePersonnageCreationPage($this->currentPersonnageBuilder);
        }
        
        public function saveNewPersonnage(array $data){
            $data['img'] = 'img/default.jpg';
            $data['idCreation'] = $_SESSION['user']['login'];
            $this->currentPersonnageBuilder = new PersonnageBuilder($data);
            if($this->currentPersonnageBuilder->isValid()){
                $newPersonnage = $this->currentPersonnageBuilder->createPersonnage();
                $id = $this->PersonnageStorage->create($newPersonnage);
                $this->currentPersonnageBuilder = null;
                $this->view->displayPersonnageCreationSuccess($id);
            }
            else{
                $this->view->displayPersonnageCreationFailure();
            }
            
        }
        
    // ################ Suppression Personnage ################ //
        
        public function askPersonnageDeletion($id, $idUser){
            if($this->PersonnageStorage->exists($id)){
                $data = (array) $this->PersonnageStorage->read($id);
                $idCreation = $data['idCreation'];
                if($_SESSION['user']['statut'] === 'admin' || $idUser === $idCreation){
                     $this->view->makePersonnageDeletionPage($id);
                }
                else{
                    $this->view->displayPersonnageDeletionOrModifyFailed();
                } 
            }
            else{
                $this->view->makeUnknownPersonnagePage();
            }
        }
        
        public function deletePersonnage($id){
            $this->PersonnageStorage->delete($id);
            $this->view->makePersonnageDeletedPage();
        }
        
    // ################ Modification Personnage ################ //
        
        public function askPersonnageModifcation($id, $idUser){
            
            if(key_exists($id, $this->modifiedPersonnageBuilders)){
                $data = (array) $this->PersonnageStorage->read($id);
                $idCreation = $data['idCreation'];
                if($_SESSION['user']['statut'] === 'admin' || $idUser === $idCreation){
                     $this->view->makePersonnageModificationPage($this->modifiedPersonnageBuilders[$id], $id);
                }
                else{
                    $this->view->displayDeletionPersonnageFailed();
                } 
            } 
            else{
                $data = $this->PersonnageStorage->read($id);
                if($data === null){
                    $this->view->makeUnknownPersonnagePage();
                } 
                else{
                    $dataArray = (array) $data;
                    $idCreation = $dataArray['idCreation'];
                    if($_SESSION['user']['statut'] === 'admin' || $idUser === $idCreation){
                        $builder = PersonnageBuilder::buildFromPersonnage($data);
                        $this->view->makePersonnageModificationPage($builder, $id);
                    }
                    else{
                        $this->view->displayPersonnageDeletionOrModifyFailed();
                    }  
                }
            }            
        }
        
        public function savePersonnageModification($id, array $data){
            $personnage = $this->PersonnageStorage->read($id);
            if($personnage === null){
                $this->view->makeUnknownPersonnagePage();
            } 
            else{
                $array = (array)$data;
                $builder = new PersonnageBuilder($array);
                if($builder->isValid()){
                    $builder->updatePersonnage($personnage);
                    $this->PersonnageStorage->update($id, $personnage);
                    unset($this->modifiedPersonnageBuilders[$id]);
                    $this->view->makePersonnageModifiedPage($id);
                }
                else{
                    $this->modifiedPersonnageBuilders[$id] = $builder;
                    $this->view->makePersonnageNotModifiedPage($id);
                }
            }
        }
        
    // ################ Connexion ################ //
        
        public function askConnexion(){
            if($this->currentConnexionBuilder === null){
                $this->currentConnexionBuilder = new AccountBuilder();
            }
            $this->view->makeConnexionPage($this->currentConnexionBuilder);
        }
        
        public function connexion(array $data){
            $this->currentConnexionBuilder = new AccountBuilder($data);
            
            $loginRef = $this->currentConnexionBuilder->getLoginRef();
            $passwordRef = $this->currentConnexionBuilder->getPasswordRef();
            
            if($data[$loginRef] ==! null){
                $login = $data[$loginRef];
                if($data[$passwordRef] ==! null){
                    $password = $data[$passwordRef];
                    $check = $this->authManager->checkAuth($login, $password);
                    if($check === 'login'){
                        $this->currentConnexionBuilder->setError($loginRef, 'Login erroné');
                        $this->view->displayConnexionFailure();
                    }
                    if($check === 'password'){
                        $this->currentConnexionBuilder->setError($passwordRef, 'Password erroné');
                        $this->view->displayConnexionFailure();
                    }
                    else{
                        $this->currentConnexionBuilder = null;
                        $this->view->displayConnexionSucces();
                    }
                }
                else{
                    $this->currentConnexionBuilder->setError($passwordRef, 'Password vide');
                    $this->view->displayConnexionFailure();
                }
            }
            else{
                $this->currentConnexionBuilder->setError($loginRef, 'Login vide');
                $this->view->displayConnexionFailure();
            }     
        }
        
        public function deconnexion(){
            $this->authManager->disconnectUser();
            $this->view->displayDeconnexionSucces(); 
        }
    
    // ################ Inscription ################ //    
        
        public function askInscription(){
            if($this->currentInscriptionBuilder === null){
                $this->currentInscriptionBuilder = new AccountBuilder();
            }
            $this->view->makeInscriptionPage($this->currentInscriptionBuilder);
        }
        
        public function saveInscription(array $data){
            $this->currentInscriptionBuilder = new AccountBuilder($data);
            if($this->currentInscriptionBuilder->isValidInscription()){
                $newAccount = $this->currentInscriptionBuilder->createAccount();
                $this->authManager->create($newAccount);
                $this->currentInscriptionBuilder = null;
                $this->view->displayInscriptionSucces();
            }
            else{
                $this->view->displayInscriptionFailure();
            }
        }
        
    // ################ Mon Compte ################ // 
        
        public function myAccountAdmin(){
            $listAccount = $this->authManager->readAllAccount();
            $this->view->makeMyAccountAdminPage($listAccount);
        }
        
        public function myAccountUser(){
            $this->view->makeMyAccountUserPage();
        } 
        
        public function askAccountSuppression(){
            $this->view->makeAccountSuppressionConfirmePage();
        }
        
        public function accountSuppression(){
            $this->authManager->accountSuppression();
            $this->authManager->disconnectUser();
            $this->view->displayAccountSuppressionSucces();
        }
        
        public function AskUserAccountSuppression($id){
            if($this->authManager->isAdminAccount($id)){
                $this->view->displaySuppressionAdminImpossible();
            }
            else{
                $this->view->makeUserAccountSuppressionConfirmePage($id);
            }
            
        }
        
        public function UserAccountSuppression($id){
            $this->authManager->UserAccountSuppression($id);
            $this->view->displayUserAccountSuppressionSucces();
        }
        
        
        
        
    }
