<?php
/*
Plugin Name: Subsite Cards
Plugin URI: https://github.com/cul/subsite-cards
Description: Wordpress shortcode [subsite-cards] displays a multisite's public subsites as bs4 cards (with theme's custom_logo, blogname, rss2 feed link, and description). optional shortcode args include: image_fallback="https://some.url/img.png", exclude_sites="1,5" (site ids to exclude), and rss_icon_class.
Version: 1.0.0
Author: er2576
Author URI: https://github.com/er-k/
License: MIT
License URI: https://opensource.org/licenses/MIT
*/

function subsitecards($atts = []) {
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $flags = shortcode_atts(
      array(
          'exclude_sites'   => '',
          'image_fallback'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWPImXXyPwAGFALPyD6HvAAAAABJRU5ErkJggg==',
          'rss_icon_class'  => 'fal fa-rss',
      ), $atts
    );
    if ( ! empty( $atts['exclude_sites'] ) ) {
      $flags['exclude_sites'] = array_map('intval', explode( ',', $atts['exclude_sites'] ) );
    }
    if ( ! empty( $atts['image_fallback'] ) ) {
      $flags['image_fallback'] = esc_url_raw($atts['image_fallback']);
    }
    if ( ! empty( $atts['rss_icon_class'] ) ) {
      $flags['rss_icon_class'] = esc_attr($atts['rss_icon_class']);
    }
    $rss_icon_class = $flags['rss_icon_class'];
    $args = array(
        'public'        => 1,
        'spam'          => 0,
        'deleted'       => 0,
        'archived'      => 0,
        'site__not_in'  => $flags['exclude_sites'],
    );
    $sites = get_sites($args);
    $output = '';
    $style = <<<EOS
    <style>
    .subsiteCard .card-body {
      justify-content: space-between;
    }
    .subsiteCard .card-img-top {
      width: 100%;
      height: 15vw;
      object-fit: cover;
    }
    .subsiteCard a:hover {
      text-decoration:none;
    }
    .subsiteCard h3:hover {
      text-decoration:underline!important;
    }
    .subsiteCard .fa-rss:hover {
      color:var(--success);
    }
    </style>
    EOS;
    $card = <<<EOC
    <div class="col-6 col-md-3 subsiteCard">
      <div class="card bg-white border-0 h-100">
        <a href="%2\$s">
          <img src="%1\$s" class="card-img-top" alt="...">
        </a>
        <article class="card-body d-flex p-1">
          <a href="%2\$s" class="d-flex">
            <div class="d-flex align-content-start flex-wrap">
              <h3 class="card-title h5 w-100 text-primary">
                %3\$s
              </h3>
              <p class="card-text d-none d-md-block text-muted text-decoration-none">%4\$s</p>
            </div>
          </a><a href="%5\$s"><i class="$rss_icon_class"></i></a>
        </article>
      </div>
    </div>
    EOC;
    foreach ( $sites as $site ) {
        switch_to_blog( $site->blog_id );
                $description = get_bloginfo('description');
                $burl = get_bloginfo('url');
                $rurl = get_bloginfo('rss2_url');
                $image = (has_custom_logo() ? wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) , 'full' )[0] : $flags['image_fallback']);
                $output .=  sprintf(  $card, $image, $burl, $site->blogname, $description, $rurl  );
        restore_current_blog();
    }
    return $style.'<div class="row h-100 my-4">'.$output.'</div>';
}

function subsiteCards_init()
{
    add_shortcode('subsite-cards','subsitecards');
}

add_action('init', 'subsiteCards_init');
