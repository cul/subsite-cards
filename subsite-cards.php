<?php
/*
Plugin Name: Subsite Cards
Plugin URI: https://github.com/cul/subsite-cards
Description: Wordpress shortcode [subsite-cards] displays a multisite's public subsites as bs4 cards (with theme's custom_logo, blogname, rss2 feed link, and description). see the README (https://github.com/cul/subsite-cards/blob/master/README.md) for optional args.
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
        'rss_icon_class' => 'fal fa-rss',
        'grid_class' => 'col-6 col-md-3',
        'orderby' => 'path',
        'autostyle' => false,
    ), $atts
  );
  $rss_icon_class = esc_attr($flags['rss_icon_class']);
  $grid_class = esc_attr($flags['grid_class']);
  $orderby = (in_array($flags['orderby'],['path','last_updated'])) ? $flags['orderby'] : 'path';
  $args = array(
      'public'        => 1,
      'spam'          => 0,
      'deleted'       => 0,
      'archived'      => 0,
      'site__not_in'  => $flags['exclude_sites'],
      'orderby'       => $orderby,
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
  $autostyle = ($flags['autostyle'] == 'true') ? $style : '';
  $card = <<<EOC
    <div class="subsiteCard $grid_class">
      <div class="card bg-white border-0 h-100">
        <a href="%2\$s">
          <img src="%1\$s" class="card-img-top" alt="...">
        </a>
        <article class="card-body d-flex p-1">
          <a href="%2\$s" class="d-flex">
            <div class="d-flex align-content-start flex-wrap">
              <h3 class="card-title pr-1 h5 w-100 text-primary">
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
  return $autostyle.'<div class="row h-100 my-4">'.$output.'</div>';
}

function subsiteCards_init()
{
    add_shortcode('subsite-cards','subsitecards');
}

add_action('init', 'subsiteCards_init');
