<?php
/**
 * Template part for displaying posts as ad cards in my-account
 *
 * @package emeon
 */

$def_image = EMEON_URL . '/img/user-icon.png';

$adedit_url = apply_filters( 'emeon_adedit_url', '/add-edit/' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'account-article' ); ?>>

    <span class="article-menu">
	    <button class="article-menu__button"></button>
        <ul class="article-menu__menu list-group">
            <li class="article-menu__item list-group-item list-group-item-action"><a href="<?= $adedit_url ?>?ad=<?php the_ID() ?>">Edit</a></li>
            <li class="article-menu__item item-bl list-group-item list-group-item-action"><a href="<?= esc_url( get_permalink() ) ?>">View</a></li>
            <li class="article-menu__item delete-item list-group-item list-group-item-action" data-title="<?= the_title() ?>"><a
		            href="?trash=<?php the_ID() ?>">Delete</a></li>
        </ul>
    </span>

	<a href="<?= esc_url( get_permalink() ) ?>" rel="bookmark">

		<?php emeon_post_thumbnail(); ?>

		<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta">
				<?php
				emeon_posted_on();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->

	</a>

	<button class="button button-cta actualize-article">Actualize</button>

</article><!-- #post-<?php the_ID(); ?> -->
