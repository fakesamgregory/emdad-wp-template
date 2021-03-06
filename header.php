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
$firstSkill;
$firstProject;

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
$args = array(
     'category_name' => 'Skills',
     'posts_per_page' => 1,
     'order' => 'DESC'
);
$my_query = new WP_Query($args);
while ($my_query->have_posts()) {
  $my_query->the_post();
  $firstSkill = get_permalink();
}

$args = array(
     'category_name' => 'Projects',
     'posts_per_page' => 1,
     'order' => 'DESC'
);
$my_query = new WP_Query($args);
while ($my_query->have_posts()) {
  $my_query->the_post();
  $firstProject = get_permalink();
}

global $current_user;
get_currentuserinfo(); 

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
<div id="page" class="hfeed site<?php if (!$current_user->caps && $blogPage) { echo ' log-in'; } ?>">
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
						<li><a href="<?php if (!is_front_page()) { bloginfo('url'); } ?>#top"<?php if (is_front_page()) { echo ' class="jump-link"'; } ?>>Home</a></li>
						<li class="<?php if (!is_front_page()) { echo ' active'; } ?>"><a href="<?php if (!is_front_page()) { echo '#'; } else { echo '#projects'; } ?>"<?php if (!is_front_page()) { echo ' class="dropdown"'; } else if (is_front_page()) { echo ' class="jump-link"'; } ?>>Projects</a></li>
						<li><a href="<?php if (!is_front_page()) { bloginfo('url'); } ?>#contact"<?php if (is_front_page()) { echo ' class="jump-link"'; } ?>>Contact</a></li>
					</ul>
				</nav>	
			</div>
			<?php if ($blogPage && $current_user->caps) { ?>
			<div class="drop-menu">
				<?php  if ($blogPage) {
					get_template_part( 'template-parts/content', 'projects' );
				} ?>
			</div>				
			<?php } ?>	
		</div><!-- .content__section -->
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ($blogPage && $current_user->caps) : ?>
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