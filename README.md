# Subsite Cards


WordPress plugin that adds a shortcode `[subsite-cards]` which displays a multisite's *public* subsites as Bootstrap 4 cards, displaying:

get_theme_mod *custom_logo*, bloginfo *blogname* and link, bloginfo *rss2_url* link (uses FontAwesome fa-rss icon), and bloginfo *description*).

Optional attributes:

attribute | default value | example
--- | --- | ---
image_fallback | 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWPImXXyPwAGFALPyD6HvAAAAABJRU5ErkJggg==' | image_fallback="https://some.url/img.png"
exclude_sites | | exclude_sites="1,5"
rss_icon_class | fal fa-rss | rss_icon_class="fas fa-rss-square"

Examples:

`[subsite-cards]`

`[subsite-cards exclude_sites="1"]`

`[subsite-cards exclude_sites="1,4" image_fallback="https://some.url/img.png" rss_icon_class="fas fa-rss"]`
