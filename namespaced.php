<?php
/**
 * Dokuwiki Namespaced template
 *
 * @link    https://www.dokuwiki.org/template:namespaced
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 * 
 * This file provides template specific custom functions that are
 * not provided by the DokuWiki core.
 * It is common practice to start each function with an underscore
 * to make sure it won't interfere with future core functions.
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();

/**
 * INITALIZE
 * 
 * Load usefull informations and plugins' helpers.
 */
function namespaced_init() {
    global $ID, $conf, $JSINFO;
    global $namespaced;

    // Enable default navbar search untill it's proven useless
    $namespaced['defaultsearch'] = true;

    // Use `a11y` class or not
    if (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) {
        $namespaced['a11y']['extraclass'] = '';
        $namespaced['a11y']['standalone'] = '';
    } else {
        $namespaced['a11y']['extraclass'] = ' a11y';
        $namespaced['a11y']['standalone'] = ' class="a11y"';
    }

    // UI IMAGES
// need to search avatar at some point
    $images= array('banner', 'pattern', 'cover', 'widebanner');
    foreach ($images as $type) {
//dbg($type);
//dbg(tpl_getConf($type));
//dbg($showSidebar);
        if (tpl_getConf($type) != null) {
            $namespaced['images'][$type] = namespaced_inherit(tpl_getConf($type), "media", $ID);
        }
    }
//dbg($namespaced['images']);

    // GLYPHS
    // Search for default or custum default SVG glyphs
    $namespaced['glyphs']['account-edit'] = null;
    $namespaced['glyphs']['acl'] = null;
    $namespaced['glyphs']['bottom'] = null;
    $namespaced['glyphs']['config'] = null;
    $namespaced['glyphs']['editor'] = null;
    $namespaced['glyphs']['extension'] = null;
    $namespaced['glyphs']['extedit'] = null;
    $namespaced['glyphs']['github'] = null;
    $namespaced['glyphs']['home'] = null;
    $namespaced['glyphs']['info'] = null;
    $namespaced['glyphs']['lastmod'] = null;
    $namespaced['glyphs']['locked'] = null;
    $namespaced['glyphs']['nshome'] = null;
    $namespaced['glyphs']['pagepath'] = null;
    $namespaced['glyphs']['pagerefresh'] = null;
    $namespaced['glyphs']['parentns'] = null;
    $namespaced['glyphs']['playground'] = null;
    $namespaced['glyphs']['popularity'] = null;
    $namespaced['glyphs']['preview'] = null;
    $namespaced['glyphs']['recycle'] = null;
    $namespaced['glyphs']['reset'] = null;
    $namespaced['glyphs']['revert'] = null;
    $namespaced['glyphs']['save'] = null;
    $namespaced['glyphs']['search'] = null;
    $namespaced['glyphs']['searchindex'] = null;
    $namespaced['glyphs']['searchstats'] = null;
    $namespaced['glyphs']['styling'] = null;
    $namespaced['glyphs']['syntax'] = null;
    $namespaced['glyphs']['translation'] = null;
    $namespaced['glyphs']['upgrade'] = null;
    $namespaced['glyphs']['usermanager'] = null;
    foreach ($namespaced['glyphs'] as $key => $value) {
        if (is_file(DOKU_CONF."tpl/namespaced/".$key.".svg")) {
            $namespaced['glyphs'][$key] = DOKU_CONF."tpl/namespaced/".$key.".svg";
        } elseif (is_file(".".tpl_basedir()."images/glyphs/".$key.".svg")) {
            $namespaced['glyphs'][$key] = ".".tpl_basedir()."images/glyphs/".$key.".svg";
        } else {
            $namespaced['glyphs'][$key] = DOKU_INC.'lib/images/menu/00-default_checkbox-blank-circle-outline.svg';
        }
    }
//dbg($namespaced['glyphs']);

    // SEARCH SETTINGS
    $namespaced['search'] = array(
        "quicksearch" => (strpos(tpl_getConf('searches'), 'quicksearch') !== false), 
        "autocomplete" => (strpos(tpl_getConf('searches'), 'autocomplete') !== false)
    );
//dbg($namespaced['search']);

    // GET WIDGETS
    $widgets= array('footer','side');
    foreach ($widgets as $area) {
        $namespaced['widgets'][$area] = array();
        // Load widgets lists from `DOKU_CONF/$area.widgets.local.conf`
        if (@file_exists(DOKU_CONF.$area.'.widgets.local.conf')) {
            $widgetsFile = DOKU_CONF.$area.'.widgets.local.conf';
        // or from `dokuwiki/lib/tpl/namespaced`
        } else {
            $widgetsFile = tpl_incdir().$area.'.widgets.local.conf';
        }
//dbg($widgetsFile);

        // Read file content
        $namespaced['widgets'][$area] = confToHash($widgetsFile);
//dbg($namespaced['widgets'][$area]);
        if (is_array($namespaced['widgets'][$area])) {
            if ($area == "side") {
                $namespaced['widgets'][$area] += [ "sidebar" => "" ];
//dbg($namespaced['widgets'][$area]);
            }
            if ($area == "footer") {
                $namespaced['widgets'][$area] += [ "license.html" => "" ];
                $namespaced['widgets'][$area]['license.html'] = tpl_getLang('license');
//dbg($namespaced['widgets'][$area]);
            }
            if (count($namespaced['widgets'][$area]) > 0) {
                foreach ($namespaced['widgets'][$area] as $widget => $title) {
                    // Disable default search if there's a search widget
                    if ($widget == "search.html") {
                        $namespaced['defaultsearch'] = false;
                    }
                    if (strpos($widget, ".") !== false) {
                        $propagate = 0;
                    } else {
                        $propagate = 1;
                    }
                    if (substr($widget, 0, 1) === ':') {
                        $type = "media";
//dbg(ltrim($widget, ":"));
                        if (isset($namespaced['images'][ltrim($widget, ":")])) {
//dbg("bingo");
                            $target = $namespaced['images'][ltrim($widget, ":")];
                        } else {
                            $target = namespaced_inherit($widget, $type, $ID, true, $propagate);
                        }
//dbg($media);
                    } elseif (strpos($widget, ".html") !== false) {
                        $type = "include";
                        if (file_exists(tpl_incdir().$widget)) {
                            $target = 1;
                        }
                    } elseif (page_exists($widget)) {
                        $type = "page";
                        $target = $widget;
                    } else {
                        $type = "page";
                        $target = page_findnearest($widget);
                    }

                    if ($target != null) {
                        $namespaced['widgets'][$area][$widget] = array();
                        //if (($title != "cover") and ($title != "Search") and ($title != "Sidebar") and ($title != "User")) {
                        if ($title != null) {
                            $locale = DOKU_CONF.'template_lang/'.$conf['template'].'/'.$conf['lang'].'/'.$title.'.txt';
//dbg($locale);
                            if (file_exists($locale)) {
                                $title = io_readFile($locale);
                            }
                            $namespaced['widgets'][$area][$widget]['title'] = $title;
                        }
                        $namespaced['widgets'][$area][$widget]['type'] = $type;
                        $namespaced['widgets'][$area][$widget]['target'] = $target;
                    } else {
                        unset($namespaced['widgets'][$area][$widget]);
                    }
                }
            }
        }
    }
//dbg($namespaced['widgets']);

    // HELPER PLUGINS
    // Preparing usefull plugins' helpers
    // Translation
//dbg("start: ".$conf['start']);
    $namespaced['translation'] = array();
    $namespaced['translation']['istranslated'] = false;
//dbg("untranslatedhome: ".$namespaced['translation']['untranslatedhome']);
    if (!plugin_isdisabled('translation')) {
        $namespaced['translation']['helper'] = plugin_load('helper','translation');
        $namespaced['translation']['parts'] = $namespaced['translation']['helper']->getTransParts($ID);
//dbg($namespaced['translation']['parts']);
//dbg($namespaced['translation']['parts'][1]);
//dbg("translations: ".$conf['plugin']['translation']['translations']);
//dbg($conf['lang']);
//dbg($conf['plugin']['translation']['translations']);
//dbg($namespaced['translation']['default_lang']);
//dbg($namespaced['translation']['helper']->defaultlang);
        if (strpos($conf['plugin']['translation']['translations'], $namespaced['translation']['helper']->defaultlang) !== false) {
            $namespaced['translation']['untranslatedhome'] = $namespaced['translation']['helper']->defaultlang.":".$conf['start'];
        }
//dbg("untranslatedhome: ".$namespaced['translation']['untranslatedhome']);
//dbg("before: ".$namespaced['translation']['default_lang']);
        if ($namespaced['translation']['parts'][0] != $namespaced['translation']['helper']->defaultlang) {
            $namespaced['translation']['istranslated'] = true;
        }
//dbg("translated: ".$namespaced['translation']['istranslated']);
        //}
    }
//dbg($namespaced['translation']['ishome']);
//dbg($namespaced['translation']);

    // IS HOME ?
    $namespaced['ishome'] = namespaced_ishome($ID);
//dbg($namespaced['ishome']);

    // CURRENT NAMESPACE INDEX
    $namespace = cleanID(getNS($ID));
    $namespaced['nsindex'] = array();
    $namespaced['nsindex']['pages'] = array();
    $namespaced['nsindex']['subns'] = array();
//dbg($namespace);
    $dir  = utf8_encodeFN(str_replace(':','/',$namespace));
    $data = array();
    // Get namespace content
    search($data,$conf['datadir'],'search_index',array('ns' => $namespace),$dir);
//dbg($data);
    // Known plugins that set title and corresponding metadata keys
    $title_metafields = array(
        'croissant' => 'plugin_croissant_bctitle',
        'pagetitle' => 'shorttitle',
    );
    foreach (array_keys($title_metafields) as $plugin) {
        if(plugin_isdisabled($plugin)) unset($title_metafields[$plugin]);
    }
    $title_metafields['dokuwiki'] = 'title';
//dbg(tpl_getConf('nsindexexclude'));
    if (count($data) > 0) {
        foreach ($data as $datakey => $item) {
            $title = null;
            // Unset item if is in 'exclusions'
            if (in_array(noNS($item['id']), tpl_getConf('nsindexexclude'))) {
                unset($data[$datakey]);
                continue;
            // Always unset item if it starts with "playground" or is equal to current $ID
            } elseif ((explode(":", $item['id'])[0] == "playground") or ($item['id'] == $ID)) {
                unset($data[$datakey]);
                continue;
            }
            // If item is a directory, we need an ID that points to that namespace's start page (even if it doesn't exist) and maybe check for an image
            if ($data[$datakey]['type'] == "d") {
                $data[$datakey]['id'] = $data[$datakey]['id'].':'.$conf['start'];
                $class = "is_ns";
                if ((tpl_getConf("subnsaltidx") != "never") and (tpl_getConf("subnsaltidximage") != "none")) {
//dbg(tpl_getConf("startsubindeximage"));
//dbg(tpl_getConf(tpl_getConf("startsubindeximage")));
//dbg($data[$datakey]['id']);
//dbg($namespaced['ishome']);
                    if ((tpl_getConf('subnsaltidximage') == "banner") or ((tpl_getConf('subnsaltidximage') == "mix") and (in_array($namespaced['ishome'], array("default", "untranslated", "translated"))))) {
                        $data[$datakey]['image'] = namespaced_inherit("banner", "media", $data[$datakey]['id'], true, false);
//                    } elseif (tpl_getConf('subnsaltidximage') == "cover") {
                    } else {
                        $data[$datakey]['image'] = namespaced_inherit("cover", "media", $data[$datakey]['id'], true, false);
                    }
                }
            } else {
                $class = "is_page";
            }
            // Get item title from metadata..
//            if ($conf['useheading']) {
                foreach ($title_metafields as $plugin => $pluginkey) {
                    $title = p_get_metadata($data[$datakey]['id'], $pluginkey, METADATA_DONT_RENDER);
                    if ($title != null) break;
                }
//            }
            // ...or use ID...
            // Complete ID for namespaces (otherwise we'll simply get "start"...
            if ($data[$datakey]['type'] == "d") {
                $title = @$title ?: hsc($data[$datakey]['id']);
            // ...or page ID without NS (makes more sense and saves space in site navbar)
            } else {
                $title = @$title ?: hsc(noNS($data[$datakey]['id']));
            }
//dbg($title);
            // Store item core title
            $data[$datakey]['title'] = $title;
            // Adding relevant glyph to local title
            if ($data[$datakey]['id'] == $namespace.':'.$conf['start']) {
                $title = namespaced_glyph('nshome', true).$title;
            }
            // Store a link to item
            $data[$datakey]['link'] = '<a href="'.wl($data[$datakey]['id']).'" class="'.$class.'" title="'.$data[$datakey]['id'].'">'.$title.'</a>';
            // Store item in relevant array
            if ($item['type'] == 'd') {
                $namespaced['nsindex']['subns'][] = $data[$datakey];
            } else {
                $namespaced['nsindex']['pages'][] = $data[$datakey];
            }
//dbg($data[$datakey]);
        }
        // Move start page to first place
        if (count($namespaced['nsindex']['pages']) > 0) {
            foreach ($namespaced['nsindex']['pages'] as $datakey => $item) {
                if (end(explode(":", $item['id'])) == $conf['start']) {
                    $home = $item;
                    unset($namespaced['nsindex']['pages'][$datakey]);
                    array_unshift($namespaced['nsindex']['pages'], $home);
                }
            }
        }
    }
//dbg($namespaced['nsindex']);

    // NAMESPACE THEME
    // Read customized 'style.ini' file generated by Styling plugin
    if (is_file(DOKU_CONF."tpl/namespaced/style.ini")) {
        $styleini = parse_ini_file(DOKU_CONF."tpl/namespaced/style.ini", true);
    // Or load template's default 'style.ini'
    } else {
    //if (is_file(tpl_incdir()."style.ini")) {
        $styleini = parse_ini_file (tpl_incdir()."style.ini", true);
    }
//dbg(tpl_incdir().'style.ini');
//dbg($styleini);
//dbg($styleini['replacements']['__theme_color__']);
    $namespaced['initial_theme_color'] = $styleini['replacements']['__theme_color__'];
//dbg($namespaced['initial_theme_color']);
    // Look for a "nstheme" page
    //$themelFile = page_findnearest("links", true);
    //$nsStyleIni = namespaced_file("style", "inherit", "conf", $namespaced['baseNs']);
    //$themeinifile = "./data/pages/test/test/theme.ini";
    $themeinifile = namespaced_inherit("theme.ini", "conf", $ID);
//dbg($themeinifile);
    if (is_file($themeinifile['src'])) {
        $themeini = parse_ini_file($themeinifile['src'], true);
//dbg($themeini);
        foreach ($themeini['replacements'] as $key => $value) {
            if ($value) {
                $styleini['replacements'][$key] = $value;
            }
        }
    }
//dbg($styleini['replacements']);
    $css = io_readFile(tpl_incdir()."/css/namespaced-theme.min.less");
//dbg(tpl_incdir()."/css/namespaced.less");
//dbg($css);
    // Replace CSS' placeholders by their respective value (or LESS formula)
    $css = namespaced_css_applystyle($css, $styleini['replacements']);
//dbg($css);
    $less = new lessc();
    $namespaced['theme'] = $less->compile($css);

    // JSINFO
    // Note if Navbar and/or Pagenav are sticking to top
    if (strpos(tpl_getConf('stickies'), 'navbar') !== false) {
        $JSINFO['StickyNavbar'] = true;
    } else {
        $JSINFO['StickyNavbar'] = false;
    }
    if (strpos(tpl_getConf('stickies'), 'pagenav') !== false) {
        $JSINFO['StickyPagenav'] = true;
    } else {
        $JSINFO['StickyPagenav'] = false;
    }
    // Add a value for connected user (false if none, true otherwise)
    //if (empty($_SERVER['REMOTE_USER'])) {
    //    $JSINFO['user'] = false;
    //} else {
    //    $JSINFO['user'] = true;
    //}
    // Store options into $JSINFO for later use
    //if (strpos(tpl_getConf('topbar'), 'newsticker') !== false) {
    //    $JSINFO['LoadNewsTicker'] = true;
    //} else {
    //    $JSINFO['LoadNewsTicker'] = false;
    //}
    //if (tpl_getConf('scrollspyToC')) {
    //    $JSINFO['LoadGumshoe'] = true;
    //} else {
    //    $JSINFO['LoadGumshoe'] = false;
    //}
    //$JSINFO['Animate'] = tpl_getConf('animate');
//$JSINFO['ScrollspyToc'] = tpl_getConf('scrollspyToc');
//dbg($JSINFO);

    // Adding test alerts if debug is enabled
    if (($_GET['debug'] == 1) or ($_GET['debug'] == "alerts")) {
        msg("This is an error [-1] alert with a <a href='#'>dummy link</a>", -1);
        msg("This is an info [0] message with a <a href='#'>dummy link</a>", 0);
        msg("This is a success [1] message with a <a href='#'>dummy link</a>", 1);
        msg("This is a notification [2] with a <a href='#'>dummy link</a>", 2);
    }
}/* /namespaced_init */

