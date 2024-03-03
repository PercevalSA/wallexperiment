<html>
	<head>
		
	</head>
	<body>
	
	<?php
		mysql_connect("localhost","eleve.tou","et*301");
	mysql_select_db("Gestion portefeuille experiment (mayeul et antoine)"); 
	$Nom=$_POST['Nom'];
	$Prenom=$_POST['Prenom'];
	$Adresse_mail=$_POST['Adresse_mail'];
	
	$_requete = "SELECT Email FROM Compte WHERE (Compte.identifiant='$identifiant' and Compte.PassWord='$PassWord')"; 
	$result =mysql_query( $_requete );
	if (!$result) {
    die('Requête invalide : ' . mysql_error());
	}
	echo '$_requete';
	?>
	</body>
</html>
