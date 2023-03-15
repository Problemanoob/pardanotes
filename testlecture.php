<?
//Ouverture du fichier
$fichier = file("matiere.txt");
$page = "";
//Parcours du fichier
for ($i = 0; $i < count($fichier); $i++) {
	$page .= "<li>" . explode(";", $fichier[$i])[0] . " : " . explode(";", $fichier[$i])[1] . "</li>";
}
echo "<ul>$page</ul>";