/**
 * Find a media in the current namespace (determined from $ID) or any
 * higher namespace that can be accessed by the current user,
 * this condition can be overriden by an optional parameter.
 *
 * Based on core page_findnearest()
 *
 * @param  string $target the media name we're looking for
 * @param bool $useacl only return media if start page in same ns is readable by the current user, false to ignore ACLs
 * @return false|string the found media id, false if none
 */
function namespaced_inherit($target, $type = "media", $origin, $useacl = false, $propagate = true){
    //if ((string) $target === '') return false;
    global $conf;
    $target = ltrim($target, ":");

//dbg($target);
    $ns = $origin;
    $result = array();
    $glob = array();
    $file = null;
    // In case we are in a farm, we have to make sure we search in animal's data dir by starting at DOKU_CONF directory (will however work if not in a farm)
    if ($type == "media") {
        $base = DOKU_CONF.'../'.$conf['savedir'].'/media/';
    } else {
        $base = DOKU_CONF.'tpl/namespaced/';
    }
//dbg($base);
    do {
        $ns = getNS($ns);
        $result['ns'] = cleanID($ns).":".$conf['start'];
//dbg($ns);
//dbg($path);
//dbg($result['id']);
//dbg($path.'/'.$target);
        if (($type == "media") and (!$useacl or auth_quickaclcheck($result['ns']) >= AUTH_READ)){
            $path = $base.str_replace(":", "/", $ns);
            $glob = glob($path.'/'.$target.'.{jpg,gif,png}', GLOB_BRACE);
        } elseif (($type == "conf") and (!$useacl or auth_quickaclcheck($result['ns']) >= AUTH_READ)){
            $path = $base.str_replace(":", "/", $ns);
//dbg($path);
            $glob = glob($path.'/'.$target);
        }
//dbg($glob);

    } while((($ns !== false) and (empty($glob))) and ($propagate == true));
    //} while($ns !== false);

    if (($type == "media") and (count($glob) == 0)) {
        $result['ns'] = cleanID("wiki:".$conf['start']);
        $glob = glob(DOKU_CONF.'../'.$conf['savedir'].'/media/wiki/'.$target.'.{jpg,gif,png}', GLOB_BRACE);
    }
//dbg($result);

    $src = null;
    if (($type == "media") and (($_GET['debug'] == 1) or ($_GET['debug'] == "images") or ($_GET['debug'] == $target))) {
        $src = tpl_incdir().'debug/'.$target.'.png';
        $result['src'] = '/lib/tpl/namespaced/debug/'.$target.'.png';
        $result['ns'] = null;
    } elseif (isset($glob[0])) {
        $src = $glob[0];
        if ($type == "media") {
            $result['path'] = $src;
            $result['src'] = '/lib/exe/fetch.php?media='.str_replace("/", ":", explode("media/", $src)[1]);
        } elseif ($type == "conf") {
            $result['src'] = $src;
//dbg($result);
        }
    }

    if ($src != null) {
        if ($type == "media") {
            $result['size'] = getimagesize($src);
        }
        return $result;
    } else {
        return false;
    }
}/* /namespaced_inherit */


