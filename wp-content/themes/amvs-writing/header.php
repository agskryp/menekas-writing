<?
	$home_class = is_page_template( 'template-home.php' ) ? ' home-page-container' : '';
?>

<!doctype html>

<html <?php language_attributes(); ?> data-theme="light">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site<?php echo $home_class; ?>">
		<a 
			class="skip-link screen-reader-text" 
			href="#primary"
		><?php esc_html_e( 'Skip to content', 'amvs-writing' ); ?></a>

		<header id="masthead" class="site-header">
			<nav class="container">
				<ul>
					<li>
						<?php
							the_custom_logo();
						
							if ( is_front_page() ) {
						?>
							<h1 class="site-title">
								<a 
									href="<?php echo esc_url( home_url( '/' ) ); ?>" 
									rel="home"
								><?php bloginfo( 'name' ); ?></a>
							</h1>
						<?php
							} 
							
							else {
						?>
							<p class="site-title">
								<a 
									href="<?php echo esc_url( home_url( '/' ) ); ?>" 
									rel="home"
								><?php bloginfo( 'name' ); ?></a>
							</p>
						<?php } ?>
					</li>
				</ul>
				
				<div class="nav-container">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'menu_class'		 => 'main-menu',
							'container'      => false,
						) );
					?>

					<button
						type="button"
						data-open-modal="contact-modal"
						aria-haspopup="dialog"
					>
						<?php esc_html_e( 'Contact', 'amvs-writing' ); ?>
					</button>
				</div>
			</nav>
		</header>
