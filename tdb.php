<?php session_start(); ?>
<?php require './verification.php'; ?>
<?php require './template-parts/header-tdb.php'; ?>

<?php 

	if( !empty( $_GET['action'] ) ) {
		
		switch( $_GET['action'] ) {
			case 'profil' :
				$affichage = 'profil.php';
			break;
			case 'membres' :
				$affichage = 'membres.php';
			break;
			case 'ajout-article' :
				$affichage = 'ajout-article.php';
			break;
			case 'liste-articles' :
				$affichage = 'liste-articles.php';
			break;
			case 'favoris' :
				$affichage = 'favoris.php';
			break;
		}
	
	} else {
		// premier passage
	}

 ?>

<div id="page">
	
	<div class="sidebar">
		<aside><?php include './template-parts/sidebar.php'; ?></aside>
	</div>

	<div class="content">
		<section>
			<?php include './template-parts/'.$affichage; ?>
		</section>
	</div>
	

</div>


<?php include './template-parts/footer.php'; ?>