<html>
<head>
</head>
<body>
	
	<h1>PLOP</h1>
	
	<?php
		require "mysql_connect.php";
	
		$db = 'WallExperimentMA';

		$requete= "ALTER TABLE comptes MODIFY montant REAL";

		$result = mysql_query($requete) or die('Erreur SQL !<br />'.$requete.'<br />'.mysql_error());


    /*	while($data = mysql_fetch_array($result)) {
			echo '<br />'.$data['Field'];
    	}*/
		mysql_close(); 
	?>

</body>
</html>