/**
 * Copied from lib/exe/css.php to avoid calling core CSS.php file
 * Otherwise, using this code (from dw2pdf plugin) :
 * //reusue the CSS dispatcher functions without triggering the main function
 * define('SIMPLE_TEST', 1);
 * require_once(DOKU_INC . 'lib/exe/css.php');
 * Creates `possible CSRF attack` alerts when saving wiki pages
 *
 * Does placeholder replacements in the style according to
 * the ones defined in a templates style.ini file
 *
 * This also adds the ini defined placeholders as less variables
 * (sans the surrounding __ and with a ini_ prefix)
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 *
 * @param string $css
 * @param array $replacements  array(placeholder => value)
 * @return string
 */
function namespaced_css_applystyle($css, $replacements) {
    // we convert ini replacements to LESS variable names
    // and build a list of variable: value; pairs
    $less = '';
    foreach((array) $replacements as $key => $value) {
        $lkey = trim($key, '_');
        $lkey = '@ini_'.$lkey;
        $less .= "$lkey: $value;\n";

        $replacements[$key] = $lkey;
    }

    // we now replace all old ini replacements with LESS variables
    $css = strtr($css, $replacements);

    // now prepend the list of LESS variables as the very first thing
    $css = $less.$css;
    return $css;
}/* /namespaced_css_applystyle */

