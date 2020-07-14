# Subsite Cards


WordPress plugin that adds a shortcode `[subsite-cards]` which displays a multisite's *public* subsites as Bootstrap 4 cards, displaying:

**custom_logo** (*get_theme_mod()*)<br>
**blogname** and **url** (*bloginfo()*)<br>
**rss2_url** link (*bloginfo()*)<br>
**description** (*bloginfo()*)

Optional attributes:

<table>
<thead>
<tr>
<th>attribute</th>
<th>default value</th>
<th>example</th>
</tr>
</thead>
<tbody>
<tr>
<td>image_fallback</td>
<td style="word-break: break-all;">'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVQImWPImXXyPwAGFALPyD6HvAAAAABJRU5ErkJggg=='</td>
<td>image_fallback="<a href="https://some.url/img.png" rel="nofollow">https://some.url/img.png</a>"</td>
</tr>
<tr>
<td>exclude_sites</td>
<td></td>
<td>exclude_sites="1,5"</td>
</tr>
<tr>
<td>rss_icon_class</td>
<td>fal fa-rss</td>
<td>rss_icon_class="fas fa-rss-square"</td>
</tr>
</tbody>
</table>

Examples:

`[subsite-cards]`

`[subsite-cards exclude_sites="1"]`

`[subsite-cards exclude_sites="1,4" image_fallback="https://some.url/img.png" rss_icon_class="fas fa-rss"]`
