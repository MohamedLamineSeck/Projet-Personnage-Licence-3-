<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/styles.css">
    <title><?php echo $this->title; ?></title>
</head>
<body>
    <header> 
        <nav>
            <ul>
                <?php
                    foreach ($this->getMenu() as $text => $link) {
                        echo "<li><a href=\"$link\">$text</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </header>  
     
    <main>
        <h1><?php echo $this->title; ?></h1>
       
        <?php echo $this->feedback ?>

        <?php echo $this->content; ?>
        
    </main>
    
    <footer>
        <p>Crédit @ copyright num etu 21606393 21711412</p>
    </footer>
     
     

	
<style>
/* ############ Commun ############ */
body {
    margin: auto;
    display: grid;
	font-family: sans-serif;
    background : #4381C1;
    max-width: 1250px
}
    
h1 {
    color: white;
    margin-top: 20px;
    margin-left: auto;
    margin-right: auto;
    margin-bottom: 20px;
    text-align: center;
    font-size: 40px;
    background: #900C3E;
    border: solid 1px #900C3E;
    border-radius: 5px;
    width: 600px; 
}

h2 {
    color: #571845;
    font-weight: bold;
    font-size: 25px;
}

    
/* ############ Header ############ */
header {
    display: grid;
    background: #FFC300;
}

   
    
/* ############ Nav ############ */
nav {
    margin: 0 ;
    padding: 0 ;
}

nav ul {
    margin-top: 0;
    margin-bottom: 0;
    padding-left: 0;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    justify-content: center;
}

nav ul li {
    text-align: center;
    list-style: none;
    list-style-type: none;
    padding: 10px;
}

nav ul li a {
    color: black;
    font-weight: bold;
    font-size: 20px;
    width: 312px;
    height: 45px;
    padding: 10px 50px;
    text-decoration: none;
}

nav ul li:hover {
    background-color: #F9F9F9;
}
 
    
    
/* ############ Main ############ */
main {
    padding-left: 20px;
    background: #aaa;
    height: 690px;
}

main li {
    color: #26547C;
    font-weight: bold;
    font-size: 17px;
}   
    
main a {
    color: #26547C;
    font-weight: bold;
    font-size: 17px; 
    text-decoration: none;
}
    
/* --- Page Perso --- */
.perso {
    display: grid; 
    grid-template-columns: 1fr 1fr;
}
    
.perso {
    
}
    
#img-mini img {
    width: 500px;
    height: 400px;
    margin-left: 30px;
}
 
/* -- Effet Image --- */
.lightbox {
	display: none;
}

.lightbox:target {
	display: block;
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background-color: rgba(0, 0, 0, .8);
}

.lightbox img {
	display: block;
	margin: auto;
	max-height: 100%;
	max-width: 100%;
}
    
    
    
/* --- Formulaire --- */
.box {
    text-align: center;
}

.box input[type = "text"], .box input[type = "password"]{
    border: 0;
    background: none;
    display: block;
    margin: -2px auto;
    text-align: center;
    border: 2px solid #3498db;
    padding: 14px 10px;
    width: 200px;
    outline: none;
    color: white;
    border-radius: 24px;
    transition: 0.25s;
}

.box input[type = "text"]:focus, .box input[type = "password"]:focus {
    width: 280px;
    border-color: #499F68;
}

.box button[type = "submit"]{
    border: 0;
    background: none;
    display: block;
    margin: 20px auto;
    text-align: center;
    border: 2px solid #499F68;
    padding: 14px 40px;
    outline: none;
    color: #571845;
    border-radius: 24px;
    transition: 0.25s;
    cursor: pointer;
}

.box button[type = "submit"]:hover{
    background: #499F68;
}

::placeholder {
  color: #571845;
  font-size: 1em;
}
    
 
/* --- Option Compte --- */
.option {
    color: white;
    border: 1px solid #571845;
    border-radius: 5px;
    background: #571845;
    padding: 10px; 
    margin-right: 20px;
}
    
        
/* --- FeedBack --- */
.feedback {
    color: white;
    width: 600px;
    font-weight: bold;
    font-size: 20px;
    text-align: center;
    border: solid 2px green;
    border-radius: 10px;
    background: green;
    margin-left: auto;
    margin-right: auto;
    
}
 
    
/* --- Erreur --- */
.errors {
    color: red;
    font-weight: bold; 
    font-size: 18px;
}


    
/* ############ Footer ############ */
footer {
    
}

footer p {
    background: #666;
    text-align: center; 
    font-weight: bold;
    margin: 0;
}
     
    
</style>
     

      
    
    

    
</body>
</html>