/**
 * Tell if given page is home (default, translated or untranslated) or not
 *
 * @param string $page
 * @return string or false
 */
function namespaced_ishome($page) {
    global $conf;
    global $namespaced;

//dbg($namespaced['translation']['untranslatedhome']);
//dbg($page);
//dbg($conf['start']);
//dbg(strpos($page, $conf['start']));
    // Default or untranslated wiki home ?
    if ($page == $conf['start']) {
        $ishome = "default";
    } elseif ($page == $namespaced['translation']['untranslatedhome']) {
        $ishome = "untranslated";
    } elseif (strpos($page, $conf['start']) !== false) {
//dbg("pas là?");
        $ishome = "ns";
        if ($namespaced['translation']['helper']) {
            $parts = $namespaced['translation']['helper']->getTransParts($page);
//dbg("here!");
            if (($parts[1] == $conf['start']) and (($parts[0] != "") and (strpos($conf['plugin']['translation']['translations'], $parts[0]) !== false))) {
                $ishome = "translated";
            }
        }
    } else {
        $ishome = false;
    }
//dbg($ishome);
    return $ishome;
}/* /namespaced_ishome */

/**
 * Returns body classes according to settings
 */
function namespaced_bodyclasses() {
    global $ID, $conf;
    global $namespaced;

    $classes = array();

    if (($_GET['debug'] == 1) or ($_GET['debug'] == 'images') or ($_GET['debug'] == 'pattern')) {
        $pattern = "dbg-pattern";
    } elseif (isset($namespaced['images']['pattern']['ns'])) {
        $pattern = "pattern";
    } else {
        $pattern = null;
    }

    if ((isset($namespaced['ishome'])) and ($namespaced['ishome'] != null)) {
        $home = $namespaced['ishome']."-home";
    } else {
        $home = null;
    }

    if ((tpl_getConf('forcesidepanel')) and (count($namespaced['widgets']['side']) > 0)) {
        $sidepanel = null;
    } elseif (($home != null) and ($namespaced['widgets']['side']['sidebar'] == null)) {
        $sidepanel = "no-sidepanel";
    } elseif ($namespaced['widgets']['side'] != null) {
        if (strpos(tpl_getConf('flexflip'), 'sidepanel') !== false) {
            $sidepanel = "sidepanel-flip";
        } else {
            $sidepanel = null;
        }
    }

    $footerwidgets = count($namespaced['widgets']['footer']);
    if ($footerwidgets == 3) {
        $footerwidgets = "three-footerwidgets";
    } elseif ($footerwidgets > 3) {
        $footerwidgets = "more-footerwidgets";
    } else {
        $footerwidgets = null;
    }

//    array_push($classes, $home, $sidepanel, $pattern, $showSidebar ? ((strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'right-sidebar' : 'left-sidebar') : 'no-sidebar', tpl_getConf('layout').'-layout', (strpos(tpl_getConf('flexflip'), 'banner') !== false) ? 'banner-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagenav') !== false) ? 'pagenav-flip' : '', (strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'sidebar-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagetools') !== false) ? 'pagetools-flip' : '', (strpos(tpl_getConf('flexflip'), 'socket') !== false) ? 'socket-flip' : '', tpl_getConf('widgetslook').'-widgets', (strpos(tpl_getConf('print'), 'hrefs') !== false) ? 'printhrefs' : '', ($_GET['debug']==1) ? 'debug' : '', ($_GET['debug']=='mediaq') ? 'mediaq' : '');

// VOIR SI IL FAUT REINTEGRER `widgetlooks` et/ou `printhrefs`
    array_push($classes, $home, $sidepanel, $footerwidgets, $pattern, $showSidebar ? ((strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'right-sidebar' : 'left-sidebar') : 'no-sidebar', tpl_getConf('layout').'-layout', (strpos(tpl_getConf('flexflip'), 'banner') !== false) ? 'banner-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagenav') !== false) ? 'pagenav-flip' : '', (strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'sidebar-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagetools') !== false) ? 'pagetools-flip' : '', (strpos(tpl_getConf('flexflip'), 'socket') !== false) ? 'socket-flip' : '', tpl_getConf('tocstyle').'-toc', (strpos(tpl_getConf('neutralize'), 'toc') !== false) ? 'neu-toc' : '', (tpl_getConf('collapsible-toc') == 1) ? 'collapsible-toc' : '', tpl_getConf('tablestyle').'-tables', (tpl_getConf('kbdstyle') != 'default') ? tpl_getConf('kbdstyle').'-kbd' : '', ($_GET['debug']==1) ? 'debug' : '', ($_GET['debug']=='mediaq') ? 'mediaq' : '');

    return rtrim(join(' ', array_filter($classes)));
}/* /namespaced_bodyclasses */

/**
 * RETURN A DATE
 * 
 * @param string    $type "long" for long date based on 'dateString' setting, "short" for numeric
 * @param integer   $timestamp timestamp to use (null for current server time)
 * @param bool      $clock if true, add hour to the result
 * @param bool      $print if true, print the result instead of returning it
 */
function namespaced_date($type = "long", $timestamp = null, $clock = false, $return = false) {
    global $conf;
    $datelocale = tpl_getConf('datelocale');
    if ($datelocale != null) {
        if (strpos($datelocale, ',') !== false) {
            $datelocale = explode(",", $datelocale)[1];
        }
        setlocale(LC_TIME, $datelocale);
    }
    if ($type == "short") {
        $format = tpl_getConf('shortdatestring');
    } else {
        $format = tpl_getConf('longdatestring');
    }
    if ($clock) {
        $format .= ' %H:%M';
    }
    if ($timestamp == null) {
        $result = utf8_encode(ucwords(strftime($format)));
    } else {
        $result = utf8_encode(ucwords(strftime($format, $timestamp)));
    }
    if ($return) {
        return $result;
    } else {
        print $result;
        return 1;
    }
}/* /namespaced_date */

