	<html>

	<head>
	<title>Login</title>

	</head>
	<body>

	<?php
	mysql_connect("localhost","eleve.tou","et*301");
	mysql_select_db("Gestion portefeuille experiment (mayeul et antoine)"); 
	
	$identifiant=$_POST['identifiant'];
	$motdepasse=$_POST['motdepasse'];
	// Check nom d'utilisateur et PW
	$_requete = if ($_POST['identifiant'] == "Compte.identifiant" && $_POST['motdepasse'] == "Compte.PassWord");
	$result =mysql_query( $_requete );
	if (!$result) {
		  echo "<h1>Identification réussie</h1>";
    die('Requête invalide : ' . mysql_error());
	}

	


	//PHP Session
	session_start();

	if ($_SESSION["Login"] != "YES") {
	  header("Location: form.html");
	}

	?>
	</html>

