<?php
    require_once('Router.php');
    require_once('model/Personnage.php');
    require_once('model/PersonnageBuilder.php');
    require_once('model/Account.php');
    require_once('model/AccountBuilder.php');

    class View{
        protected $title;
        protected $content;
        
        public function __construct($router, $feedback){
            $this->title = "";
            $this->content = "";
            $this->router = $router;
            $this->feedback = $feedback;
        }
        
        // Méthode qui affiche le squelette html
        public function render($squel){
            include($squel);
        }
        
        // Méthode pour Page d'Acceuil
        public function makeAccueilPage(){
            $this->title = "Accueil";            
            $this->content = "<p>Voici la page d'acceuil</p>";
        }
        
        // Méthode pour Page Url liste
        public function makeListPage($listeNomTab){
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
        }
        
        // Méthode pour Page d'un animale
        public function makePersonnagePage(Personnage $Personnage, $id){
            $this->title = self::htmlesc($Personnage->getName());
            
            $this->content .= '<div class="perso">';
            $this->content .= '<p>';
            $this->content .= self::htmlesc($Personnage->getName());
            $this->content .= " faisait partie de l'ordre des ";
            $this->content .= self::htmlesc($Personnage->getOrder());
            $this->content .= " durant la grande guerre qui opposa les chevaliers Jedi muni de leurs armée de clone contre les seigneurs Sith et leurs armée de droïde. A cette époque nul n'aurait su dire qui sortirait vainqueur de cette lutte acharnée. Durant cette période il y eu de nombreux morts que ce soit aussi bien chez les Jedi que chez les Sith. Malheureusement ";
            $this->content .= self::htmlesc($Personnage->getName());
            $this->content .= " est lui aussi mort durant cette guerre, il est mort à l'age de ";
            $this->content .= self::htmlesc($Personnage->getAge());
            $this->content .= ' ans.';
            $this->content .= '</p>';
            

            
            $this->content .= '<a href="#img-maxi" id="img-mini">';
            $this->content .= '<img src="'.self::htmlesc($Personnage->getImg()).'" alt="Personnages Star wars petit"/>';
            $this->content .= '</a>';
            
            $this->content .= '<a class="lightbox" href="#img-mini" id="img-maxi">';
            $this->content .= '<img src="'.self::htmlesc($Personnage->getImg()).'" alt="Personnages Star wars grand"/>';
            $this->content .= '</a>';
        
            $this->content .= '</div>';

            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getListURL().'">Retour</a>';
            $this->content .= '<a class="option" href="'.$this->router->getPersonnageAskModificationURL($id).'">Modification</a>';
            $this->content .= '<a class="option" href="'.$this->router->getPersonnageAskDeletionURL($id).'">Suppression</a>';
        }
        
        // Méthode pour Page d'erreur Animal
        public function makeUnknownPersonnagePage(){
            $this->title = "Erreur";
            $this->content = "<p>Le Personnage n'existe pas</p>";
        }
        
        // Méthode pour Page d'erreur Action
        public function makeUnknownActionPage(){
            $this->title = "Erreur";
            $this->content = "<p>L'action n'existe pas</p>";
        }
        
    // ################ Création Personnage ################ //
        
        public function makePersonnageCreationPage(PersonnageBuilder $builder){
            $this->title = "Création d'un Personnage";
            
            $data = $builder->getData();
            
            $nameRef = $builder->getNameRef();
            $orderRef = $builder->getOrderRef();
            $ageRef = $builder->getAgeRef();
            
            $errName = $builder->getErrors($nameRef);
            $errOrder = $builder->getErrors($orderRef);
            $errAge = $builder->getErrors($ageRef);
            
            
            $this->content = '<form class="box" action="'.$this->router->getPersonnageCreationURL().'" method="POST">'."<br>";
            $this->content .= '<h2>Nouveau Personnage</h2>';

            $this->content .= '<input type="text" name="'.$nameRef.'" placeholder="Name" value="'.self::htmlesc($data[$nameRef]).'"/>';
            if($errName !== null){
                $this->content .= '<span class="errors">'.$errName.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="text" name="'.$orderRef.'" placeholder="Ordre" value="'.self::htmlesc($data[$orderRef]).'"/>';
            if($errOrder !== null){
                $this->content .= '<span class="errors">'.$errOrder.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="text" name="'.$ageRef.'" placeholder="Age" value="'.self::htmlesc($data[$ageRef]).'"/>';
            if($errAge !== null){
                $this->content .= '<span class="errors">'.$errAge.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<button type="submit">Créer Personnage</button>';
            $this->content .= '</form>';
        }
        
        public function displayPersonnageCreationSuccess($id) {
            $this->router->POSTredirect($this->router->getPersonnageURL($id), "<p class='feedback'>Le personnage a bien été créée !</p>");
        }

        public function displayPersonnageCreationFailure() {
            $this->router->POSTredirect($this->router->getPersonnageSaveURL(), "<p class='feedback'>Erreurs dans le formulaire</p>");
        }
        
    // ################ Suppression Personnage ################ //
        
        public function makePersonnageDeletionPage($id){
            $this->title = "Suppression d'un Personnage";
            $this->content = '<p>Voulez vous vraiment supprimer ce Personnage ?</p>';
            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getPersonnageURL($id).'">Retour</a>';
            $this->content .= '<a class="option" href="'.$this->router->getPersonnageDeletionURL($id).'">Supprimer</a>';
        }
        
        public function makePersonnageDeletedPage() {
            $this->router->POSTredirect($this->router->getListURL(), "<p class='feedback'>Le personnage a bien été supprimée !</p>");
        }
        
        public function displayPersonnageDeletionOrModifyFailed(){
            $this->router->POSTredirect($this->router->getListURL(), "<p class='feedback'>Vous ne pouvez supprimer que vos personnages </p>");
        }
        
    // ################ Modification Personnage ################ //
        
        public function makePersonnageModificationPage(PersonnageBuilder $builder, $id){
            $this->title = "Modification d'un Personnage";
            
            $data = $builder->getData();
            
            $nameRef = $builder->getNameRef();
            $orderRef = $builder->getOrderRef();
            $ageRef = $builder->getAgeRef();
            
            $errName = $builder->getErrors($nameRef);
            $errOrder = $builder->getErrors($orderRef);
            $errAge = $builder->getErrors($ageRef);
            
            
            $this->content = '<form class="box" action="'.$this->router->getPersonnageModificationURL($id).'" method="POST">'."<br>";
            $this->content .= '<h2>Modification</h2>';

            $this->content .= '<input type="text" name="'.$nameRef.'" placeholder="Name" value="'.self::htmlesc($data[$nameRef]).'"/>';
            if($errName !== null){
                $this->content .= '<span class="errors">'.$errName.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="text" name="'.$orderRef.'" placeholder="Ordre" value="'.self::htmlesc($data[$orderRef]).'"/>';
            if($errOrder !== null){
                $this->content .= '<span class="errors">'.$errOrder.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="text" name="'.$ageRef.'" placeholder="Age" value="'.self::htmlesc($data[$ageRef]).'"/>';
            if($errAge !== null){
                $this->content .= '<span class="errors">'.$errAge.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<button type="submit">Modifier</button>';
            $this->content .= '</form>';
            
            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getPersonnageURL($id).'">Retour</a>';
        }
        
        public function makePersonnageModifiedPage($id){    // displayPersonnageModifiedSucces
            $this->router->POSTredirect($this->router->getPersonnageURL($id), "<p class='feedback'>Le personnage a bien été modifiée !</p>");
        }
        
        public function makePersonnageNotModifiedPage($id){ // displayPersonnageModifiedFailure
            $this->router->POSTredirect($this->router->getPersonnageAskModificationURL($id), "<p class='feedback'>Erreurs dans le formulaire</p>");
        }
        
        // ################ Connexion ################ //
        
        public function makeConnexionPage($builder){
            $this->title = "Connexion";
            
            $data = $builder->getData();
            
            $loginRef = $builder->getLoginRef();
            $passwordRef = $builder->getPasswordRef();
            
            $errLogin = $builder->getErrors($loginRef);
            $errPassword = $builder->getErrors($passwordRef);
            
            $this->content = '<form class="box" action="'.$this->router->getConnexionConfirmeURL().'" method="POST">'."<br>";
            $this->content .= '<h2>Login</h2>';
            
            $this->content .= '<input type="text" name="'.$loginRef.'" placeholder="Login" value="'.self::htmlesc($data[$loginRef]).'">';
            if($errLogin !== null){
                $this->content .= '<span class="errors">'.$errLogin.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="password" name="'.$passwordRef.'" placeholder="Password" value="'.self::htmlesc($data[$passwordRef]).'">';
            if($errPassword !== null){
                $this->content .= '<span class="errors">'.$errPassword.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<button type="submit">Se connecter</button>';
            $this->content .= '</form>';
            
            $this->content .= '<br>';
            $this->content .= '<br>';
            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getInscriptionURL().'">Inscription</a>';
        }
        
        public function displayConnexionSucces(){
            $this->router->POSTredirect($this->router->getMyAccountURL(), "<p class='feedback'>Vous êtes bien connecté en tant que</p>");  // statut
        }
        
        public function displayConnexionFailure(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Erreurs dans le formulaire</p>");
        }
        
        public function displayRequireConnexion(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Connexion requise pour accèder à cette page</p>");
        }
        
        public function displayDeconnexionSucces(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Déconnexion réussi</p>");
        }
        
        // ################ Inscription ################ //
        
        public function makeInscriptionPage($builder){
            $this->title = "Inscription";
            
            $data = $builder->getData();
            
            $loginRef = $builder->getLoginRef();
            $passwordRef = $builder->getPasswordRef();
            $nameRef = $builder->getNameRef();
            
            $errLogin = $builder->getErrors($loginRef);
            $errPassword = $builder->getErrors($passwordRef);
            $errName = $builder->getErrors($nameRef);
            
            $this->content = '<form class="box" action="'.$this->router->getInscriptionConfirmeURL().'" method="POST">'."<br>";
            $this->content .= '<h2>Inscription</h2>';
            
            $this->content .= '<input type="text" name="'.$loginRef.'" placeholder="Login" value="'.self::htmlesc($data[$loginRef]).'">';
            if($errLogin !== null){
                $this->content .= '<span class="errors">'.$errLogin.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="text" name="'.$passwordRef.'" placeholder="Pasword" value="'.self::htmlesc($data[$passwordRef]).'">';
            if($errPassword !== null){
                $this->content .= '<span class="errors">'.$errPassword.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= '<input type="text" name="'.$nameRef.'" placeholder="Name" value="'.self::htmlesc($data[$nameRef]).'">';
            if($errName !== null){
                $this->content .= '<span class="errors">'.$errName.'</span>';
            }
            $this->content .= '<br>';
            
            $this->content .= "<button type='submit'>S'inscrire</button>";
            $this->content .= '</form>';
            
            $this->content .= '<br>';
            $this->content .= '<br>';
            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getConnexionURL().'">Connexion</a>';
        }
        
        public function displayInscriptionSucces(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Vous êtes bien inscrit</p>");
        }
        
        public function displayInscriptionFailure(){
            $this->router->POSTredirect($this->router->getInscriptionURL(), "<p class='feedback'>Erreurs dans le formulaire</p>");
        }
        
        // ################ Mon Compte ################ //
        
        public function makeMyAccountUserPage(){
            $this->title = "Mon compte";
            
            $this->content .= '<h2>Information compte : </h2>';
            $this->content .= '<ul>';
            $this->content .= '<li>Nom : '.self::htmlesc($_SESSION["user"]["name"]).'</li>';
            $this->content .= '<li>Login : '.self::htmlesc($_SESSION["user"]["login"]).'</li>';
            $this->content .= '<li>Password : '.self::htmlesc($_SESSION["user"]["password"]).'</li>';
            $this->content .= '<li>Statut : '.self::htmlesc($_SESSION["user"]["statut"]).'</li>';
            $this->content .= '</ul>';
            $this->content .= '<br>';
            
            $this->content .= '<a class="option" href="'.$this->router->getAccountSuppresionURL().'">Suppression</a>';
            $this->content .= '<a class="option" href="'.$this->router->getDeconnexionURL().'">Deconnexion</a>';
        }
        
        public function makeMyAccountAdminPage($listAccount){
            $this->title = "Mon compte";
            
            $this->content .= '<h2>Information compte : </h2>';
            $this->content .= '<ul>';
            $this->content .= '<li>Nom : '.self::htmlesc($_SESSION["user"]["name"]).'</li>';
            $this->content .= '<li>Login : '.self::htmlesc($_SESSION["user"]["login"]).'</li>';
            $this->content .= '<li>Password : '.self::htmlesc($_SESSION["user"]["password"]).'</li>';
            $this->content .= '<li>Statut : '.self::htmlesc($_SESSION["user"]["statut"]).'</li>';
            $this->content .= '</ul>';
            
            $this->content .= '<h2>Voici la liste de tout les comptes : </h2>';
            
            $this->content .= '<ul>';
            foreach($listAccount as $key => $value){
                $this->content .= "<li>";
                $this->content .= '<a href="'.$this->router->getUserAccountSuppresionURL($value['login']).'">'.self::htmlesc($value['login']).'</a>';   
                $this->content .= "</li>\n";
            }
            $this->content .= '</ul>';
            $this->content .= '<br>';
            
            $this->content .= '<a class="option" href="'.$this->router->getDeconnexionURL().'">Deconnexion</a>';
        }       
        
        public function makeAccountSuppressionConfirmePage(){
            $this->title = "Suppression du Compte";
            $this->content .= '<p>Voulez vous vraiment supprimer ce compte ?</p>';
            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getMyAccountURL().'">Retour</a>';
            $this->content .= '<a class="option" href="'.$this->router->getAccountSuppresionConfirmeURL().'">Supprimer</a>';
        }
        
        public function displayAccountSuppressionSucces(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Le compte à bien été supprimé</p>");
        }
        
        public function makeUserAccountSuppressionConfirmePage($id){
            $this->title = "Suppression du Compte";
            $this->content .= '<p>Voulez vous vraiment supprimer le compte '.self::htmlesc($id).' ?</p>';
            $this->content .= '<br>';
            $this->content .= '<a class="option" href="'.$this->router->getMyAccountURL().'">Retour</a>';
            $this->content .= '<a class="option" href="'.$this->router->getUserAccountSuppresionConfirmeURL($id).'">Supprimer</a>';
        }
        
        public function displayUserAccountSuppressionSucces(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Le compte à bien été supprimé</p>");
        }
        
        
        public function displaySuppressionAdminImpossible(){
            $this->router->POSTredirect($this->router->getConnexionURL(), "<p class='feedback'>Il est impossible de supprimer un compte admin</p>");
        }
        
        // ################ Utilitaire ################ //
        
        public static function htmlesc($str){
            return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, 'UTF-8');
        }
        
        protected function getMenu() {
            return array(
                "Accueil" => $this->router->getAccueilURL(),
                "Liste" => $this->router->getListURL(),
                "Créer Personnage" => $this->router->getPersonnageSaveURL(),
                "Connexion" => $this->router->getConnexionURL(),
            );
        }
    }
