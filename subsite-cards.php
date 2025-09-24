<?php
/**
 * Display multisite's public subsites
 *
 * @package SubsiteCards
 */

/*
Plugin Name: Subsite Cards
Plugin URI: https://github.com/cul/subsite-cards
Description: WordPress shortcode [subsite-cards] displays a multisite's public subsites as bs4 cards (with theme's custom_logo, blogname, rss2 feed link, and description). see the README (https://github.com/cul/subsite-cards/blob/master/README.md) for optional args.
Version: 1.1.5
Author: er2576
Author URI: https://github.com/er-k/
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

define( 'SC_VERSION', '1.1.5' );

/**
 * The subsitecards
 *
 * @param array<string, mixed> $atts {
 *     subsite-cards attributes.
 *
 *     @type string $exclude_sites    optional. comma-separated list of site ids to exclude. default empty.
 *     @type string $image_fallback   optional. fallback image (data uri or url) if no image is available.
 *                                    default is a base64-encoded png.
 *     @type string $rss_icon_class   optional. css classes for the rss icon. default 'fal fa-rss'.
 *     @type string $grid_class       optional. css classes used for grid layout. default 'col-6 col-md-3'.
 *     @type string $orderby          optional. field to order items by (e.g., 'path', 'title'). default 'path'.
 *     @type bool   $autostyle        optional. whether to apply automatic styling. default false.
 *     @type bool   $display_order    optional. whether to display order numbers or positions. default false.
 *     @type string $image_derivative optional. image size/derivative to use (e.g., 'thumbnail', 'medium_large'). default 'medium_large'.
 * }
 * @return string subsite-cards output.
 */
function subsitecards( $atts = array() ) {
	$atts           = array_change_key_case( (array) $atts, CASE_LOWER );
	$flags          = shortcode_atts(
		array(
			'exclude_sites'    => '',
			'image_fallback'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWPImXXyPwAGFALPyD6HvAAAAABJRU5ErkJggg==',
			'rss_icon_class'   => 'fal fa-rss pl-3',
			'grid_class'       => 'col-6 col-md-3',
			'orderby'          => 'path',
			'autostyle'        => false,
			'display_order'    => false,
			'image_derivative' => 'medium_large',
		),
		$atts
	);
	$rss_icon_class = esc_attr( $flags['rss_icon_class'] );
	$grid_class     = esc_attr( $flags['grid_class'] );
	$orderby        = ( in_array( $flags['orderby'], array( 'path', 'last_updated' ), true ) ) ? $flags['orderby'] : 'path';

	$args = array(
		'public'       => 1,
		'spam'         => 0,
		'deleted'      => 0,
		'archived'     => 0,
		'site__not_in' => $flags['exclude_sites'],
		'orderby'      => $orderby,
		'ID'           => false,
	);
	if ( $flags['display_order'] ) {
		$sites   = array();
		$site_id = explode( ',', $flags['display_order'] );
		foreach ( $site_id as $site ) {
			$arg     = array( 'ID' => $site );
			$sites[] = get_sites( $arg )[0];
		}
	} else {
		$sites = get_sites( $args );
	}
	$output = '';

	$card = <<<EOC
    <div class="subsiteCard $grid_class">
      <div class="card bg-white border-0 h-100">
        <img src="%1\$s" class="card-img-top" alt="%6\$s">
        <article class="card-body d-flex p-1">
          <a href="%2\$s" class="d-flex stretched-link">
            <div class="d-flex align-content-start flex-wrap">
              <h3 class="card-title pr-1 h5 w-100 text-primary">
                %3\$s
              </h3>
              <p class="card-text d-none d-md-block text-muted text-decoration-none">%4\$s</p>
            </div>
          </a><a href="%5\$s" style="z-index:1;" aria-label="RSS Feed"><i class="$rss_icon_class"></i></a>
        </article>
      </div>
    </div>
EOC;

	if ( 'true' === $flags['autostyle'] ) {
		wp_enqueue_style( 'subsite-cards-styles' );
	}

	foreach ( array_filter( $sites ) as $site ) {
		switch_to_blog( $site->blog_id );
		$description      = get_bloginfo( 'description' );
		$burl             = get_bloginfo( 'url' );
		$rurl             = get_bloginfo( 'rss2_url' );
		$custom_logo_id   = get_theme_mod( 'custom_logo' );
		$image            = ( has_custom_logo() ? wp_get_attachment_image_src( $custom_logo_id, $flags['image_derivative'] )[0] : $flags['image_fallback'] );
		$custom_logo_attr = array(
			'class'   => 'custom-logo',
			'loading' => false,
		);
		$image_alt        = get_post_meta( $custom_logo_id, '_wp_attachment_image_alt', true );
		$image_alt_txt    = ( empty( $image_alt ) ) ? "$site->blogname" : $image_alt;
		$output          .= sprintf( $card, $image, $burl, $site->blogname, $description, $rurl, $image_alt_txt );
		restore_current_blog();
	}
	return '<div class="row h-100 my-4">' . $output . '</div>';
}

/**
 * The load_plugin_css
 */
function load_plugin_css() {
	wp_register_style( 'subsite-cards-styles', plugin_dir_url( __FILE__ ) . 'subsite-cards.css', array(), SC_VERSION );
}
add_action( 'wp_enqueue_scripts', 'load_plugin_css' );

/**
 * The init
 */
function subsite_cards_init() {
	add_shortcode( 'subsite-cards', 'subsitecards' );
}

add_action( 'init', 'subsite_cards_init' );