/**
 * Print custom search form butoon
 *
 * Note: original button is hidden through CSS
 *
 */
function namespaced_searchbutton() {
    global $namespaced;
    global $lang;

    echo '<button id="namespaced__search_button" type="submit" form="dw__search" value="'.$lang['btn_search'].'" title="'.$lang['btn_search'].' [F]">'.inlineSVG($namespaced['glyphs']['search']).'</button>';

    return true;
}/* /namespaced_searchbutton */

/**
 * Print a given set of widgets.
 *
 * @param  string $area (the group of widgets listed in $namespaced['widgets'][$area])
 */
function namespaced_widgets($area = null){
    //if ((string) $target === '') return false;
    global $namespaced, $conf;

    if(!$area) return false;
//dbg($area);
//dbg($namespaced['widgets'][$area]);
    foreach ($namespaced['widgets'][$area] as $widget => $data) {
//dbg($widget);
//dbg($data);
//dbg($data['target']);
        $widgetid = "namespaced__widget_".str_replace(".html", "", str_replace(":", "_", ltrim($widget, ":")));
        if (($widgetid == "namespaced__widget_user") and (($conf['useacl']) && (empty($_SERVER['REMOTE_USER'])))) {
            continue;
        }
        $classes = "widget ";
        // Make sure footer and it's widgets are not set to "transparent" style together
        if (($area == "footer") and (tpl_getConf("footerwidgetstyle") == "transparent") and (tpl_getConf("footerstyle") == "sitebg")) {
            $classes .= "labeled";
        } else {
            $classes .= tpl_getConf($area."widgetstyle");
        }
        if (strpos(tpl_getConf('neutralize'), $area.'-widgets') !== false) {
            $classes .= " neu";
        }
        if (isset($data['title'])) {
            $classes .= " hastitle";
        }
        print '<aside id="'.$widgetid.'" class="'.$classes.'">';
            if (isset($data['title'])) {
                print '<h6 class="widget-title"><span>'.$data['title'].'</span></h6>';
            }
            //print $data['target'];
            if ($data['type'] == "media") {
                print '<img src="'.$data['target']['src'].'" alt="*'.$data['target']['title'].'*" '.$data['target']['size'][3].' class="mediacenter '.ltrim($widget, ":").'" />';
            } elseif ($data['type'] == "include") {
                tpl_includeFile($widget);
            } else {
                if ($widget == "sidebar") {
                    tpl_include_page($data['target'], true, false, true);
                } else {
//dbg(io_readWikiPage(namespaced_pagepath($data['target']),$data['target'],false));
                    print p_render('xhtml',p_get_instructions(io_readWikiPage(namespaced_pagepath($data['target']),$data['target'],false)),$info);
                }
            }
//dbg($data);
        print '</aside>';
    }
}/* /namespaced_widgets */

/**
 * Returns the full path to the page specified by ID
 * Base on core wikiFN() without caching or revisions
 * The filename is URL encoded to protect Unicode chars
 *
 * @param  $raw_id  string   id of wikipage
 * @param  $clean   bool     flag indicating that $raw_id should be cleaned.  Only set to false
 *                           when $id is guaranteed to have been cleaned already.
 * @return string full path
 */
function namespaced_pagepath($id){
    global $conf;

    $id = cleanID($id);
    $id = str_replace(':','/',$id);

    $fn = $conf['datadir'].'/'.utf8_encodeFN($id).'.txt';

    return $fn;
}/* /namespaced_pagepath */

/**
 * Userwidget
 */
//function namespaced_userwidget($context = "null") {
function namespaced_userwidget() {
    global $lang, $conf, $ID, $INPUT, $INFO;

        print '<h6 class="widget-title"><span>';
            print $lang['profile'];
        print '</span></h6>';
        if ($namespaced['images']['avatar']['target'] != null) {
            if (strpos($namespaced['images']['avatar']['target'], "debug") !== false) {
                print '<a href="/doku.php?id='.$ID.'&amp;do=media&amp;ns='.tpl_getConf('avatars').'&amp;tab_files=upload" title="'.tpl_getLang('upload_avatar').'"><img id="namespaced__user-avatar" src="'.$namespaced['images']['avatar']['target'].'" title="'.tpl_getLang('upload_avatar').'" alt="*'.tpl_getLang('upload_avatar').'*" width="64px" height="100%" /></a>';
            } else {
                if ($namespaced['images']['avatar']['thumbnail'] != null) {
                    print '<a href="'.$namespaced['images']['avatar']['target'].'" data-lity data-lity-desc="'.tpl_getLang('your_avatar').'" title="'.tpl_getLang('your_avatar').'"><img id="namespaced__user-avatar" src="'.$namespaced['images']['avatar']['thumbnail'].'" title="'.tpl_getLang('your_avatar').'" alt="*'.tpl_getLang('your_avatar').'*" width="64px" height="100%" /></a>';
                } else {
                    print '<a href="'.$namespaced['images']['avatar']['target'].'" data-lity data-lity-desc="'.tpl_getLang('your_avatar').'" title="'.tpl_getLang('your_avatar').'"><img id="namespaced__user-avatar" src="'.$namespaced['images']['avatar']['target'].'" title="'.tpl_getLang('your_avatar').'" alt="*'.tpl_getLang('your_avatar').'*" width="64px" height="100%" /></a>';
                }
            }
        }
        print '<ul>';
//dbg($INFO['userinfo']);
            print '<li>'.$lang['fullname'].' : <em>'.$INFO['userinfo']['name'].'</em></li>'; 
            print '<li>'.$lang['user'].' : <em>'.$_SERVER['REMOTE_USER'].'</em></li>'; 
            print '<li>'.$lang['email'].' : <em>'.$INFO['userinfo']['mail'].'</em></li>'; 
        print '</ul>';
        echo '<p class="user">';
            // If user has public page ID but no private space ID (most likely because UserHomePage plugin is not available)
            if (($namespaced['user']['public']['id'] != null) && ($namespaced['user']['private']['id'] != null)) {
dbg("vérifier ces liens");
                tpl_link(wl($namespaced['user']['private']['id']),'<span>'.$namespaced['user']['private']['title'].'</span>','title="'.$namespaced['user']['private']['title'].'" class="'.$namespaced['user']['private']['classes'].'"');
                print " - ";
                tpl_link(wl($namespaced['user']['public']['id']),'<span>'.$namespaced['user']['public']['title'].'</span>','title="'.$namespaced['user']['public']['title'].'" class="'.$namespaced['user']['public']['classes'].'"');
            } elseif (($namespaced['user']['public']['id'] != null) && ($namespaced['user']['private'] == null)) {
                print '<span title="'.$namespaced['user']['public']['title'].'">'.$namespaced['user']['public']['string'].'</span>';
            // If user has both public page ID and private space ID
            // In any other case, use DW's default function
            //} else {
            //    print $lang['loggedinas'].' '.userlink(); /* 'Logged in as ...' */
            }
        echo '</p>';
        echo '<p class="profile">';
            print '<a href="/doku.php?id='.$ID.'&amp;do=profile" rel="nofollow" title="'.$lang['btn_profile'].'"><span>'.$lang['btn_profile'].'</span></a>';
        echo '</p>';
}/* /namespaced_userwidget */


