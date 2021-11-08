![Namespaced - Dokuwiki template](/images/namespaced_logo_800.png)
# dokuwiki-template-namespaced

<!--
---- template ----
description   : Namespaced DokuWiki template
author        : Simon DELAGE
email         : sdelage@gmail.com
lastupdate_dt : 2019-12-15
compatible    : !Greebo
depends       : 
conflicts     : # prefix templates by template:
similar       : 
screenshot_img: # URL to a screenshot (should be a bigger one)
tags          : experimental, flexbox, hooks, html5, modern, namespace, polymorphic, responsive, scrollspy, sidebar, topbar, translation, wordpress

downloadurl   : http://github.com/Geekitude/dokuwiki-template-namespaced/zipball/master
bugtracker    : http://github.com/Geekitude/dokuwiki-template-namespaced/issues
sourcerepo    : http://github.com/Geekitude/dokuwiki-template-namespaced/
donationurl   : https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FE645CXCLH49U
----
-->

An experimental and highly customizable DokuWiki template based on flexbox with many namespace related features.

It is based on Dokuwiki's default template.

    See template.info.txt for template details
    See LICENSE for license info

## Credits

### Third party modules

* [Normalize - 8.0.1](https://necolas.github.io/normalize.css/)
* [Auth0 / kbd](https://github.com/auth0/kbd/) (note that you need to enable HTML or use Keyboard plugin)
* [Web Font Loader - 1.6.28](https://github.com/typekit/webfontloader) to nicely load fonts from Google Web Fonts, distributed under [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0)
* [Advanced News Ticker - 1.0.11](http://risq.github.io/jquery-advanced-news-ticker/), distributed under [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.en.html)
* [JDENTICON - 2.2.0](https://jdenticon.com/) to add modern and highly recognizable identicons, distributed under [zlib License](https://www.zlib.net/zlib_license.html)
* Context logo Lighbox effect uses [Lity - 2.4.0](https://sorgalla.com/lity/), distributed under [MIT License](https://en.wikipedia.org/wiki/MIT_License)
* ToC scrollspy effect is provided by [Gumshoe - 5.1.2](https://github.com/cferdinandi/gumshoe), distributed under [MIT License](https://en.wikipedia.org/wiki/MIT_License)

### Extra

* Default optional background pattern comes from [Subtle Patterns](https://www.toptal.com/designers/subtlepatterns/)
* SVG icons come from [Material Design Icons](https://materialdesignicons.com)
* [Dummy avatar](https://imgbin.com/png/r454K96z) is free for non commercial use
* Extracting color from image comes from a comment on [this page](https://stackoverflow.com/questions/10290259/detect-main-colors-in-an-image-with-php)
* Font used for sample UI images (banner, widebanner and sidebar.png) is: [Reckoner by Alex Dale](https://www.behance.net/alexiandale).
* Special thanks to Giuseppe Di Terlizzi, author of [Bootstrap3](https://www.dokuwiki.org/template:bootstrap3) DokuWiki template who nicely acepted that I copy some of his code to build admin dropdown menu.

## Main features

See [Settings](https://github.com/geekitude/dokuwiki-template-namespaced#settings) and [About](https://github.com/geekitude/dokuwiki-template-namespaced#about) sections below for details about these features.

* [x] [Widgets](https://github.com/geekitude/dokuwiki-template-namespaced#widgets) areas to customize Namespaced elements (any side widget will force side panel even if there's no sidebar page available)
* [x] Accessibility friendly pure CSS smooth scrolling (speed depends on visitor's browser settings and can even be disable if browser supports that feature)
* [ ] Namespace dependent CSS for colors and fonts (an automatic theme color is possible while quite experimental)
* [ ] Namespace dependent UI images ([ ] background pattern, [x] banner, [x] widebanner and a potential [x] sidebar header image aka sidecard)
* [ ] Google Fonts : each of main text, headings, condensed text (mostly nav bar) and monospaced text (```code``` syntax) can use a different Google font (be warned that main text font should be kept very readable)
* [ ] Wide banner slider with latest changes at wiki home?
* [ ] Tested with most common plugins ([Blockquote](https://www.dokuwiki.org/plugin:blockquote), [Captcha](https://www.dokuwiki.org/plugin:captcha), [Discussion](https://www.dokuwiki.org/plugin:discussion), [Move](https://www.dokuwiki.org/plugin:move), [SearchIndex](https://www.dokuwiki.org/plugin:searchindex), [SiteMapNavi](https://www.dokuwiki.org/plugin:sitemapnavi), [Styling](https://www.dokuwiki.org/plugin:styling), [Tag](https://www.dokuwiki.org/plugin:tag), [TagAlerts](https://www.dokuwiki.org/plugin:tagalerts), [Translation](https://www.dokuwiki.org/plugin:translation), [Wrap](https://www.dokuwiki.org/plugin:wrap))
* [ ] Dark color scheme guidelines
* [ ] Topbar with date, newsticker (based on current namespace and sub content) and links
* [ ] Easy to customize glyphs(*) (from [Material Design Icons](https://materialdesignicons.com/) like other DW's SVG glyphs or [IcoMoon](https://icomoon.io/) for social links)
* [ ] Sidebar and ToC can be moved out of page content on wide screen (only works in boxed layout)
* [ ] Extracted ToC can be given [scrollspy](https://codepen.io/latifur/pen/qLKXpj) superpowers
* [x] Collapsible ToC (only showing first level untill hover)
* [ ] Retractable sidebar
* [x] Stickable main navigation bar, pageheader, sidebar and docinfo
* [x] Dynamic navigation button(s): wikihome, parent NS start, current NS home or "back to article" (can be combined as a single button or not)
* [ ] High number of HTML hooks (based on [this document](https://www.dokuwiki.org/include_hooks))
* [ ] A few HTML replace hooks that let you replace some elements with more fancy HTML code
* [x] Siblings pages list inside main navigation bar
* [x] Sub namespaces list inside main navigation bar or below content , depending on context and settings
* [ ] Social networks links (see [Social links](https://github.com/geekitude/dokuwiki-template-colormag#social-links) below)
* [ ] Supports a cheatsheet that will be shown as a sidebar in edit and preview modes
* [x] Added a "Go to bottom" pagetool to easily reach footer widgets or save settings button (Javascript is needed to switch between this pagetool and "Back to top")
* [x] Added contextual tools "facing" page tools (navigation, playground, syntax page, most usefull forms' buttons)
* [x] `docInfo` can be combined in page header or shown as a standalone block below page
* [x] Many settings to select color scheme used for page header, toc, side pane and footer
* [ ] Expanded debug mode to force some UI elements regardless of settings: add `&debug=1` to URL to show all debug elements at once or `&debug=keyword` to show a specific element from following list of keywords (usefull to play around with template settings)
  * [x] *a11y* (visual accessibility helpers)
  * [x] *alerts*
  * [x] *banner*
  * [x] *sidecard* (sidebar header image)
  * [x] *images* (all UI images)
  * [ ] *includes* (HTML include hooks)
  * [x] *mediaq* (add background color and text to mark CSS media queries)
  * [ ] *pattern*
  * [ ] *replace* (HTML replace hooks)
  * [ ] *social* (load a dummy social networks list)
  * [ ] *timers* (show alerts reporting time taken by a few functions, currently autotheme and colored breadcrumbs)
  * [x] *widebanner*
  * [ ] *widgets* (show dummy widgets set by `debug/footer.widgets.local.conf` and `debug/side.widgets.local.conf` file)
* [x] Force "Right to Left" or "Left to Right" mode by adding `&dir=rtl` or `&dir=ltr` to URL to show one ore the other (mostly no use outside of development)

(*) to replace a glyph by another, simply put desired SVG file (4kb max) in `conf/glyphs` folder (you will most likely need to create it) and name it after the target social network or after one of the following elements : acl.svg, config.svg, date.svg, discussion.svg, editor.svg, extentions.svg, externaleditor.svg, from-playground.svg, help.svg, hide.svg, home.svg, lastmod.svg, locked.svg, map.svg, namespace-start.svg, news.svg, pagepath.svg, parent-namespace.svg, playground.svg, popularity.svg, previous.svg, private-ns.svg, profile.svg, public-page.svg, recycle.svg, refresh.svg, revert.svg, save.svg, search.svg, show.svg, social.svg, styling.svg, translated.svg, translation.svg, upgrade.svg, usertools.svg, usermanager.svg (collapse, ellipsis, expand, menu-down and menu-right are too specific and cannot be customized). Site, user and page tools glyphs can't be customized as they come from DokuWiki core code.

:warning: POSSIBLE SVG NAMES LIST ABOVE NEEDS TO BE UPDATED :warning:

## Settings

* **glyphs** (*enabled*) : use glyph or text only actions (sitetools, usertools and some breadcrumbs)

## About

### Widgets

It is possible to change default set of widgets and order them as you like for any of the three widgets areas.

The three widgets areas are :
* topbar "right" section (will by default be configured to show links set through "topbar" wiki pages and will however fit only small content widgets like search or social links)
* sidepanel wich takes place of DokuWiki's regular sidebar and is by default configured to show sidecard (a namespace dependent image), searchbox and reagular sidebar
* footer widgets area that holds a user login/profile, an "about Namespaced", a license and finally a potential QRcode widgets

To change default widgets to your liking, simply copy any of the `dokuwiki/lib/tpl/namespaced/<topbar/side/footer>.widgets.local.conf` file(s) to `dokuwiki/conf` folder and adapt it/them to your needs to include your own set of widgets and order them as you like (sidebar should obviously never be removed).

:bulb: A widget can be any page from `wiki:` or current namespace (and it's parents) or any HTML file you created in `dokuwiki/lib/tpl/namespaced` folder, see configuration files for instructions.

#### Bundled widgets

Here's a list of all bundled widgets available :
* [x] about Namespaced (*namespaced.html*)
* [x] sidecard
* [x] search (*serach.html*, if not configured anywhere, a search form will be added to main navigation bar)
* [x] sidebar (*sidebar*)
* [ ] links (will fit in topbar if the list of links is limited)
* [ ] user login/profile
* [ ] license
* [ ] social media links
* [ ] QRCode to current page that shows up when printing page (requires `QRCode2` plugin)

#### Want more widgets ?

You can add your own widgets based on html files or on wiki pages (from current namespace and parents or from `wiki:` namespace).

Widgets based on HTML files work just like [HTML hooks](https://github.com/geekitude/dokuwiki-template-colormag#include-hooks and you can get started with `dokuwiki/lib/tpl/colormag/debug/samplewidget.html` file as an example).

The main advantage of widgets over classic sidebar is that Dokuwiki's cache is not involved (you don't need to remember to add `~~NOCACHE~~`. The second advantage is that splitting content between sidebar and widgets can make things aesthically less bulky.

The drawback of widgets against sidebar is that they do not depend on current namespace (except if based on Dokuwiki syntax that .

:memo: Widgets' file names must not contain any space.

#### Localize widgets titles

If you want to change a widget title, you will have to create a *txt* file in `dokuwiki/conf/template_lang/namespaced/<language_ISO>` named after the widget title to customize and containing the desired translation.

As an exemple, here is the line added to `dokuwiki/conf/side.widgets.local.conf` to add "My Widget" :
```my_widget.html         My Widget```
The file used to localize the title in french is `dokuwiki/conf/template_lang/namespaced/fr/My Widget.txt` and here is it's content :
```Mon widget```

### HTML hooks

Namespaced can be customized using HTML files that will be displayed at one of the many available include or replace hooks. Include hooks add some content while replace hooks take place of standard content.
To get started, copy the correspondig HTML file from `dokuwiki/lib/tpl/namespaced/debug` folder to `dokuwiki/lib/tpl/namespaced` folder and change it to your liking (don't forget to remove existing `*-hook-sample` class).

You can add `noprint` class to avoid the content to be printed.

See [DokuWiki's documentation](https://www.dokuwiki.org/include_hooks) for more details about include hooks.

#### Include hooks

### jQuery

:warning: UPDATE LIST :warning:

Here's the list of features that will not work on browsers without jQuery abilities :
* Stack (and switch between) "Back to top" and "Go to bottom" pagetools
* Newsticker
* Context logo Lightbox effect
* Sidebar visibility context tool
* Sidebar and TOC auto-collapsing when reaching tablet resolution
* ToC extraction in "mix" layout
* Scrollspy ToC
* Internal links will scroll a bit too far if Page header is set to stick on top of page
* Animated scrolling
