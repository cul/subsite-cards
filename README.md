# Subsite Cards

WordPress plugin that adds a shortcode `[subsite-cards]` which displays a multisite's *public* subsites as Bootstrap 4 cards, displaying:

**custom_logo** image (*get_theme_mod()*)<br>
**blogname** and **url** (*bloginfo()*)<br>
**rss2_url** link (*bloginfo()*)<br>
**description** (*bloginfo()*)

#### Customizable attributes:

* `autostyle`
  * default: *false*
  * example: *`true`*
  * note: set to *true* to apply opinionated styles to the cards. otherwise BS4 defaults will be used. or create your own from the *.subsiteCard* class downward.
* `exclude_sites`
  * default:
  * example: *`exclude_sites="1,5"`*
* `grid_class`
  * default: *col-6 col-md-3*
  * example: *`col-6 col-sm-4 col-lg-2`*
* `image_fallback`
  * default: *'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWPImXXyPwAGFALPyD6HvAAAAABJRU5ErkJggg=='*
  * example: *`image_fallback="https://some.url/img.png"`*
* `orderby`
  * default: *path* (alphabetical by /path/ name)
  * options: *path* or *last_updated*
  * example: *`last_updated`*
* `display_order`
  * default:
  * example: *`display_order="4,5,3,2,7"`*
  * note: specify the order that cards are displayed. overrides `orderby`.
* `rss_icon_class`
  * default: *fal fa-rss*
  * example: *`rss_icon_class="fas fa-rss-square"`*

#### Examples:

`[subsite-cards]`

`[subsite-cards exclude_sites="1" autostyle="true"]`

`[subsite-cards exclude_sites="1,4" image_fallback="https://some.url/img.png" rss_icon_class="fas fa-rss" grid_class="col-6 col-md-4" orderby="last_updated" autostyle="true"]`
