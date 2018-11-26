<?php
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');

    /* Si la variable de session "email" n'existe pas ou n'est pas celle de l'administrateur, on quitte la page. */
    if(!isset($_SESSION['email']) AND $_SESSION['email'] != 'samahaux98@gmail.com')
    {
        exit();
    }

    if(isset($_POST['profileRedirection']))
    {
        session_start();
        $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');
        header("Location: profil.php?email=".$_SESSION['email']);
    }

    if(isset($_POST['returnAddAnimalForm']))
    {
        if(!empty($_POST['nameAnimal']) AND !empty($_POST['priceAnimal']) AND !empty($_POST['raceAnimal']) AND !empty($_POST['commentAnimal']) AND !empty($_POST['imageAnimal']))
        {
            $name =$_POST['nameAnimal'];
            $price = $_POST['priceAnimal']; 
            $race = $_POST['raceAnimal']; 
            $comment = $_POST['commentAnimal']; 
            $image= $_POST['imageAnimal'];
            $addAnimal = $bdd->prepare('INSERT INTO animal(name, price, race, comment, image) VALUES(?, ?, ?, ?, ?)');
            $addAnimal->execute(array($name, $price, $race, $comment, $image));
            header('Location: administration.php');
        }
        else
        {
            $erreur = "Compléter les champs manquants.";
        }
    }
    


    if(isset($_GET['delete']) AND !empty($_GET['delete']))
    {
        $email = $_GET['delete'];

        $deleteUser = $bdd->prepare('DELETE FROM utilisateur WHERE email = ?');
        $deleteUser->execute(array($email));
    }

    if(isset($_GET['reinitializePassword']) AND !empty($_GET['reinitializePassword']))
    {
        $email = $_GET['reinitializePassword'];
        $reinitializePassword = $bdd->prepare('UPDATE utilisateur SET password = ? WHERE email = ?');
        $reinitializePassword->execute(array('', $email));

    }

    if(isset($_GET['deleteAnimal']) AND !empty($_GET['deleteAnimal']))
    {
        $name = $_GET['deleteAnimal'];
        $deleteAnimal = $bdd->prepare('DELETE FROM animal WHERE name = ?');
        $deleteAnimal->execute(array($name));
        header('Location: administration.php');

    }

    $users = $bdd->query('SELECT * FROM utilisateur ORDER BY email');
    $animals = $bdd->query('SELECT * FROM animal ORDER BY name');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Magic Beasts</title>
    <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
</head>
<body>
    <form method="post" action=""><input class="button" name="profileRedirection" type="submit" value="Retour au profil"></input></form>
    <h2 align="center">Administration</h2>
    <div class="divAdminList">
        <h3>Utilisateurs</h3>
        <?php while($user = $users->fetch()) { ?>
        <p><?php if(!($user['Email']=='samahaux98@gmail.com')){ echo $user['Name'].' '.$user['FirstName'].' : '.$user['Email']; ?></p><a href="administration.php?reinitializePassword=<?php echo $user['Email'];?>">Réinitialiser le mot de passe</a><br><a href="administration.php?delete=<?php echo $user['Email']; ?>">Supprimer</a><br><br><hr><?php } ?>
        <?php } ?>
    </div>
    <div class="divAdminList">
        <h3>Animaux</h3>
        <form id="addAnimalForm" method="post" action="">
            <fieldset>
                <legend>Ajouter un animal</legend>
                <label>Nom</label><br>
                <input name="nameAnimal" type="text"/><br>
                <label>Race</label><br>
                <input name="raceAnimal" type="text"/><br>
                <label>Prix</label><br>
                <input name="priceAnimal" type="text"/><br>
                <label>Commentaire</label><br>
                <input id="inputComment" name="commentAnimal" type="text"/><br>
                <label>URL du portrait</label><br>
                <input name="imageAnimal" type="text"/><br><br>
                <input type="submit" value="Ajouter" class="button" name="returnAddAnimalForm"/>
            </fieldset>
        </form>
        <?php if(isset($erreur)) {echo '<font color="red">'.$erreur.'</font>';} ?>
        <hr>
        <?php while($animal = $animals->fetch()) { ?>
        <p><?php echo '<img src="'.$animal['Image'].'"/><br>'."Nom : ".$animal['Name'].'<br>Prix : '.$animal['Price'].'<br>Race : '.$animal['Race'].'<br>Commentaire : '.$animal['Comment']; ?></p><a href="administration.php?deleteAnimal=<?php echo $animal['Name'];?>">Supprimer</a><hr>
        <?php }?>
    </div>

</body>
</html>