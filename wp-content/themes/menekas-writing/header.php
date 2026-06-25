<!doctype html>

<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<div id="page" class="site">
		<a 
			class="skip-link screen-reader-text" 
			href="#primary"
		><?php esc_html_e( 'Skip to content', 'menekas-writing' ); ?></a>

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
				
				<?php
					wp_nav_menu( array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'container'      => false,
					) );
				?>
			</nav>
		</header>
