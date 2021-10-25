<?php
    require_once('view/View.php');
    require_once('model/Personnage.php');
    require_once('model/PersonnageBuilder.php');
    require_once('model/Account.php');
    require_once('model/AccountBuilder.php');

    class PrivateView extends View{
        protected $title;
        protected $content;
        
        public function __construct($router, $feedback){
            $this->title = "";
            $this->content = "";
            $this->router = $router;
            $this->feedback = $feedback;
            //$this->account = $account;
        }
        
        // Méthode pour Page d'Acceuil
        public function makeAccueilPage(){
            $this->title = "Bienvenue ".self::htmlesc($_SESSION['user']['name']);            
            $this->content = "Vous êtes sur la page d'acceuil";
        }
        
        // Méthode pour Page Url liste
        public function makeAdminListPage($listeNomTab){
            $this->title = "Liste des Personnages";
            $liste = $listeNomTab;
            
            $this->content = '<h2>Voici la liste des Personnage</h2>';
            
            $this->content .= '<ul>';
            foreach($liste as $key => $value){
                $this->content .= '<li>';
                $this->content .= '<a href="'.$this->router->getPersonnageURL($value['id']).'">'.self::htmlesc($value['name']).'</a>';   
                $this->content .= '</li>';
            }
            $this->content .= '</ul>';
            $this->content .= '<br>';
            
            $this->content .= '<a class="option" href="'.$this->router->getListAdminReinitURl().'">Initialisation</a>';
            $this->content .= '<a class="option" href="'.$this->router->getListAdminDeletionAllURL().'">Suppression</a>';
        }
        
        public function displayListSuppressionAllSucces(){
            $this->router->POSTredirect($this->router->getListURL(), "<p class='feedback'>Tous les personnages ont bien été supprimés</p>");
        }
        
        public function displayListReinitSucces(){
            $this->router->POSTredirect($this->router->getListURL(), "<p class='feedback'>Tous les personnages ont bien été initialisés</p>");
        } 
        
        protected function getMenu() {
            return array(
                "Accueil" => $this->router->getAccueilURL(),
                "Liste" => $this->router->getListURL(),
                "Créer Personnage" => $this->router->getPersonnageSaveURL(),
                "Mon compte" => $this->router->getConnexionURL(),
            );
        }
    }