/**
 * Print UI images as simple <img> or <a> elements
 */
function namespaced_ui_image($type) {
    global $conf, $ID;
    global $namespaced;

    if (($namespaced['images'][$type]['src'] != null) and ($ACT != "edit") and ($ACT != "preview")) {
        $title = null;
        if ((tpl_getConf('uiimagetarget') == 'home') or (strpos($namespaced['images'][$type]['ns'], 'wiki') !== false)) {
            $target = wl($conf['start']);
            $title = tpl_getLang('wikihome');
        } elseif (tpl_getConf('uiimagetarget') == 'image-ns') {
            $target = wl($namespaced['images'][$type]['ns']);
            $title = $namespaced['images'][$type]['ns'];
        } elseif (tpl_getConf('uiimagetarget') == 'current-ns') {
            $target = wl(getNS($ID).":".$conf['start']);
            $title = getNS($ID).":".$conf['start'];
        } elseif (tpl_getConf('uiimagetarget') == 'image-details') {
            $target = "lib/exe/detail.php?id=".$ID."&".explode("php?", $namespaced['images'][$type]['src'])[1];
            $title = explode("php?", $namespaced['images']['banner']['src'])[1];
        } else {
            $target = null;
        }
        if ($title == null) { $title = $target; }
        if (($namespaced['images'][$type]['ns'] != null) and ($target != null)) {
            if ($type != 'widebanner') {
                $style = ' style="max-width:'.$namespaced['images'][$type]['size'][0].'px"';
            }
            tpl_link(
                $target,
                '<img src="'.$namespaced['images'][$type]['src'].'" title="'.$title.'" class="'.$type.'" alt="*'.$type.'*" '.$namespaced['images'][$type]['size'][3].$style.'/>'
            );
        } else {
            print '<img src="'.$namespaced['images'][$type]['src'].'" class="'.$type.'" alt="*'.$title.'*" '.$namespaced['images'][$type]['size'][3].' class="mediacenter" />';
        }
    }
}/* /namespaced_ui_image */


function namespaced_usertools() {
    global $ID, $ACT, $lang, $INFO;
    global $namespaced;

    $objects = (new \dokuwiki\Menu\UserMenu())->getItems();
    //$objects = (new \dokuwiki\Menu\UserMenu())->getListItems('action ', tpl_getConf('glyphs'));
    $object =  (array) $objects;
//dbg(count($objects));
//dbg($objects);
    foreach ($object as $key => $value) {
//dbg($key);
//dbg($value);
        $field = (array) $value;
        $icon = $field["\0*\0svg"];
        if ($field["\0*\0type"] == "login") {
            if ($ACT == "denied") {
                print '<li class="menu-item action login"><a href="#namespaced__content" rel="nofollow" title="'.$lang['btn_login'].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['btn_login'].'</span></a></li>';
            } else {
                print '<li class="menu-item action login"><a href="/doku.php?id='.$ID.'&amp;do=login" rel="nofollow" title="'.$lang['btn_login'].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['btn_login'].'</span></a></li>';
            }
        } elseif (($field["\0*\0type"] == "register") && ($ACT != "register")) {
            print '<li class="menu-item action register"><a href="/doku.php?id='.$ID.'&amp;do=register" rel="nofollow" title="'.$lang['btn_register'].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['btn_register'].'</span></a></li>';
        } elseif ($field["\0*\0type"] == "profile") {
            if (isset($namespaced['widgets']['footer']['user.html'])) {
                print '<li class="menu-item action profile"><a href="#namespaced__widget_user" rel="nofollow" title="'.$lang['profile'].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['profile'].'</span></a></li>';
            } else {
                print '<li class="menu-item action account-edit"><a href="/doku.php?id='.$ID.'&amp;do=profile" rel="nofollow" title="'.$lang['btn_profile'].'">'.inlineSVG($namespaced['glyphs']["account-edit"]).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['btn_profile'].'</span></a><ul class="sub-menu nostyle"><li class="user"><span class="loggedinas flex justify-center">'.$lang['loggedinas'].' '.userlink().'</span></li></ul></li>';
            }
//dbg($namespaced['glyphs']['account-edit']);

            //PAGES PERSOS MANQUANTES
            // Custom UserTools
            //if ($uhp['private']['id']) {
            //    print '<li>';
            //        tpl_link(wl($uhp['private']['id']),$uhp['private']['string'].inlineSVG($namespaced['glyphs']['private']),' title="'.$uhp['private']['id'].'"');
            //    print '</li>';
            //}
            //if ($uhp['public']['id']) {
            //    print '<li>';
            //        tpl_link(wl($uhp['public']['id']),$uhp['public']['string'].inlineSVG($namespaced['glyphs']['public']),' title="'.$uhp['public']['id'].'"');
            //    print '</li>';
            //}

        } elseif (($field["\0*\0type"] == "admin") && ($_SERVER['REMOTE_USER'] != NULL) && ($INFO['isadmin'])) {
            print '<li class="menu-item menu-item-has-children action admin">';
                print '<a href="/doku.php?id='.$ID.'&do=admin" rel="nofollow" title="'.$lang['btn_admin'].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['btn_admin'].'</span></a>';
                print '<ul class="sub-menu nostyle">';
                    //namespaced_admindropdown();
                    namespaced_dropdown();
                print '</ul>';
            print '</li><!-- .action.admin -->';
        } elseif ($field["\0*\0type"] == "logout") {
            // Extra cache dropdown
            if (($_SERVER['REMOTE_USER'] != NULL) && ($INFO['ismanager'])) {
                print '<li class="menu-item menu-item-has-children action cache">';
                    print '<span title="'.tpl_getLang('cache').'">'.namespaced_glyph('recycle', true).'<span'.$namespaced['a11y']['standalone'].'>'.tpl_getLang('cache').'</span></span>';
                    print '<ul class="sub-menu nostyle">';
                        namespaced_dropdown("cache");
                    print '</ul>';
                print '</li><!-- .action.cache -->';
            }
            print '<li class="menu-item action logout"><a href="/doku.php?id='.$ID.'&amp;do=logout&amp;sectok='.$field["\0*\0params"]['sectok'].'" rel="nofollow" title="'.$lang['btn_logout'].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$lang['btn_logout'].'</span></a></li>';
        } else {
            print '<li class="menu-item action debug '.$field["\0*\0type"].'"><a title="'.$field["\0*\0type"].'">'.inlineSVG($icon).'<span'.$namespaced['a11y']['standalone'].'>'.$field["\0*\0type"].'</span></a></li>';
//dbg($field["\0*\0type"]);
//dbg($field["\0*\0type"]);
//dbg($field["\0*\0svg"]);
//dbg($lang['btn_'.$field["\0*\0type"]]);
//dbg($field);
        }
    }
}/* /namespaced_usertools */

