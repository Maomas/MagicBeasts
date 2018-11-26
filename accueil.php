<?php  
    /* Démarrage de la session. */
    session_start();

    /* On tente de se connecter à la base de données "magic_beasts", avec le login 'root' et sans mot de passe. */
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');

    /* Si il la variable "$email" obtenue par la méthode GET existe. */
    if(isset($_GET['email']))
    {
        /* On va préparer une requête pour qu'elle soit exécutée par après.  
        On va sélectionner toutes les colonnes de la table "utilisateur" où l'email est la valeur récupérée par la méthode GET. */
        $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE Email= ?');
        $requser->execute(array($_GET['email']));
        $userInfo = $requser->fetch();

    }

    

?>
<!DOCTYPE html>
<!-- Le contenu de la page HTML. -->
<html>
    <head>
        <title>Magic Beasts</title>
        <meta charset="utf-8"/>
        <link href="style.css" rel="stylesheet" type="text/css"/>
        <script src="jquery.js"></script>
        <script src="scripts.js"></script>
    </head>
    <body>
        <!-- L'ensemble des deux boutons qui permettent d'accéder aux formulaires d'inscription et de connexion. -->
        <?php
        /* On va vérifier si la variable "$userInfo['Email']" existe, donc si un utilisateur est connecté.  
        On va afficher un élément qui souhaite la bienvenue à l'utilisateur et un lien lui permettant de se déconnecter. */
        if(isset($userInfo['Email'])){ echo "<p>Bonjour ".$userInfo['FirstName'].'!</p><a href="deconnexion.php">Se déconnecter</a>'; }
        /* Si ce n'est pas le cas, on affiche les deux boutons pour permettre à un visiteur pas encore inscrit ou connecté de pouvoir le faire. */
        else
        {
            echo '<div>
            <form action="connexion.php"><input class="button" type="submit" value="Se connecter"/></form>
            <form action="inscription.php"><input class="button" type="submit" value="S\'inscrire"/></form>
            </div>';
        }
        ?>
        

        <div id="profileDiv">
            <?php 
                /* Si l'utilisateur est connecté, on va afficher l'email de l'utilisateur et un lien contenant une image 
                permettant à celui-ci de consulter son profil. */ 
                if(isset($userInfo['Email']))
                {
                    echo $userInfo['Email'];
                    echo '<br><a href="profil.php?email='.$userInfo['Email'].'"><img id="profileImage" src="Images/profile.png"/></a><a href="basket.php?email='.$userInfo['Email'].'"><img id="panierImage" src="Images/basket.png"/></a>';
                }
                /* Si pas, l'élément div affiche un message pour dire au visiteur qu'il n'est pas connecté. */
                else
                {
                    echo "Vous n'êtes pas connecté.";
                }
            ?>
        </div>
        
        <!-- La barre de navigation. -->
        <div id="topnav">
            <ul>
                <li><a href="accueil.php?email=<?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>">Accueil</a></li>
                <li><a href="nosAnimaux.php?email=<?php if(isset($_SESSION['email'])) {echo $_SESSION['email'];} ?>">Nos Animaux</a></li>
            </ul>
            <br><br>
        </div>

        <!-- Le header contenant le titre ainsi que le nom de la page sur laquelle on se trouve. -->
        <div id="header">
            <h1 id="titre"><span id="maj">M</span>agic <span id="maj">B</span>easts</h1>
            <div id="rectangle"></div>
            <h2 id="titre">Eleveur d'animaux fantastiques depuis 1876</h2>
            <h3 id="titre">Accueil</h3>
        </div>

        <div class="article">
            <p>Vous êtes à la recherche d'un compagnon fidèle ?</p>
            <p>Vous auriez besoin d'une assistance aux tâches ménagères ?</p>
            <p>Vous cherchez à protéger votre demeure et à faire fuir les intrus ?</p>
            <p>Ou encore, à vous déplacez plus vite en centre-ville pour faire vos courses ?</p>
            <br>
            <p>Et bien, ce site est fait pour vous !</p>
            <p>Choisissez parmi une large gamme de créatures et animaux fantastiques qui vous rendront la tâche plus facile !</p>
            <p>Nouveaux arrivages tous les mois !</p>
            <p>N'hésitez pas à laisser un pouce bleu et un avis sur notre page Facebook ou vous inscrire à notre newsletter !</p> 
        </div>

        <!-- Le footer, contenant un formulaire pour éventuellement poser une question à l'administrateur du site. -->
        <div id="footer">
        <form id="formFooter" action="accueil.php" method="get">
                <fieldset>
                    <legend>Des questions à l'administrateur ?</legend>
                    Nom : <input type="text" name="nameFormFooter"></input>
                    Mail : <input type="text" name="emailFormFooter" placeholder="example@gmail.com"></input>
                    Question : <input type="text" name="comFormFooter"></input>
                    <input type="hidden" name="email"> 
                    <button type="submit" class="button" value="Envoyer" name="returnFormFooter">Envoyer</button>
                </fieldset>
            </form>
        </div>
    </body>
</html>