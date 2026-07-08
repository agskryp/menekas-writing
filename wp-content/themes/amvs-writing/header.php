<?php
	$home_class 	 = is_page_template( 'template-home.php' ) ? ' home-page-container' : '';
	$title_element = is_front_page() ? 'h1' : 'p';
	$linkedin_url  = amvs_writings_site_options( 'linkedin_url' );
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
				<?php the_custom_logo(); ?>

				<button
					class="mobile-menu-toggle"
					type="button"
					aria-controls="primary-navigation"
					aria-expanded="false"
					data-mobile-menu-open
				>
					<span class="screen-reader-text"><?php esc_html_e( 'Open menu', 'amvs-writing' ); ?></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
					<span aria-hidden="true"></span>
				</button>
				
				<div class="nav-container" id="primary-navigation">
					<button
						class="mobile-menu-close"
						type="button"
						aria-controls="primary-navigation"
						data-mobile-menu-close
					>
						<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'amvs-writing' ); ?></span>
						<span aria-hidden="true"></span>
						<span aria-hidden="true"></span>
					</button>

					<?php if( !empty( $linkedin_url ) ) { ?>
						<a 
							class="linkedin-icon" 
							href="<?php echo esc_url( $linkedin_url ); ?>" 
							target="_blank" 
							rel="noopener"
						>
							<span class="screen-reader-text">Connect with me on LinkedIn</span>

							<?php get_template_part( 'components/icon-linkedin' ); ?>
						</a>
					<?php } ?>

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
						class="cta-button"
					>
						<?php esc_html_e( 'Contact', 'amvs-writing' ); ?>
					</button>
				</div>
			</nav>
		</header>
