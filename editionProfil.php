<?php
    
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=magic_beasts;charset=utf8','root','');

    if(isset($_SESSION['email']))
    {
        $reqUser = $bdd->prepare("SELECT * FROM utilisateur WHERE email= ?");
        $reqUser->execute(array($_SESSION['email']));
        $userInfo = $reqUser->fetch();

        if(isset($_POST['nameFormEdition']) AND !empty($_POST['nameFormEdition']) AND $_POST['nameFormEdition'] != $userInfo['Name'])
        {
            $newName = htmlspecialchars($_POST['nameFormEdition']);
            $insertName = $bdd->prepare("UPDATE utilisateur SET name = ? WHERE email = ?");
            $insertName->execute(array($newName, $_SESSION['email']));
            header('Location: profil.php?email='.$_SESSION['email']);
        }
        else if(isset($_POST['firstNameFormEdition']) AND !empty($_POST['firstNameFormEdition']) AND $_POST['firstNameFormEdition'] != $userInfo['FirstName'])
        {
            $newFirstName = htmlspecialchars($_POST['firstNameFormEdition']);
            $insertFirstName = $bdd->prepare("UPDATE utilisateur SET firstName = ? WHERE email = ?");
            $insertFirstName->execute(array($newFirstName, $_SESSION['email']));
            header('Location: profil.php?email='.$_SESSION['email']);
        }
        else if(isset($_POST['emailFormEdition']) AND !empty($_POST['emailFormEdition']) AND $_POST['emailFormEdition'] != $userInfo['Email'])
        {
            $newEmail = htmlspecialchars($_POST['emailFormEdition']);
            $insertEmail = $bdd->prepare("UPDATE utilisateur SET email = ? WHERE email = ?");
            $insertEmail->execute(array($newEmail, $_SESSION['email']));
            header('Location: deconnexion.php');
        }
        else if(isset($_POST['passwordFormEdition']) AND !empty($_POST['passwordFormEdition']) AND isset($_POST['password2FormEdition']) AND !empty($_POST['password2FormEdition']))
        {
            $newPassword = sha1($_POST['passwordFormEdition']);
            $newPassword2 = sha1($_POST['password2FormEdition']);

            if($newPassword == $newPassword2)
            {
                $insertPassword = $bdd->prepare("UPDATE utilisateur SET password = ? where email =?");
                $insertPassword->execute(array($newPassword, $_SESSION['email']));
                header('Location: profil.php?email='.$_SESSION['email']);
            }
            else
            {
                $erreur = "Les mots de passe ne correspondent pas.";
            }

        }

        else if(isset($_POST['nameFormEdition']) AND $_POST['nameFormEdition'] = $userInfo['Name'])
        {
            header('Location: profil.php?email='.$_SESSION['email']);
        }
        
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Magic Beasts</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="style.css"/>
    <script src="scripts.js"></script>
    <script src="jquery.js"></script>
</head>
<body>
    <div align="center">
        <h2>Edition du profil</h2>
        <form method="post" action="">
            <label>Nom</label><br>
            <input type="text" name="nameFormEdition" value="<?php echo $userInfo['Name']; ?>"/><br><br>
            <label>Prénom</label><br>        
            <input type="text" name="firstNameFormEdition" value="<?php echo $userInfo['FirstName']; ?>"/><br><br>
            <label>Email</label><br>
            <input type="text" name="emailFormEdition" value="<?php echo $userInfo['Email']; ?>"/><br><br>
            <label>Mot de passe</label><br>
            <input type="text" name="passwordFormEdition"/><br><br>
            <label>Confirmation du mot de passe</label><br>
            <input type="text" name="password2FormEdition"/><br><br>
            <input type="submit" class="button" id="buttonFormEdition" name="returnFormEdition" value="Mettre à jour"/><br><br>

        </form>
        <?php if(isset($erreur)) {echo '<font color="red">'.$erreur.'</font>'; }?>
</body>
</html>
<?php
    }
    else
    {
        header('Location: connexion.php');
    }
    
?>