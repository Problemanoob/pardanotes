<?
if (isset($_POST["username"])) {
	$username = $_POST["username"];
} else if (isset($_GET["username"])) {
	$username = $_GET["username"];
} else {
	$username = "Inconnu";
}
# Chemin vers fichier texte
$file = "help.txt";

# Ouverture en mode écriture
$fileopen = (fopen("$file", "a+"));
$date = new DateTime('now');
fwrite($fileopen, $date->format('Y-m-d H:i:s') . ";" . $username);
fwrite($fileopen, "\n");
# On ferme le fichier proprement
fclose($fileopen);
header("Location: saisirAide.php?username=$username");

?>