/**
 * Print context tools
 */
function namespaced_contools() {
    global $ID, $ACT, $INFO, $conf, $lang;
    global $namespaced;

    // NAV BUTTON(S)
    // Standalone buttons
    if (tpl_getConf('splitnav')) {
        if (!in_array($namespaced['ishome'], array("default", "untranslated", "translated"))) {
            print '<li class="wikihome">';
                // display link to the home page
                tpl_link(
                    wl(),
                    namespaced_glyph('home', true).'<span>'.tpl_getLang('wikihome').'</span>',
                    'accesskey="h" title="'.tpl_getLang('wikihome').' [H]" rel="nofollow"'
                );
            print '</li>';
        }
        //if ((strpos(tpl_getConf('navbuttons'), 'parentns') !== false) and (($namespaced['ishome'] == "nshome") and (getns(getns($ID)) != null))) {
        if (getns(getns($ID)) != null) {
            print '<li class="parentns">';
                // display link to parent namespace home page
                tpl_link(
                    wl(getns(getns($ID)).':'.$conf['start']),
                    namespaced_glyph('parentns', true).'<span>'.tpl_getLang('parentns').'</span>',
                    'title="'.tpl_getLang('parentns').'" rel="nofollow"'
                );
            print '</li>';
        }
        if ($namespaced['ishome'] == false) {
            print '<li class="nshome">';
                // display link to namespace home page
                tpl_link(
                    wl(getns($ID).':'.$conf['start']),
                    namespaced_glyph('nshome', true).'<span>'.tpl_getLang('nshome').'</span>',
                    'title="'.tpl_getLang('nshome').'" rel="nofollow"'
                );
            print '</li>';
        }
    // ... or one button to rule them all...
    } else {
        if ($namespaced['ishome'] == false) {
            print '<li class="nshome">';
                // display link to namespace home page
                tpl_link(
                    wl(getns($ID).':'.$conf['start']),
                    namespaced_glyph('nshome', true).'<span>'.tpl_getLang('nshome').'</span>',
                    'title="'.tpl_getLang('nshome').'" rel="nofollow"'
                );
            print '</li>';
        } elseif (getns(getns($ID)) != null) {
            print '<li class="parentns">';
                // display link to parent namespace home page
                tpl_link(
                    wl(getns(getns($ID)).':'.$conf['start']),
                    namespaced_glyph('parentns', true).'<span>'.tpl_getLang('parentns').'</span>',
                    'title="'.tpl_getLang('parentns').'" rel="nofollow"'
                );
            print '</li>';
        } elseif (!in_array($namespaced['ishome'], array("default", "untranslated", "translated"))) {
            print '<li class="wikihome">';
                // display link to the home page
                tpl_link(
                    wl(),
                    namespaced_glyph('home', true).'<span>'.tpl_getLang('wikihome').'</span>',
                    'accesskey="h" title="'.tpl_getLang('wikihome').' [H]" rel="nofollow"'
                );
            print '</li>';
        }
    }
    // Save settings
    if (($INFO['isadmin'] || $INFO['ismanager']) && ($ACT == "admin") && ($_GET['page'] == "config")) {
        print '<li class="savesettings"><button class="flex" type="submit" form="dw__configform" value="submit" title="'.$lang['btn_save'].' [s]">'.namespaced_glyph('save', true).'<span>'.$lang['btn_save'].'</span></button></li>';
    }
    // Reset settings
    if (($INFO['isadmin'] || $INFO['ismanager']) && ($ACT == "admin") && ($_GET['page'] == "config")) {
        print '<li class="resetsettings"><button class="flex" type="reset" form="dw__configform" value="reset" title="'.$lang['btn_reset'].'">'.namespaced_glyph('reset', true).'<span>'.$lang['btn_reset'].'</span></button></li>';
    }
    // Save page modification
    if (($ACT == "edit") or ($ACT == "draft")) {
        print '<li class="savepage"><button class="flex" name="do[save]" type="submit" form="dw__editform" title="'.$lang['btn_save'].' [s]">'.namespaced_glyph('save', true).'<span>'.$lang['btn_save'].'</span></button></li>';
    }
    // Preview page modification
    if (($ACT == "edit") or ($ACT == "draft")) {
        print '<li class="previewpage"><button class="flex" name="do[preview]" type="submit" form="dw__editform" title="'.$lang['btn_preview'].' [p]">'.namespaced_glyph('preview', true).'<span>'.$lang['btn_preview'].'</span></button></li>';
    }
    // Cancel page modification
    if (($ACT == "edit") or ($ACT == "draft")) {
        print '<li class="cancelpage"><button class="flex" name="do[cancel]" type="submit" form="dw__editform" title="'.$lang['btn_cancel'].'">'.namespaced_glyph('reset', true).'<span>'.$lang['btn_cancel'].'</span></button></li>';
    }
    // Syntax
    if ($ACT=='edit') {
        print '<li class="syntax"><a href="/doku.php?id=wiki:syntax" title="'.tpl_getLang('syntax').'" rel="nofollow">'.namespaced_glyph('syntax', true).'<span>'.tpl_getLang('syntax').'</span></a></li>';
    }
    // Playground
    if (strpos($ID, 'playground:') !== 0) {
        print '<li class="playground"><a href="/doku.php?id=playground:playground&amp;do=edit" rel="nofollow" title="playground:playground">'.namespaced_glyph('playground', true).'<span>'.tpl_getLang('playground').'</span></a></li>';
    }
}/* namespaced_contools */

/**
 * Adapted from tpl_admin.php file of Bootstrap3 template by Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 */
