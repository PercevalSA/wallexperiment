<html lang="fr">
<!-- 
  the cake is a lie
-->
<head>
	<meta charset="utf-8">
	<title>WallExperiment</title>
	<meta name="description" content="a money managemnt tool for icam studnets">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="style.css">
</head>
<body>

	<h1>Etat complet de la base données</h1>

<div class=statistiques>

	<?php
		require "mysql_connect.php";
	
		$db = 'WallExperimentMA';

		echo "<h3>Desc Table users</h3>";
		$requete= "DESC users";
		$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
    	while($data = mysql_fetch_array($result)) {
			echo '<br />'.$data['Field'].' : '.$data['Type'].' : '.$data['Null'].' : '.$data['Key'].' : '.$data['Default'].' : '.$data['Extra'].' : ';
		}

    	echo "<br />";

		echo "<h3>Desc Table comptes</h3>";
		$requete= "DESC comptes";
		$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
    	while($data = mysql_fetch_array($result)) {
			echo '<br />'.$data['Field'].' : '.$data['Type'].' : '.$data['Null'].' : '.$data['Key'].' : '.$data['Default'].' : '.$data['Extra'].' : ';
    	}

    	echo "<hr>";

		echo "<h3>Select * From users</h3>";
    	$requete= "SELECT * FROM users";
		$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
    	while($data = mysql_fetch_array($result)) {
			echo '<br />'.$data['id'].' | '.$data['login'].' | '.$data['password'].' | '.$data['nom'].' | '.$data['prenom'].' | '.$data['mail'].' | '.$data['naissance'].' | ';
    	}

		echo "<hr>";

		echo "<h3>Select * From comptes</h3>";
		$requete= "SELECT * FROM comptes";
		$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());
    	while($data = mysql_fetch_array($result)) {
			echo '<br />'.$data['id'].' | '.$data['date'].' | '.$data['type'].' | '.$data['titre'].' | '.$data['montant'].' | '.$data['user'].' | ';
    	}

    	echo "<hr>";

		mysql_close(); 
	?>
</div>
</body>
</html>