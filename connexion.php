<?php

	define ( 'LOGIN', 'administrateur' );
	define ( 'PASS', 'mdp' );


	if( !empty( $_POST ) ) {

		
		$identifiant 	=  !empty( $_POST['identifiant'] ) ? $_POST['identifiant'] : '' ; 
		$mdp 			=  !empty( $_POST['mdp'] ) ? $_POST['mdp'] : '' ;
		$stay_connected =  !empty( $_POST['session'] )  ? $_POST['session'] : '' ;

		// (2) insertion de toutes les valeurs connues

		$bdd = new PDO('mysql:host=localhost;dbname=wil-bakery', 'root', '');

		if( $bdd ) {

			$sql = "SELECT count(*) AS nombre FROM membres WHERE (identifiant='$identifiant' OR mail='$identifiant') AND (mdp='$mdp')";

			$resultat = $bdd->query( $sql);

			if( $resultat ) {
				
				$membre = $resultat->fetchColumn();

				if( $membre != 1 ) {
					$error_message = 'Identiant/mot de passe incorrects';
					$success=false; 
				} else {
					$success=true;
					$mdp = ''; 
				} // if membre

				$sql = "INSERT INTO log (login, mdp, success, date_tentative, ip) VALUES 
				(:login, :mdp, :success, :date_tentative, :ip)";

				$requete = $bdd->prepare( $sql );

				$requete->execute([
					'login' 			=>	$identifiant,
					'mdp'				=>	$mdp,
					'success'			=>	$success,
					'date_tentative' 	=>	date( 'Y-m-j H:i:s' ),
					'ip' 				=>	$_SERVER['REMOTE_ADDR']
				]);

				if( empty( $error_message ) ) {
					// setcookie( 'user', 'connecté', $expiration );
					session_start();
					$_SESSION['identifiant'] = $identifiant;
					$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

					header( 'Location: ./tdb.php');
				}

			} // if resultat

		} // if bdd


	} 
?>
<?php require './template-parts/header.php'; ?>

<div id="page">
	
	<div class="content">
		
		<section class="formulaire">



			<form action="" method="post">

				<?php if( !empty( $error_message ) ) { ?>

					<div class="error-message"><?php echo $error_message; ?></div>

				<?php } ?>

				<label for="identifiant">
					<input type="text" name="identifiant" id="identifiant" placeholder="Identifiant">
				</label>
				
				<label for="mdp">
					<input type="password" name="mdp" id="mdp" placeholder="Mot de passe">
				</label>
				
				<label for="session">
					<input type="checkbox" name="session" id="session">&nbsp;Rester connecté
				</label>
		
				<input type="submit" name="valider" id="valider" value="Connexion" />

			</form>

		</section>

	</div>
	

	<div class="sidebar">
		<aside><?php include './template-parts/sidebar.php'; ?></aside>
	</div>


</div>


<?php include './template-parts/footer.php'; ?>