//function namespaced_admindropdown() {
function namespaced_dropdown($menu = "admin") {
    global $ID, $ACT, $auth, $conf, $namespaced;

    if ($menu == "admin") {
        $admin_plugins = plugin_list('admin');
        $tasks = array('usermanager', 'acl', 'extension', 'config', 'styling', 'revert', 'popularity', 'upgrade');
        $addons = array_diff($admin_plugins, $tasks);
        $adminmenu = array(
            'tasks' => $tasks,
            'addons' => $addons
        );
        foreach ($adminmenu['tasks'] as $task) {
            if(($plugin = plugin_load('admin', $task, true)) === null) continue;
            if($task == 'usermanager' && ! ($auth && $auth->canDo('getUsers'))) continue;
            $label = $plugin->getMenuText($conf['lang']);
            if (! $label) continue;
            if ($task == "popularity") { $label = preg_replace("/\([^)]+\)/","",$label); }
            $class = 'action '.$task;
            if (($ACT == 'admin') and ($_GET['page'] == $task)) { $class .= ' active'; }
            echo sprintf('<li><a href="%s" title="%s"%s>%s%s'.namespaced_glyph($task, true).'</a></li>', wl($ID, array('do' => 'admin','page' => $task)), ucfirst($task), ' class="'.$class.'"', "", $label);
        }
        $f = fopen(DOKU_INC.'inc/lang/'.$conf['lang'].'/adminplugins.txt', 'r');
        $line = fgets($f);
        fclose($f);
        $line = preg_replace('/=/', '', $line);
        if (count($adminmenu['addons']) > 0) {
            echo '<li class="dropdown-header">'.$line.'<hr/></li>';
            foreach ($adminmenu['addons'] as $task) {
    //dbg($task);
                if(($plugin = plugin_load('admin', $task, true)) === null) continue;
                if ($task == "move_tree") {
                    $parts = explode('<a href="%s">', $plugin->getLang('treelink'));
                    $label = substr($parts[1], 0, -5);
                } else {
                    $label = $plugin->getMenuText($conf['lang']);
                }
                if($label == null) { $label = ucfirst($task); }
                $class = 'action '.$task;
                if (($ACT == 'admin') and ($_GET['page'] == $task)) { $class .= ' active'; }
                echo sprintf('<li><a href="%s" title="%s"%s>%s %s'.namespaced_glyph($task, true).'</a></li>', wl($ID, array('do' => 'admin','page' => $task)), ucfirst($task), ' class="'.$class.'"', "", ucfirst($label));
            }
        }
    } elseif ($menu == "cache") {
        //echo '<li class="dropdown-header">'.tpl_getLang('cache').'<hr/></li>';
        echo '<li><a href="'.wl($ID, array("do" => $ACT, "page" => $_GET['page'], "purge" => "true")).'">'.tpl_getLang('purgepagecache').namespaced_glyph("pagerefresh", true).'</a></li>';
        echo '<li><a href="'.DOKU_URL.'lib/exe/js.php">'.tpl_getLang('purgejscache').namespaced_glyph("recycle", true).'</a></li>';
        echo '<li><a href="'.DOKU_URL.'lib/exe/css.php">'.tpl_getLang('purgecsscache').namespaced_glyph("recycle", true).'</a></li>';
    }
}/* namespaced_dropdown */

function namespaced_glyph($glyph, $return = false) {
    global $namespaced;
//dbg($glyph);
    if (isset($namespaced['glyphs'][$glyph])) {
        $result = inlineSVG($namespaced['glyphs'][$glyph], 4096);
//dbg("ici?");
    } else {
//dbg($glyph);
        $result = inlineSVG(".".tpl_basedir()."images/glyphs/alert.svg", 343);
//dbg("là");
    }
    if ($return) {
//dbg("ici aussi?");
//dbg($result);
        return $result;
    } else {
//dbg("là");
        print $result;
        return 1;
    }
}/* namespaced_glyph */

/**
 * Adapted from page_findnearest() core function
 *
 * Print some info about the current page
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 *
 * @param bool $ret return content instead of printing it
 * @return bool|string
 */
function namespaced_docinfo($ret = false) {
    global $conf;
    global $lang;
    global $INFO;
    global $ID;
    global $namespaced;

    // return if we are not allowed to view the page
    if(!auth_quickaclcheck($ID)) {
        return false;
    }

    // prepare date and path
    $fn = $INFO['filepath'];
    if(!$conf['fullpath']) {
        if($INFO['rev']) {
            $fn = str_replace($conf['olddir'].'/', '', $fn);
        } else {
            $fn = str_replace($conf['datadir'].'/', '', $fn);
        }
    }
    $fn   = utf8_decodeFN($fn);
//    $date = dformat($INFO['lastmod']);
    $date = namespaced_date("short", $INFO['lastmod'], true, true);
    // print it
    if($INFO['exists']) {
        $out = '';
//print "<img class='qrcode' src='".$namespaced['qrcode']['id']."' alt='*this page*' />";
        if($INFO['editor']) {
            $out .= '<span title="'.tpl_getLang('lasteditor').'" class="flex gap3 editor">'.namespaced_glyph('editor', true);
            if ((isset($namespaced['qrcode']['editor'])) and ($namespaced['qrcode']['editor'] != null)) {
                $out .= "<img class='qrcode editor' src='".$namespaced['qrcode']['editor']."' alt='*qrcode*' title='".tpl_getLang('lasteditor')."' />";
            }
            $out .= '<span class="content"><bdi>'.ucfirst(editorinfo($INFO['editor'])).'</bdi></span>';
        } else {
            $out .= '<span class="flex gap3 editor svgonly" title="'.ucfirst($lang['external_edit']).'">'.namespaced_glyph('extedit', true);
            //$out .= '['.$lang['external_edit'].']';
        }
        $out .= '</span>';
        $out .= '<span title="'.explode(':',$lang['lastmod'])[0].'" class="flex gap3 lastmod">'.namespaced_glyph('lastmod', true).'<span class="content">'.$date.'</span></span>';
        if($INFO['locked']) {
            $out .= '<span title="'.$lang['lockedby'].'" class="flex gap3 locked">'.namespaced_glyph('locked', true);
            if ((isset($namespaced['qrcode']['locked'])) and ($namespaced['qrcode']['locked'] != null)) {
                $out .= "<img class='qrcode locked' src='".$namespaced['qrcode']['locked']."' alt='*qrcode*' title='".$lang['lockedby']."' />";
            }
            $out .= '<span class="content"><bdi>'.ucfirst(editorinfo($INFO['locked'])).'</bdi></span>';
            $out .= '</span>';
        }
        $out .= '<span title="'.tpl_getLang('pagepath').'" class="flex gap3 path">'.namespaced_glyph('pagepath', true);
        $out .= '<span class="content"><bdi>'.$fn.'</bdi></span></span>';
        if($ret) {
            return $out;
        } else {
//            $classes = "docInfo flex evenly wrap smallest";
//            if (strpos(tpl_getConf('neutralize'), 'docinfo') !== false) {
//                $classes .= " neu";
//            }
//            if (!(strpos(tpl_getConf('print'), 'docinfo') !== false)) {
//                $classes .= " noprint";
//            }
//            echo '<div class="'.$classes.'">';
            echo '<div class="docInfo flex gap10 evenly">';
            echo $out;
            echo '</div>';
            return true;
        }
    }
    return false;
}/* /namespaced_docinfo */
