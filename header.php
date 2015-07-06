 <?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package emdad-portfolio
 */
$linkedinId = "#background-experience";
$blogPage = false;
global $post;
$page = get_the_category($post->ID);
$page = $page[0]->name;

if ( is_front_page() && is_home() ) {
  // Default homepage
} elseif ( is_front_page() ) {
  // static homepage
} elseif ( is_home() ) {
  // blog page
} else {
  //everything else
	$blogPage = true;
}

?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site<?php if ($blogPage) { ?> template-two<?php } ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'emdad' ); ?></a>

	<header id="masthead" class="site-header mod-header content header--sticky<?php if (!$blogPage) { ?> content--dark<?php } ?>" role="banner">
		<div class="content__section">
			<div class="header__main-content header__main-content--open">
				<h1>
					<a href="<?php if ($blogPage) { echo get_settings("home"); } else { echo '#top'; } ?>">
						<?php bloginfo( 'name' ); ?>
						<span class="sub-head"><?php bloginfo( 'description' ); ?></span>								
					</a>
				</h1>
				<nav role="navigation">
					<ul class="main-nav list-inline">
						<li><a href="<?php if ($blogPage) { bloginfo('url'); } ?>#top"<?php if (!$blogPage) { echo ' class="jump-link"'; } ?>>Home</a></li>
						<li<?php if ($page == 'Projects') { echo ' class="active"'; } ?>><a href="<?php if ($page == 'Projects') { echo '#'; } else if ($blogPage) { bloginfo('url').'#projects'; } else { echo '#projects'; } ?>"<?php if ($page == 'Projects') { echo ' class="dropdown" data-menu="projects-menu"'; } ?>>Projects</a></li>
						<li<?php if ($page == 'Skills') { echo ' class="active"'; } ?>><a href="<?php if ($page == 'Skills') { echo '#'; } else if ($blogPage) { bloginfo('url').'#skills'; } else { echo '#skills'; } ?>"<?php if ($page == 'Skills') { echo ' class="dropdown" data-menu="projects-menu"'; } ?>>Skills</a></li>
						<li><a href="<?php if ($blogPage) { bloginfo('url'); } ?>#touchpoints"<?php if (!$blogPage) { echo ' class="jump-link"'; } ?>>Touchpoints</a></li>
						<li><a href="<?php if ($blogPage) { bloginfo('url'); } ?>#contact"<?php if (!$blogPage) { echo ' class="jump-link"'; } ?>>Contact</a></li>
					</ul>
				</nav>	
			</div>
			<?php if ($blogPage) { ?>
			<div class="projects projects-menu drop-menu">
				<?php  if ($page == 'Projects') {
					get_template_part( 'template-parts/content', 'projects' );
				} else if ($page == 'Skills') {
					get_template_part( 'template-parts/content', 'skills' );
				} ?>
			</div>				
			<?php } ?>	
		</div><!-- .content__section -->
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ($blogPage) : ?>
				<?php if( have_rows('section') ): ?>
					<?php if (count(get_field('section')) > 1) : ?>
						<?php $i = 0; ?>					
						<div class="second-nav">
							<nav>
								<ul class="list-inline content__section sub-menu">
								<?php while( have_rows('section') ): the_row(); ?>
									<?php $company = get_sub_field('company'); ?>
									<li<?php if($i == 0) { echo ' class="active"'; } ?>><a href="#<?php echo preg_replace('/[^a-zA-Z0-9]+/', '-', strtolower($company)); ?>" class="jump-link"><?php echo $company; ?></a></li>
									<?php $i++; ?>						
								<?php endwhile; ?>
								</ul>
							</nav>
						</div><!-- .second-nav -->
					<?php endif; // count > 1 ?>
				<?php endif; // have row section ?>
			<?php endif; // $blogpage ?>
		<?php endwhile; // the loop ?>
	</header><!-- #masthead -->