<?


if (isset($_POST["username"])) {
    $username = $_POST["username"];
} else if (isset($_GET["username"])) {
    $username = $_GET["username"];
} else {
    $username = "Inconnu";
}
$message = "";




if (isset($_POST["nom"])) {
    $hostname = "localhost";
$user = "root";
$pwd = "";
$database = "etudiant";


try {
    $mysqlConnection = new PDO(
        'mysql:host=' . $hostname . ';dbname=' . $database,
        $user,
        $pwd
    );
    echo "Connexion réussie<br/>";
    $sqlQuery = "INSERT INTO `etudiant` ( `nom`, `prenom`, `login`, `password`,
    `date_naissance`,`actif`) VALUES ( :nom, :prenom, :login, :password, :date_naissance,
    :actif);";
    //Préparation de la requête par PDO
$statment = $mysqlConnection->prepare($sqlQuery);
//Exécution sur le serveur de BDD
$users = $statment->execute([
    'nom' => $_POST["nom"],
    'prenom' => $_POST["prenom"],
    'login' => $_POST["login"],
    'password' => $_POST["mdp"],
    'date_naissance' => $_POST["date_naissance"],
    'actif' => (isset($_POST["access"]) ? 1 : 0)
    ]);
    if ($users) {
        echo "L'ajout dans la base de données s'est bien passé<br/>";
    } else {
        echo "Erreur lors de l'ajout en Base de données<br/>";
    }
    } catch (PDOException $error) {
        echo 'Échec de la connexion : ' . $error->getMessage();
    } finally {
        $mysqlConnection = null;
       
}
}


?>
<!DOCTYPE html>


<head>
    <title>Bienvenue dans Pardanotes</title>


    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style.css" media="screen" type="text/css" />
        <link rel="stylesheet" href="tp9.css" media="screen" type="text/css" />
    </head>
</head>


<body>
    <div id="header">
        <img src="logo.png" alt="logo"><br />
        <span>La gestion des notes du lycée Pardailhan</span>
    </div>
    <div id="menu">
        <div><a href="afficherNote.php?username=<?= $username ?>">Afficher les notes</a></div>
        <div><a href="saisirNote.php?username=<?= $username ?>">Saisir les notes</a></div>
        <div><a href="afficherEtudiant.php?username=<?= $username ?>">Afficher les étudiants</a></div>
        <div><a href="saisirEtudiant.php?username=<?= $username ?>">Saisir les étudiants</a></div>
        <div><a href="login.html">Se déconnecter</a></a></div>
    </div>
    <div id="contenu">
        <br>
        <p><?= $message ?></p>
        <form action="" method="POST">
            <fieldset>
                <legend>Saisir un étudiant </legend>
                <p>Nom*</p>
                <input name="nom" type="text" placeholder="Veuillez renseigner le nom" required>
                <p>Prénom*</p>
                <input name="prenom" type="text" placeholder="Veuillez renseigner le prénom" required>
                <p>Login*</p>
                <input name="login" type="text" placeholder="Veuillez renseigner le login" required>
                <p>Mot de passe*</p>
                <input name="mdp" type="password" placeholder="Veuillez renseigner le mot de passe" required>
                Date de naisssance* <input name="date_naissance" type="date" placeholder="Veuillez renseigner le nom" required>
                <br>
                <br>
                Accès à Pardanotes
                <input name="access" type="checkbox" placeholder="Veuillez renseigner le nom">
            </fieldset>
            <br />
            <input type="reset" value="Annuler" /> <input type="submit" value='Valider' />
        </form>
        <br>
        <br>
        <br>
        <br>
    </div>
    </div>
    <footer>
        <p>Copyright 2023 - Tous droits réservés <br>Mentions légales - CGU - Nous contacter</p>
    </footer>
</body>


</html>