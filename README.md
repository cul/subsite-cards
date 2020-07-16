# Subsite Cards


WordPress plugin that adds a shortcode `[subsite-cards]` which displays a multisite's *public* subsites as Bootstrap 4 cards, displaying:

**custom_logo** image (*get_theme_mod()*)<br>
**blogname** and **url** (*bloginfo()*)<br>
**rss2_url** link (*bloginfo()*)<br>
**description** (*bloginfo()*)

#### Customizable attributes:

* `image_fallback`
  * default: *'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWPImXXyPwAGFALPyD6HvAAAAABJRU5ErkJggg=='*
  * example: *`image_fallback="https://some.url/img.png"`*
* `exclude_sites`
  * default:
  * example: *`exclude_sites="1,5"`*
* `rss_icon_class`
  * default: *fal fa-rss*
  * example: *`rss_icon_class="fas fa-rss-square"`*
* `grid_class`
  * default: *col-6 col-md-3*
  * example: *`col-6 col-sm-4 col-lg-2`*
* `orderby`
  * default: *path* (alphabetical by /path/ name)
  * options: *path* or *last_updated*
  * example: *`last_updated`*

#### Examples:

`[subsite-cards]`

`[subsite-cards exclude_sites="1"]`

`[subsite-cards exclude_sites="1,4" image_fallback="https://some.url/img.png" rss_icon_class="fas fa-rss" grid_class="col-6 col-md-4" orderby="last_updated"]`
