<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');

    if(isset($_GET['email']))
    {
        $requser = $bdd->prepare('SELECT * FROM utilisateur WHERE Email= ?');
        $requser->execute(array($_GET['email']));
        $userInfo = $requser->fetch();
    }

    $animals = $bdd->query('SELECT * FROM animal ORDER BY name');?>

<!DOCTYPE html>
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
        if(isset($userInfo['Email'])){ echo "<p>Bonjour ".$userInfo['FirstName'].'!</p><a href="deconnexion.php">Se déconnecter</a>'; }
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
                if(isset($userInfo['Email']))
                {
                    echo $userInfo['Email'];
                    echo '<br><a href="profil.php?email='.$userInfo['Email'].'"><img id="profileImage" src="Images/profile.png"/></a><a href="basket.php?email='.$userInfo['Email'].'"><img id="panierImage" src="Images/basket.png"/></a>';
                }
                else
                {
                    echo "Vous n'êtes pas connecté.";
                }
            ?>
        </div>
        
        <!-- La barre de navigation. -->
        <div id="topnav">
            <ul>
                <li><a href="accueil.php?email=<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];} ?>">Accueil</a></li>
                <li><a href="nosAnimaux.php?email=<?php if(isset($_SESSION['email'])) {echo $_SESSION['email']; }?>">Nos Animaux</a></li>
            </ul>
            <br><br>
        </div>

        <!-- Le header contenant le titre ainsi que le nom de la page sur laquelle on se trouve. -->
        <div id="header">
            <h1 id="titre"><span id="maj">M</span>agic <span id="maj">B</span>easts</h1>
            <div id="rectangle"></div>
            <h2 id="titre">Eleveur d'animaux fantastiques depuis 1876</h2>
            <h3 id="titre">Nos Animaux</h3>
        </div>
            
        <?php while($animal = $animals->fetch()) { ?>
        <div class="article"><img class="imageAnimal" src="<?php echo $animal['Image']; ?>"/><br><?php echo 'Nom : '.$animal['Name'].'<br>Race : '.$animal['Race'].'<br>Prix : '.$animal['Price'].'$<br>Description : '.$animal['Comment'].'.'; ?><?php if(isset($_SESSION['email'])){ echo '<br><a href="addToBasket.php?email='.$_GET['email'].'&race='.$animal['Race'].'&price='.$animal['Price'].'">Ajouter au panier</a>'; }?></div>
        <?php } ?>

        <!-- Le footer, contenant un formulaire pour éventuellement poser une question à l'administrateur du site. -->
        <div id="footer">
        <form id="formFooter">
                <fieldset>
                    <legend>Des questions à l'administrateur ?</legend>
                    Nom : <input type="text" name="name"></input>
                    Mail : <input type="text" name="email" placeholder="example@gmail.com"></input>
                    Question : <input type="text" name="com"></input>
                    <button type="submit" value="Envoyer">Envoyer</button>
                </fieldset>
            </form>

        </div>
    </body>
</html>