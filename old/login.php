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
		  echo "<h1>Identification r�ussie</h1>";
    die('Requ�te invalide : ' . mysql_error());
	}

	


	//PHP Session
	session_start();

	if ($_SESSION["Login"] != "YES") {
	  header("Location: form.html");
	}

	?>
	</html>

