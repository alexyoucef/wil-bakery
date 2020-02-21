<?php require './template-parts/header.php'; ?>

<div id="page">
	
	<div class="content">
		<section>

			<?php

				$visiteurs = array();

				$filename 	=	'./data-files/visiteurs.txt'; 
		
				$handler = fopen($filename, 'r');
				if( $handler ) {
					while (($buffer = fgets($handler, filesize($filename))) !== false) {
				 		$visiteurs[] = $buffer; 
	     			}
				}

				if( !empty( $visiteurs ) ) {
					foreach( $visiteurs as $visiteur) {
						echo $visiteur.'<br>';
					}
				}

			?>

		</section>
	</div>
	

	<div class="sidebar">
		<aside><?php include './template-parts/sidebar.php'; ?></aside>
	</div>


</div>


<?php include './template-parts/footer.php'; ?>