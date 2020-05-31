<?php
/**
 * Dokuwiki ColorMag template
 * Original Wordpress theme URI: https://themegrill.com/themes/colormag/
 * 
 * @link    https://www.dokuwiki.org/template:colormag
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 3 (https://www.gnu.org/licenses/gpl-3.0.html)
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
function colormag_init() {
    global $ID, $JSINFO, $conf, $INFO, $showSidebar;
    global $colormag;

    // UI IMAGES
    $images= array('banner', 'pattern', 'sidecard', 'widebanner');
//    if (true) { array_push($images, 'logo'); };
//dbg($images);
    // IMAGES
    // Search for namespace UI images (logo, banner, widebanner and potential last sidebar header image aka sidecard)
    //if (tpl_getConf('logo') != null) {
    //    $colormag['images']['logo'] = colormag_inherit(tpl_getConf('logo'));
    //}
    //if (tpl_getConf('banner') != null) {
    //    $colormag['images']['banner'] = colormag_inherit(tpl_getConf('banner'));
    //}
    //if (tpl_getConf('widebanner') != null) {
    //    $colormag['images']['widebanner'] = colormag_inherit(tpl_getConf('widebanner'));
    //}
    //if (tpl_getConf('sidecard') != null) {
    //    $colormag['images']['sidecard'] = colormag_inherit(tpl_getConf('sidecard'));
    //}
    foreach ($images as $type) {
//dbg($type);
//dbg(tpl_getConf($type));
//dbg($showSidebar);
//        if (tpl_getConf($type) != null) {
//        if ((($type == "sidecard") and ($showSidebar != null)) or (tpl_getConf($type) != null)) {
//        if ((tpl_getConf($type) != null) and ((($type == "sidecard") and ($showSidebar != null)) or ($type == "banner") or ($type == "widebanner"))) {
        if (tpl_getConf($type) != null) {
            $colormag['images'][$type] = colormag_inherit(tpl_getConf($type), "media", $ID);
        }
    }
//dbg($colormag['images']);

    // COLLECT LINKS
    $colormag['topbar-links'] = page_findnearest(tpl_getConf('topbarlinks'), true);
//dbg($colormag['topbar-links']);

    // GET SOCIAL LINKS
    $colormag['socials'] = array();
    // Load "social" links from DOKU_CONF/social.local.conf (or tpl/colormag/debug/social.local.conf) to global conf
    if (($_GET['debug'] == 1) or ($_GET['debug'] == "social")) {
        $socialFile = tpl_incdir().'debug/social.local.conf';
    } else {
        $socialFile = DOKU_CONF.'social.local.conf';
    }
//dbg($socialFile);
    // If file exists...
    if (@file_exists($socialFile)) {
//dbg($socialFile);
        // ... read it's content
        $colormag['socials'] = confToHash($socialFile);
        $colormag['socials'] = array_filter($colormag['socials']);
        // Sorting array in reverse alphabetical order on keys because they will float to the right (now done by default)
        // krsort($socialFile);
        // Get actual links from file content
//dbg($socialFile);
//dbg(gettype($socials));
//var_dump($socials);
//        if (is_array($colormag['socials'])) {
//            foreach ($socials as $key => $value) {
////dbg($key." => ".$value);
//                if (filter_var($value, FILTER_VALIDATE_URL)) { 
//                    $colormag['socials'][$key] = $value;
//                }
//            }
//        } else {
//            dbg("Socials error: ".$colormag['socials']);
//        }
//dbg($colormag['socials']);
    }

    // GET FOOTER WIDGETS
    $widgets= array('footer','side');
    foreach ($widgets as $type) {
        $colormag['widgets'][$type] = array();
        // Load footer widgets list from DOKU_CONF/$type.widgets.local.conf to global conf
        if (($_GET['debug'] == 1) or ($_GET['debug'] == "widgets")) {
            $widgetsFile = tpl_incdir().'debug/'.$type.'.widgets.local.conf';
        } else {
            $widgetsFile = DOKU_CONF.$type.'.widgets.local.conf';
        }
//dbg($footerwidgetsFile);
        // If file exists...
        if (@file_exists($widgetsFile)) {
//dbg($footerwidgetsFile);
            // ... read it's content
            $colormag['widgets'][$type] = confToHash($widgetsFile);
            $colormag['widgets'][$type] = array_filter($colormag['widgets'][$type]);
        }
//dbg($colormag['widgets'][$type]);
    }
    // GLYPHS
    // Search for default or custum default SVG glyphs
//    $colormag['glyphs']['about'] = 'help';
    $colormag['glyphs']['acl'] = 'key-variant';
    $colormag['glyphs']['back-to-article'] = 'skip-previous';
//    $colormag['glyphs']['admin'] = 'settings';
    $colormag['glyphs']['config'] = 'tune';
    $colormag['glyphs']['date'] = 'calendar-month';
    $colormag['glyphs']['discussion'] = 'comment-text-multiple';
    $colormag['glyphs']['editor'] = 'fountain-pen-tip';
    $colormag['glyphs']['ellipsis'] = 'ellipsis';
    $colormag['glyphs']['extension'] = 'puzzle';
    $colormag['glyphs']['externaleditor'] = 'desktop-classic';
    $colormag['glyphs']['from-playground'] = 'shovel-off';
    $colormag['glyphs']['help'] = 'lifebuoy';
    $colormag['glyphs']['hide'] = 'eye-off';
    $colormag['glyphs']['home'] = 'home';
    $colormag['glyphs']['language-home'] = 'flag';
    $colormag['glyphs']['locked'] = 'lock';
//    $colormag['glyphs']['login'] = 'login';
//    $colormag['glyphs']['logout'] = 'logout';
    $colormag['glyphs']['lastmod'] = 'calendar-clock';
//    $colormag['glyphs']['link'] = 'web';
    $colormag['glyphs']['locked'] = 'lock';
    $colormag['glyphs']['map'] = 'sitemap';
//    $colormag['glyphs']['map-hover'] = 'map-search-outline';
//    $colormag['glyphs']['map-active'] = 'map-search';
//    $colormag['glyphs']['menu'] = 'menu';
    $colormag['glyphs']['move_main'] = 'folder-move';
    $colormag['glyphs']['move_tree'] = 'file-tree-outline';
    $colormag['glyphs']['namespace-start'] = 'folder-home';
    $colormag['glyphs']['news'] = 'alert-decagram';
    $colormag['glyphs']['pagepath'] = 'folder-open';
    $colormag['glyphs']['parent-namespace'] = 'reply-all';
    $colormag['glyphs']['playground'] = 'shovel';
    $colormag['glyphs']['popularity'] = 'star-half';
    $colormag['glyphs']['private-ns'] = 'folder-key';
    $colormag['glyphs']['profile'] = 'account-edit';
    $colormag['glyphs']['public-page'] = 'comment-account';
    $colormag['glyphs']['recycle'] = 'recycle';
    $colormag['glyphs']['refresh'] = 'autorenew';
    $colormag['glyphs']['revert'] = 'step-backward';
    $colormag['glyphs']['save'] = 'floppy';
    $colormag['glyphs']['search'] = 'magnify';
    $colormag['glyphs']['searchindex'] = 'database-search';
//    $colormag['glyphs']['separator'] = 'cards-diamond';
    $colormag['glyphs']['show'] = 'eye';
//    $colormag['glyphs']['social'] = 'account-network';
    $colormag['glyphs']['styling'] = 'palette';
    $colormag['glyphs']['topbar-page'] = 'link-variant';
    $colormag['glyphs']['topbar-page-add'] = 'link-variant-plus';
//    $colormag['glyphs']['topbar-page-denied'] = 'link-variant-off';
    $colormag['glyphs']['trace'] = 'timeline-clock';
    $colormag['glyphs']['translated'] = 'flag-triangle';
    $colormag['glyphs']['translation'] = 'translate';
    $colormag['glyphs']['upgrade'] = 'cloud-download';
//    $colormag['glyphs']['user'] = 'account';
//    $colormag['glyphs']['unknown-user'] = 'account-alert';
    $colormag['glyphs']['usermanager'] = 'account-group';
    $colormag['glyphs']['usertools'] = 'account-cog';
    $colormag['glyphs']['youarehere'] = 'map-marker';
    foreach ($colormag['socials'] as $key => $value) {
        if ($value) {
            $colormag['glyphs'][$key] = $key;
        }
    }
//dbg($colormag['glyphs']);
    foreach ($colormag['glyphs'] as $key => $value) {
//dbg($key);
        /*if (is_file(DOKU_CONF."glyphs/".$key.".svg")) {*/
        /*if (is_file(tpl_incdir().'images/glyphs/custom/'.$key.'.svg')) {*/
        if (($key != "ellipsis") && (is_file(DOKU_CONF.'glyphs/'.$key.'.svg'))) {
            //$colormag['glyphs'][$key] = inlineSVG(DOKU_CONF.'glyphs/'.$key.'.svg', 2048);
            $colormag['glyphs'][$key] = DOKU_CONF.'glyphs/'.$key.'.svg';
        //} elseif (is_file('.'.tpl_basedir().'images/glyphs/'.$value.'.svg')) {
        } else {
            //$colormag['glyphs'][$key] = inlineSVG('.'.tpl_basedir().'images/glyphs/'.$value.'.svg', 2048);
            $colormag['glyphs'][$key] = DOKU_INC.tpl_basedir().'images/glyphs/'.$value.'.svg';
            $colormag['glyphs'][$key] = DOKU_INC.'lib/tpl/colormag/images/glyphs/'.$value.'.svg';
            //$colormag['glyphs'][$key] = tpl_basedir().'images/glyphs/'.$value.'.svg';
        //} else {
        //    $colormag['glyphs'][$key] = inlineSVG(DOKU_INC.'lib/images/menu/00-default_checkbox-blank-circle-outline.svg', 2048);
        }
    }
//dbg($colormag['glyphs']);

    // HELPER PLUGINS
    // Preparing usefull plugins' helpers
    // Translation
    $colormag['translation'] = array();
    $colormag['translation']['untranslatedhome'] = $conf['start'];
    //$colormag['translation']['parts'] = array();
    if (!plugin_isdisabled('translation')) {
        $colormag['translation']['helper'] = plugin_load('helper','translation');
        $colormag['translation']['parts'] = $colormag['translation']['helper']->getTransParts($ID);
//dbg($colormag['translation']['parts']);
//dbg($colormag['translation']['parts'][1]);
        if (strpos($conf['plugin']['translation']['translations'], $conf['lang']) !== false) {
            $colormag['translation']['untranslatedhome'] = $conf['lang'].":".$conf['start'];
        }
//        //$colormag['translation']['ishome'] = false;
//        if ($colormag['translation']['parts'][1] == $conf['start']) {
////            if (($colormag['translation']['parts'][0] == null) or ($colormag['translation']['parts'][0] == $conf['lang'])) {
//            if ($ID == $colormag['translation']['untranslatedhome']) {
//                //$colormag['translation']['ishome'] = "untranslated";
//                $colormag['ishome'] = "untranslated";
//            //} elseif (($colormag['translation']['parts'][1] == $conf['start']) and ($colormag['translation']['parts'][0] != $conf['lang']))) {
//            } elseif (($colormag['translation']['parts'][0] != "") and (strpos($conf['plugin']['translation']['translations'], $colormag['translation']['parts'][0]) !== false)) {
//                //$colormag['translation']['ishome'] = "translated";
//                $colormag['ishome'] = "translated";
//            }
//        } elseif ($colormag['translation']['parts'][0] != $conf['lang']) {
        if ($colormag['translation']['parts'][0] != $conf['lang']) {
            $colormag['translation']['istranslated'] = true;
        }
        //}
    }
//dbg($colormag['translation']['ishome']);

    // IS HOME ?
    $colormag['ishome'] = colormag_ishome($ID);
//dbg($colormag['ishome']);

    // CURRENT NS AND PATH
    // Get current namespace and corresponding path (resulting path will correspond to namespace's pages, media or conf files)
//    //$colormag['currentNs'] = getNS(cleanID($id));
    $colormag['ns']['current'] = $INFO['namespace'];
////dbg($colormag['currentNs']);
////    if ((isset($colormag['trans']['parts'][1])) and ($colormag['trans']['parts'][1] != null)) {
//////dbg($colormag['trans']['parts']);
////        if (strpos($conf['plugin']['translation']['translations'], $conf['lang']) !== false) {
//////dbg("ici? ".$conf['lang']);
////            $colormag['untranslatedNs'] = $conf['lang'].":".getNS(cleanID($colormag['trans']['parts'][1]));
////        } else {
//////dbg("là?");
////            $colormag['untranslatedNs'] = getNS(cleanID($colormag['trans']['parts'][1]));
////        }
////    } else {
////        $colormag['untranslatedNs'] = $colormag['currentNs'];
////    }
//////dbg($colormag['baseNs']);
////    if ($colormag['currentNs'] != null) {
////        $colormag['currentPath'] = "/".str_replace(":", "/", $colormag['currentNs']);
////    } else {
////        $colormag['currentPath'] = "/";
////    }
//dbg($colormag['ns']['current']);

    // CURRENT NS' PARENTS
    $colormag['parents'] = array();
    $parts = explode(":", $ID);
//dbg($parts);
    $tmp = null;
    if (count($parts) >= 1) {
//dbg($parts);
        for ($i = 0; $i < count($parts) - 1; $i++) {
            $tmp .= ":".$parts[$i];
            if (ltrim($tmp.":".$conf['start'], ":") != $ID) {
                array_push($colormag['parents'], ltrim($tmp.":".$conf['start'], ":"));
            }
        }
    }
    // Add `start` at begining of $colormag['parents'] array if needed
    if ($colormag['parents'][0] != $conf['start']) {
        array_unshift($colormag['parents'], $conf['start']);
    }
//dbg($colormag['parents']);

    // NAMESPACE THEME
    // Load template default LESS placehodlers
//dbg(md5($ID));
    //$styleinifile = tpl_incdir().'style.ini';
    //$styleini = parse_ini_file($styleinifile, true);
    // Look for a customized 'style.ini' file generated by Styling plugin
    if (is_file(DOKU_CONF."tpl/colormag/style.ini")) {
        $styleini = parse_ini_file(DOKU_CONF."tpl/colormag/style.ini", true);
    // Or load template's default 'style.ini'
    } else {
    //if (is_file(tpl_incdir()."style.ini")) {
        $styleini = parse_ini_file (tpl_incdir()."style.ini", true);
    }
//dbg(tpl_incdir().'style.ini');
//dbg($styleini);
//dbg($styleini['replacements']['__theme_color__']);
    $colormag['initial_theme_color'] = $styleini['replacements']['__theme_color__'];
//dbg($colormag['initial_theme_color']);
    // Look for a "nstheme" page
    //$themelFile = page_findnearest("links", true);
    //$nsStyleIni = colormag_file("style", "inherit", "conf", $colormag['baseNs']);
    //$themeinifile = "./data/pages/test/test/theme.ini";
    $themeinifile = colormag_inherit("theme.ini", "conf", $ID);
//dbg($themeinifile);
    if (is_file($themeinifile['src'])) {
        $themeini = parse_ini_file($themeinifile['src'], true);
//dbg($themeini);
        foreach ($themeini['replacements'] as $key => $value) {
            if ($value) {
                $styleini['replacements'][$key] = $value;
            }
        }
    } elseif ((tpl_getConf('autotheme') != 'disabled') and ($colormag['images'][tpl_getConf('autotheme')]['path'] != null) and ($_GET['do'] != "admin") and ($colormag['ishome'] == false) and ($ID != $conf['start'])) {
        // Autotheme timer start
        $rustart = getrusage();

        $autotheme = colormag_color($ID, true);

        if ($autotheme) {
            $styleini['replacements']['__theme_color__'] = $autotheme;
            // Autotheme timer end

            $ru = getrusage();
            $time = rutime($ru, $rustart, "utime");
            if ($time > 100) {
                $alert = -1;
            } elseif ($time > 50) {
                $alert = 2;
            } elseif ($time > 20) {
                $alert = 0;
            } else {
                $alert = 1;
            }
            $autotheme_msg = array("Autotheme color collection took ".$time."ms to get main color from ".tpl_getConf('autotheme').". It spent ".rutime($ru, $rustart, "stime")."ms in system calls.", $alert);
        }

    }
//dbg($styleini['replacements']);
    $css = io_readFile(tpl_incdir()."/css/colormag.theme.less");
//dbg(tpl_incdir()."/css/colormag.less");
//dbg($css);
    // Replace CSS' placeholders by their respective value (or LESS formula)
    $css = colormag_css_applystyle($css, $styleini['replacements']);
//dbg($css);
    $less = new lessc();
    $colormag['theme'] = $less->compile($css);

    // BUILD LAST CHANGES LIST
//    if ((strpos(tpl_getConf('topbar'), 'newsticker') !== false) and ($ID != $conf['start'])) {
    if (strpos(tpl_getConf('topbar'), 'newsticker') !== false) {
    // Retrieve number of last changes to show from digit at the end of setting ("other" field)
        $colormag['recents'] = array();
        $showLastChanges = intval(end(explode(',', tpl_getConf('newsticker'))));
        $flags = 0;
        if (strpos(tpl_getConf('newsticker'), 'skip_deleted') !== false) {
            $flags = RECENTS_SKIP_DELETED;
        }
        if (strpos(tpl_getConf('newsticker'), 'skip_minors') !== false) {
            $flags += RECENTS_SKIP_MINORS;
        }
        if (strpos(tpl_getConf('newsticker'), 'skip_subspaces') !== false) {
            $flags += RECENTS_SKIP_SUBSPACES;
        }
        if ((strpos(tpl_getConf('newsticker'), 'pages') !== false) and (strpos(tpl_getConf('newsticker'), 'media') !== false)) {
            $flags += RECENTS_MEDIA_PAGES_MIXED;
        } if ((strpos(tpl_getConf('newsticker'), 'pages') === false) and (strpos(tpl_getConf('newsticker'), 'media') !== false)) {
            $flags += RECENTS_MEDIA_CHANGES;
        }
        $colormag['recents'] = getRecents(0,$showLastChanges,$colormag['ns']['current'],$flags);
//dbg($colormag['recents']);
    }

    // JSINFO
    // Store options into $JSINFO for later use
    if ((strpos(tpl_getConf('topbar'), 'newsticker') !== false) and ($colormag['recents'] != null) and is_array($colormag['recents'])) {
        $JSINFO['LoadNewsTicker'] = true;
    } else {
        $JSINFO['LoadNewsTicker'] = false;
    }
//    if (strpos(tpl_getConf('stickies'), 'pageheader') !== false) {
//        $JSINFO['StickyPageheader'] = true;
//    } else {
//        $JSINFO['StickyPageheader'] = false;
//    }
//    if (tpl_getConf('scrollspyToC')) {
//        $JSINFO['LoadGumshoe'] = true;
//    } else {
//        $JSINFO['LoadGumshoe'] = false;
//    }
//    $JSINFO['Animate'] = tpl_getConf('animate');
//$JSINFO['ScrollspyToc'] = tpl_getConf('scrollspyToc');
//dbg($JSINFO);

    // DEBUG
    // Adding test alerts if debug is enabled
    if (($_GET['debug'] == 1) or ($_GET['debug'] == "alerts")) {
        msg("This is an error [-1] alert with a <a href='#'>dummy link</a>", -1);
        msg("This is an info [0] message with a <a href='#'>dummy link</a>", 0);
        msg("This is a success [1] message with a <a href='#'>dummy link</a>", 1);
        msg("This is a notification [2] with a <a href='#'>dummy link</a>", 2);
    }
    
    // COLORMAG ALERTS
    // For Admins eyes only
    if ($INFO['isadmin']) {
//dbg("ici?");
        if ((strpos(tpl_getConf('breadcrumbslook'), 'pills') !== false) and (!plugin_isdisabled('twistienav'))) {
//dbg("t'es où?");
            msg("Colormag's pills breadcrumbs are currently not compatible with Twistienav (see <a href='https://github.com/geekitude/dokuwiki-template-colormag/issues/29' rel='nofollow'>issue #24</a>)", -1);
        }
        if (($autotheme_msg != null) and (($_GET['debug'] == 1) or ($_GET['debug'] == 'timers'))) {
//dbg("pas là?");
            msg($autotheme_msg[0], $autotheme_msg[1]);
        }
    }
}/* /colormag_init */

/**
 * Returns body classes according to settings
 */
function colormag_bodyclasses() {
    global $showSidebar, $ID;
    global $colormag;

    $classes = array();

//    if ($showSidebar) {
//        if (tpl_getConf('sidebarpos') == "left") {
//            $sidebar = "left-sidebar";
//        } else {
//            $sidebar = "right-sidebar";
//        }
//        if (strpos(tpl_getConf('stickies'), 'sidebar') !== false) {
//            $sidebar .= " sticky-sidebar";
//        }
//        if ((strpos(tpl_getConf('extractible'), 'sidebar') !== false) and ((tpl_getConf('layout') == "boxed") or (tpl_getConf('layout') == "mix") or (tpl_getConf('layout') == "box2full")) and (tpl_getConf('sidebarPos') == "left")) {
//            $sidebar .= " extractible-sidebar";
//        }
//    } else {
//        $sidebar = "no-sidebar";
//    }

    if (($_GET['debug'] == 1) or ($_GET['debug'] == 'images') or ($_GET['debug'] == 'pattern')) {
        $pattern = "dbg-pattern";
//    } elseif (tpl_getConf('bodybg') == "pattern") {
    } elseif (isset($colormag['images']['pattern']['ns'])) {
        $pattern = "pattern";
    } else {
        $pattern = null;
    }

    if (isset($colormag['ishome'])) {
        if ($colormag['ishome'] == "untranslated") {
            $home = "untranslated-home";
        } elseif ($colormag['ishome'] == "translated") {
            $home = "translated-home";
        } else {
            $home = "not-home";
        }
    } else {
        $home = null;
    }
//    array_push($classes, $home, $pattern, $showSidebar ? ((strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'right-sidebar' : 'left-sidebar') : 'no-sidebar', tpl_getConf('layout').'-layout', (strpos(tpl_getConf('flexflip'), 'banner') !== false) ? 'banner-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagenav') !== false) ? 'pagenav-flip' : '', (strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'sidebar-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagetools') !== false) ? 'pagetools-flip' : '', (strpos(tpl_getConf('flexflip'), 'socket') !== false) ? 'socket-flip' : '', tpl_getConf('uicolor').'-ui', (strpos(tpl_getConf('print'), 'hrefs') !== false) ? 'printhrefs' : '', ($_GET['debug']==1) ? 'debug' : '');
    array_push($classes, $home, $pattern, $showSidebar ? ((strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'right-sidebar' : 'left-sidebar') : 'no-sidebar', tpl_getConf('layout').'-layout', (strpos(tpl_getConf('flexflip'), 'banner') !== false) ? 'banner-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagenav') !== false) ? 'pagenav-flip' : '', (strpos(tpl_getConf('flexflip'), 'sidebar') !== false) ? 'sidebar-flip' : '', (strpos(tpl_getConf('flexflip'), 'pagetools') !== false) ? 'pagetools-flip' : '', (strpos(tpl_getConf('flexflip'), 'socket') !== false) ? 'socket-flip' : '', tpl_getConf('widgetslook').'-widgets', (strpos(tpl_getConf('print'), 'hrefs') !== false) ? 'printhrefs' : '', ($_GET['debug']==1) ? 'debug' : '');
//dbg($classes);
    /* TODO: better home detection than core */
    return rtrim(join(' ', array_filter($classes)));
}/* /colormag_bodyclasses */

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
function colormag_inherit($target, $type = "media", $origin, $useacl = false){
    //if ((string) $target === '') return false;
    global $conf;

    $ns = $origin;
    $result = array();
    $glob = array();
    $file = null;
    // In case we are in a farm, we have to make sure we search in animal's data dir by starting at DOKU_CONF directory (will however work if not in a farm)
    if ($type == "media") {
        $base = DOKU_CONF.'../'.$conf['savedir'].'/media/';
    } else {
        $base = DOKU_CONF.'tpl/colormag/';
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
            
    } while(($ns !== false) and (empty($glob)));
    //} while($ns !== false);

    if (($type == "media") and (count($glob) == 0)) {
        $result['ns'] = cleanID("wiki:".$conf['start']);
        $glob = glob(DOKU_CONF.'../'.$conf['savedir'].'/media/wiki/'.$target.'.{jpg,gif,png}', GLOB_BRACE);
    }
//dbg($result);

    $src = null;
    if (($type == "media") and (($_GET['debug'] == 1) or ($_GET['debug'] == "images") or ($_GET['debug'] == $target))) {
        //$result['src'] = tpl_incdir().'debug/'.$target.'.png';
        $src = tpl_incdir().'debug/'.$target.'.png';
        $result['src'] = $src;
        $result['src'] = '/lib/tpl/colormag/debug/'.$target.'.png';
        $result['ns'] = null;
    } elseif (isset($glob[0])) {
        $src = $glob[0];
        if ($type == "media") {
            $result['path'] = $src;
            $result['src'] = '/lib/exe/fetch.php?media='.str_replace("/", ":", explode("media/", $src)[1]);
        } elseif ($type == "conf") {
            $result['src'] = $src;
//dbg($result);
            //$result['src'] = $src;
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
}
 
function colormag_glyph($glyph, $return = false) {
    global $colormag;
//dbg($glyph);
//if (file_exists($glyph)) {
//    dbg("bingo!");
//}
//    if (isset($colormag['socials'][$glyph])) {
//        $maxsize = 4096;
//    } else {
//        $maxsize = 2048;
//    }
//    dbg($maxsize);
//    if ((isset($colormag['glyphs'][$glyph])) and (file_exists($colormag['glyphs'][$glyph]))) {
    if (file_exists($glyph)) {
//        $result = inlineSVG($glyph, $maxsize);
        $result = inlineSVG($glyph, 4096);
//dbg("ici?");
    } else {
        $result = inlineSVG(DOKU_INC.'lib/images/menu/00-default_checkbox-blank-circle-outline.svg', 2048);
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
}/* colormag_glyph */

/**
 * Include a page
 * adapted from tpl_includeFile() to choose between debug or real include file
 *
 * See original function in inc/template.php for details
 */
//function colormag_include($file, $widget = false) {
//    if ((($_GET['debug'] == 1) or ($_GET['debug'] == 'includes')) && (file_exists(tpl_incdir().'debug/'.$file.'.html'))) {
//        if ($widget) {
//            print '<aside id="colormag__'.$file.'" class="widget">';
//        }
//        include(tpl_incdir().'debug/'.$file.'.html');
//    //} elseif (($_GET['debug'] == 'widgets') && $widget && (file_exists(tpl_incdir().'debug/'.$file.'.html'))) {
//    } elseif (($_GET['debug'] == 'widgets') && $widget && (file_exists(tpl_incdir().'debug/'.$file))) {
//        if ($widget) {
//            print '<aside id="colormag__'.$file.'" class="widget">';
//        }
//        include(tpl_incdir().'debug/'.$file);
//    } elseif (file_exists(tpl_incdir().$file.'.html')) {
//        if ($widget) {
//            print '<aside id="colormag__'.$file.'" class="widget">';
//        }
//        include(tpl_incdir().$file.'.html');
//    } else {
//        print p_wiki_xhtml($file, '', false);
//    }
//    if ($widget) {
//        print '</aside>';
//    }
//}/* /colormag_include */
function colormag_include($file) {
    if (($_GET['debug'] == 1) or ($_GET['debug'] == 'includes') or ($_GET['debug'] == 'widgets')) {
        if ((($_GET['debug'] == 1) or ($_GET['debug'] == 'includes')) && (file_exists(tpl_incdir().'debug/'.$file.'.html'))) {
            include(tpl_incdir().'debug/'.$file.'.html');
        } elseif ((($_GET['debug'] == 1) or ($_GET['debug'] == 'widgets')) && (file_exists(tpl_incdir().'debug/'.$file))) {
            include(tpl_incdir().'debug/'.$file);
        }
    } elseif (file_exists(tpl_incdir().$file.'.html')) {
        include(tpl_incdir().$file.'.html');
    } elseif (file_exists(tpl_incdir().$file)) {
        include(tpl_incdir().$file);
    } else {
        print p_wiki_xhtml($file, '', false);
    }
}/* /colormag_include */


/**
 * Render a page without any wiki caching
 */
function colormag_render($id) {
    global $conf;

dbg(wikiFN('wiki:'.$widget));
    $id = str_replace(":", "/", $id);
    $fn = $conf['datadir'].'/'.utf8_encodeFN($id).'.txt';
dbg($fn);
}


function colormag_replace($file, $string = null) {
    if (($_GET['debug'] == 'replace') && (file_exists(tpl_incdir().'debug/'.$file.'.html'))) {
        include(tpl_incdir().'debug/'.$file.'.html');
    } elseif (file_exists(tpl_incdir().$file.'.html')) {
        include(tpl_incdir().$file.'.html');
    } elseif ($string != null) {
        print $string;
    } else {
        print p_wiki_xhtml($file, '', false);
    }
}/* /colormag_replace */

/**
 * The loginform
 * adapted from html_login() because colormag doesn't need autofocus on username input
 *
 * See original function in inc/html.php for details
 */
function colormag_loginform($context = "null") {
    global $lang;
    global $conf;
    global $ID;
    global $INPUT;

    if ($context == "widget") {
        $tmp = explode("</h1>", p_locale_xhtml('login'));
        $title = explode(">", $tmp[0])[1];
        $tmp = str_replace("! ", "!<br />", $tmp[1]);
        $tmp = str_replace(". ", ".<br />", $tmp);
        print '<h6 class="widget-title title-block-wrap clearfix"><span class="label">';
            print $title;
        print '</span></h6>';
        print $tmp;
    } else {
        print p_locale_xhtml('login');
    }
    print '<div>'.NL;

    $form = new Doku_Form(array('id' => 'dw__login'));
    $form->startFieldset($lang['btn_login']);
    $form->addHidden('id', $ID);
    $form->addHidden('do', 'login');
    $form->addElement(form_makeTextField('u', ((!$INPUT->bool('http_credentials')) ? $INPUT->str('u') : ''), $lang['user'], 'username', 'block'));
    $form->addElement(form_makePasswordField('p', $lang['pass'], '', 'block'));
    if($conf['rememberme']) {
        $form->addElement(form_makeCheckboxField('r', '1', $lang['remember'], 'remember__me', 'simple'));
    }
    $form->addElement(form_makeButton('submit', '', $lang['btn_login']));
    $form->endFieldset();

    if(actionOK('register')){
        $form->addElement('<p>'.explode("?", $lang['reghere'])[0].'? '.tpl_actionlink('register','','','',true).'.</p>');
    }

    if (actionOK('resendpwd')) {
        $form->addElement('<p>'.explode("?", $lang['pwdforget'])[0].'? '.tpl_actionlink('resendpwd','','','',true).'.</p>');
    }

    html_form('login', $form);
    print '</div>'.NL;
}/* /colormag_loginform */

function colormag_usertools() {
    global $ID, $ACT, $lang, $INFO;

    $objects = (new \dokuwiki\Menu\UserMenu())->getItems();
    $object =  (array) $objects;
//dbg(count($objects));
//dbg($objects);
    foreach ($object as $key => $value) {
        $field = (array) $value;
//        if (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y') or (tpl_getConf('headertoolsIcons') == 0)) {
        if (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) {
            $class = null;
            //$icon = null;
        } else {
            $class = ' class="a11y"';
            //$icon = $field["\0*\0svg"];
        }
        $icon = $field["\0*\0svg"];
        if ($field["\0*\0type"] == "login") {
            if ($ACT == "denied") {
                print '<li class="menu-item action login"><a href="#colormag__content" rel="nofollow" title="'.$lang['btn_login'].'">'.inlineSVG($icon).'<span'.$class.'>'.$lang['btn_login'].'</span></a></li>';
            } else {
                print '<li class="menu-item action login"><a href="#colormag__userwidget" rel="nofollow" title="'.$lang['btn_login'].'">'.inlineSVG($icon).'<span'.$class.'>'.$lang['btn_login'].'</span></a></li>';
            }
        } elseif (($field["\0*\0type"] == "register") && ($ACT != "register")) {
            print '<li class="menu-item action register"><a href="/doku.php?id='.$ID.'&amp;do=register" rel="nofollow" title="'.$lang['btn_register'].'">'.inlineSVG($icon).'<span'.$class.'>'.$lang['btn_register'].'</span></a></li>';
        } elseif ($field["\0*\0type"] == "profile") {
            //print '<li class="action profile"><a href="/doku.php?id='.$ID.'#colormag__userwidget" rel="nofollow" title="'.$lang['profile'].'">'.inlineSVG($field["\0*\0svg"]).'<span class="a11y">'.$lang['profile'].'</span></a></li>';
            print '<li class="menu-item action profile"><a href="#colormag__userwidget" rel="nofollow" title="'.$lang['profile'].'">'.inlineSVG($icon).'<span'.$class.'>'.$lang['profile'].'</span></a></li>';

            //PAGES PERSOS MANQUANTES
            // Custom UserTools
            //if ($uhp['private']['id']) {
            //    print '<li>';
            //        tpl_link(wl($uhp['private']['id']),$uhp['private']['string'].inlineSVG($colormag['glyphs']['private']),' title="'.$uhp['private']['id'].'"');
            //    print '</li>';
            //}
            //if ($uhp['public']['id']) {
            //    print '<li>';
            //        tpl_link(wl($uhp['public']['id']),$uhp['public']['string'].inlineSVG($colormag['glyphs']['public']),' title="'.$uhp['public']['id'].'"');
            //    print '</li>';
            //}

        } elseif (($field["\0*\0type"] == "admin") && ($_SERVER['REMOTE_USER'] != NULL) && ($INFO['isadmin'])) {
            print '<li class="menu-item menu-item-has-children action admin">';
                print '<a href="/doku.php?id='.$ID.'&do=admin" rel="nofollow" title="'.$lang['btn_admin'].'">'.inlineSVG($icon).'<span'.$class.'>'.$lang['btn_admin'].'</span></a>';
                print '<ul class="sub-menu">';
                    colormag_admindropdown();
                print '</ul>';
            print '</li><!-- .action.admin -->';
        } elseif ($field["\0*\0type"] == "logout") {
            print '<li class="menu-item action logout"><a href="/doku.php?id='.$ID.'&amp;do=logout&amp;sectok='.$field["\0*\0params"]['sectok'].'" rel="nofollow" title="'.$lang['btn_logout'].'">'.inlineSVG($icon).'<span'.$class.'>'.$lang['btn_logout'].'</span></a></li>';
        } else {
            print '<li class="menu-item action debug '.$field["\0*\0type"].'"><a title="'.$field["\0*\0type"].'">'.inlineSVG($icon).'<span'.$class.'>'.$field["\0*\0type"].'</span></a></li>';
//dbg($field["\0*\0type"]);
//dbg($field["\0*\0type"]);
//dbg($field["\0*\0svg"]);
//dbg($lang['btn_'.$field["\0*\0type"]]);
//dbg($field);
        }
    }
}/* /colormag_usertools */

/**
 * Adapted from tpl_admin.php file of Bootstrap3 template by Giuseppe Di Terlizzi <giuseppe.diterlizzi@gmail.com>
 */
function colormag_admindropdown() {
    global $ID, $ACT, $auth, $conf, $colormag;

    $admin_plugins = plugin_list('admin');
    $tasks = array('usermanager', 'acl', 'extension', 'config', 'styling', 'revert', 'popularity', 'upgrade');
    $addons = array_diff($admin_plugins, $tasks);
    $adminmenu = array(
        'tasks' => $tasks,
        'addons' => $addons
    );
    foreach ($adminmenu['tasks'] as $task) {
        if(($plugin = plugin_load('admin', $task, true)) === null) continue;
//        if($plugin->forAdminOnly() && !$INFO['isadmin']) continue;
        if($task == 'usermanager' && ! ($auth && $auth->canDo('getUsers'))) continue;
        $label = $plugin->getMenuText($conf['lang']);
        if (! $label) continue;
        if ($task == "popularity") { $label = preg_replace("/\([^)]+\)/","",$label); }
        $class = 'action '.$task;
        if (($ACT == 'admin') and ($_GET['page'] == $task)) { $class .= ' active'; }
        echo sprintf('<li><a href="%s" title="%s"%s>%s%s'.colormag_glyph($colormag['glyphs'][$task], true).'</a></li>', wl($ID, array('do' => 'admin','page' => $task)), ucfirst($task), ' class="'.$class.'"', "", $label);
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
            echo sprintf('<li><a href="%s" title="%s"%s>%s %s'.colormag_glyph($colormag['glyphs'][$task], true).'</a></li>', wl($ID, array('do' => 'admin','page' => $task)), ucfirst($task), ' class="'.$class.'"', "", ucfirst($label));
        }
    }
    echo '<li class="dropdown-header">'.tpl_getLang('cache').'<hr/></li>';
    echo '<li><a href="'.wl($ID, array("do" => $_GET['do'], "page" => $_GET['page'], "purge" => "true")).'">'.tpl_getLang('purgepagecache').colormag_glyph($colormag['glyphs']["recycle"], true).'</a></li>';
    echo '<li><a href="'.DOKU_URL.'lib/exe/js.php">'.tpl_getLang('purgejscache').colormag_glyph($colormag['glyphs']["refresh"], true).'</a></li>';
    echo '<li><a href="'.DOKU_URL.'lib/exe/css.php">'.tpl_getLang('purgecsscache').colormag_glyph($colormag['glyphs']["refresh"], true).'</a></li>';
}/* colormag_admin */

/**
 * RETURN A DATE
 * 
 * @param string    $type "long" for long date based on 'dateString' setting, "short" for numeric
 * @param integer   $timestamp timestamp to use (null for current server time)
 * @param bool      $clock if true, add hour to the result
 * @param bool      $print if true, print the result instead of returning it
 */
function colormag_date($type = "long", $timestamp = null, $clock = false, $return = false) {
    global $conf;
    $datelocale = tpl_getConf('datelocale');
    if ($datelocale != null) {
        if (strpos($datelocale, ',') !== false) {
            $datelocale = explode(",", $datelocale)[1];
        }
        setlocale(LC_TIME, $datelocale);
    }
    if ($type == "short") {
        $format = tpl_getConf('shortdate');
    } else {
        $format = tpl_getConf('longdate');
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
}

/**
 * PRINT LAST CHANGES LIST
 * 
 * Print an <ul> loaded with @param last changes.
 *
 * @param integer   $n number of last changes to show in the list
 */
function colormag_newsticker($context = null) {
    global $colormag, $conf, $lang;
//dbg($colormag['recents']);

    $mediaPath = str_replace("/pages", "/media", $conf['datadir']);
    if (count($colormag['recents']) > 1) {
        print '<ul class="js-lastchanges">';
    }
    $i = 0;
    foreach ($colormag['recents'] as $key => $value) {
        $details = null;
        if ($value['sum'] != null) {
            //$details = ucfirst(trim($value['sum'], "."));
            $details = ucfirst(trim($value['sum'], "."));
        } else {
            $details = ucfirst(trim(str_replace(":", "", $lang['mail_changed']), chr(0xC2).chr(0xA0)));
        }
        if ($value['date'] != null) {
            $details .= " (".colormag_date("long", $value['date'], false, true).")";
        }
        if ($context == "landing") {
            $details .= ".";
        }
        //print '<li title="'.$value['id'].'">';
        if (count($colormag['recents']) > 1) {
            print '<li title="'.$details.'">';
        } else {
            print '<span title="'.$details.'">';
        }
            if ($value['media']) {
                if (is_file($mediaPath."/".str_replace(":", "/", $value['id']))) {
                    $exist = "wikilink1";
                } else {
                    $exist = "wikilink2";
                }
            } else {
                if (page_exists($value['id'])) {
                    $exist = "wikilink1";
                } else {
                    $exist = "wikilink2";
                }
            }
            if (($context == null) or ($conf['useheading'] == 0) or (p_get_first_heading($value['id']) == null)) {
                $pageName = $value['id'];
            } else {
                $pageName = p_get_first_heading($value['id']);
            }
            if ($value['media']) {
                tpl_link(
                    ml($value['id'],'',false),
                    $pageName,
                    'class="'.$exist.' medialink"'
                );
            } else {
                tpl_link(
                    wl($value['id']),
                    $pageName,
                    'class="'.$exist.'"'
                );
            }
            $by = null;
            if ($value['user'] != null) {
                $by = " ".$lang['by']." ";
            }
            if ($context == null) {
                //print '<span class="display-none xs-display-initial md-display-none wd-display-initial">'.$by.'<span class="text-capitalize"><bdi>'.$value['user'].'</bdi></span></span>';
                print '<span class="display-none xs-display-initial">'.$by.'<span class="text-capitalize"><bdi>'.$value['user'].'</bdi></span></span>';
            }
            $i++;
        if (count($colormag['recents']) > 1) {
            print '</li>';
        } else {
            print '</span>';
        }
    }
    if (count($colormag['recents']) > 1) {
        print '</ul>';
    }
}

/**
 * PRINT HIERARCHICAL BREADCRUMBS, adapted from core (template.php) to use a CSS separator solution and respect existing/non-existing page link colors
 *
 * This code was suggested as replacement for the usual breadcrumbs.
 * It only makes sense with a deep site structure.
 *
 * @return bool
 */
function colormag_youarehere() {
    global $conf, $ID, $lang, $colormag;

    // Youarehere timer start
    $rustart = getrusage();

    // check if enabled
    if(!$conf['youarehere']) return false;

    $parts = explode(':', $ID);
    $count = count($parts);
//dbg($parts);
    // print intermediate namespace links
    $part = '';

    print '<ul>';

    for($i = 0; $i <= $count - 1; $i++) {
//dbg($i);
        $part .= $parts[$i];
        if (!page_exists($part)) {
            $part .= ':';
        }
//dbg($part);
        if ($part == $ID) {
            $page = $part;
        } elseif ($part == "playground:") {
            $page = $part."playground";
        } else {
            $page = $part.$conf['start'];
        }
//dbg($page);

        // We need a page ID for checks, not a namespace ID like "wiki:"
        if (substr($page, -1) == ":") {
            $check = $page.$conf['start'];
        } else {
            $check = $page;
        }

        if ((strpos(tpl_getConf('breadcrumbslook'), 'underlined') !== false) and ($check == $ID)) {
            $liclasses = ' class="curid"';
        }

        if (strpos(tpl_getConf('breadcrumbslook'), 'nscolored') !== false) {

            $color = colormag_color($check, true);
            //if ($color != "#") {
            if ($color) {
                if (tpl_getConf('breadcrumbslook') == 'underlined-nscolored') {
                    $listyle = ' style="border-color:'.$color.'"';
                } elseif (tpl_getConf('breadcrumbslook') == 'pills-nscolored') {
                    $astyle = 'background-color:'.$color;
                }
            }
        }
        print '<li'.$liclasses.$listyle.'>';
            colormag_pagelink($page, $astyle, "breadcrumbs", false);
        print '</li>';
        // stop if we reached current $ID (there's still one element left in $parts with NS start pages)
        if ($page == $ID) {
//dbg("bingo: ".$page);
            break;
        }
    }

    print '</ul>';

    $ru = getrusage();
    if (($_GET['debug'] == 1) or ($_GET['debug'] == 'timers')) {
        $time = rutime($ru, $rustart, "utime");
        if ($time > 100) {
            $alert = -1;
        } elseif ($time > 50) {
            $alert = 2;
        } elseif ($time > 20) {
            $alert = 0;
        } else {
            $alert = 1;
        }
        msg("Youarehere took ".$time."ms to build list and collect colors.", $alert);
    }

}/* /colormag_youarehere */

/**
 * PRINT TRACE BREADCRUMBS, adapted from core (template.php) to use a CSS separator solution and respect existing/non-existing page link colors
 *
 * @return bool
 */
function colormag_trace() {
    global $lang, $conf, $ID;
    global $colormag;

    // Trace timer start
    $rustart = getrusage();

    //check if enabled
    if(!$conf['breadcrumbs']) return false;

    $crumbs = breadcrumbs(); //setup crumb trace

    if (count($crumbs) > 0) {
//dbg($crumbs);
        //render crumbs, highlight the last one
        $last = count($crumbs);
        $i    = 0;

        print '<ul class="flex end wrap">';

        foreach($crumbs as $target => $name) {
            $i++;
            $target = ltrim($target, ":");
//dbg($target);
            if ((strpos(tpl_getConf('breadcrumbslook'), 'underlined') !== false) and ($target == $ID)) {
                $liclasses = ' class="curid"';
            }
            if (strpos(tpl_getConf('breadcrumbslook'), 'nscolored') !== false) {
                $color = colormag_color($target, true);
                //if ($color != "#") {
                if ($color) {
                    if (tpl_getConf('breadcrumbslook') == 'underlined-nscolored') {
                        $listyle = ' style="border-color:'.$color.'"';
                    } elseif (tpl_getConf('breadcrumbslook') == 'pills-nscolored') {
                        //$astyle = ' style="background-color:'.$color.'"';
                        $astyle = "background-color:".$color;
                    }
                }
            }
            print '<li'.$liclasses.$listyle.'>';
                colormag_pagelink($target, $astyle, "breadcrumbs", false);
            print '</li>';
        }

        print '</ul>';

        $ru = getrusage();
        if (($_GET['debug'] == 1) or ($_GET['debug'] == 'timers')) {
            $time = rutime($ru, $rustart, "utime");
            if ($time > 100) {
                $alert = -1;
            } elseif ($time > 50) {
                $alert = 2;
            } elseif ($time > 20) {
                $alert = 0;
            } else {
                $alert = 1;
            }
            msg("Trace took ".$time."ms to build list and collect colors.", $alert);
        }

        return true;
    } else {
        return false;
    }
}/* /colormag_trace */


function colormag_pagelink($target, $style = null, $context = null, $return = false) {
    global $ID, $conf;
    global $colormag;

    if (!$useacl or auth_quickaclcheck($result['ns']) >= AUTH_READ) {

        // LINK STYLE
//dbg($style);
        if ($style != null) {
            $style = ' style="'.$style.'"';
        }
//dbg($style);

        // CLASSES
        if ($target == $ID) {
            $classes = "curid";
            // prevent style color to enable LESS file color
            $style = null;
        }
        if (page_exists($target)) {
            $classes .= " wikilink1";
        } else {
            $classes = " wikilink2";
        }

        // GLYPH
        $glyph = null;
        if (($context == "breadcrumbs") and tpl_getConf("breadcrumbsglyphs")) {
            if (colormag_ishome($target) == "untranslated") {
                $glyph = colormag_glyph($colormag['glyphs']['home'], true);
            } elseif (colormag_ishome($target) == "translated") {
                $glyph = colormag_glyph($colormag['glyphs']['language-home'], true);
            } elseif (strpos($target, $conf['start']) !== false) {
                $glyph = colormag_glyph($colormag['glyphs']['namespace-start'], true);
            } elseif (colormag_istranslated($target)) {
                $glyph = colormag_glyph($colormag['glyphs']['translated'], true);
            }
        }

        // PAGENAME
        // By default, page name will be equal to it's ID
        //$pagename = $target;
        if ($conf['useslash']) {
            $nssep = '[:;/]';
            $basename = explode("/".$conf['start'], $target)[0];
        } else {
            $nssep = '[:;]';
            $basename = explode(":".$conf['start'], $target)[0];
        }
//dbg($pagename);
        $pagename = preg_replace('!.*'.$nssep.'!', '', $basename);
        // If `useheading` DW's setting is enabled for navigation links, try to get that first heading
        if(useHeading('navigation')) {
            $first_heading = p_get_first_heading($target);
            if($first_heading) $pagename = $first_heading;
        }
        // Croissant plugin
        if ((($context == "breadcrumbs") || ($context == "lastchanges") || ($context == "pagenav")) && (p_get_metadata($target, 'plugin_croissant_bctitle') != null)) {
          $pagename = p_get_metadata($target, 'plugin_croissant_bctitle');
        }

        $link = tpl_link(
            wl($target),
            $glyph.$pagename,
            'class="'.ltrim($classes, " ").'" title="'.$target.'"'.$style,
            true
        );
        
        if ($return) {
            return $link;
        } else {
            print $link;
            return 1;
        }
    } else {
        return false;
    }
}

/**
 * adapted from core
 *
 * See original function in inc/template.php for details
 */
function colormag_searchform($ajax = true, $autocomplete = true, $dw = false) {
    global $colormag;
    global $lang, $ACT, $QUERY;

    // don't print the search form if search action has been disabled
    if(!actionOK('search')) return false;

//                            <form action="http://demo.themegrill.com/colormag/" class="search-form searchform clearfix" method="get">
//                                <div class="search-wrap">
//                                    <input type="text" placeholder="Search" class="s field" name="s">
//                                    <button class="search-icon" type="submit"></button>
//                                </div>
//                            </form><!-- .searchform -->


    print '<form id="search-form" action="'.wl().'" accept-charset="utf-8" class="search searchform clearfix';
//    if ($dw) { print ' dw'; }
//    print '" method="get" role="search"><div class="no">';
    print '" method="get" role="search"><div class="no">';
//    print '<div class="search-wrap">';
    print '<input type="hidden" name="do" value="search" />';
    print '<input type="text" ';

//    print '<form action="'.wl().'" accept-charset="utf-8" class="form-inline search" id="dw__search" method="get" role="search"><div class="no">';
//    print '<input type="hidden" name="do" value="search" />';
//    print '<input type="text" ';
    if($ACT == 'search') print 'value="'.htmlspecialchars($QUERY).'" ';
//    print 'placeholder="&#xF002; '.$lang['btn_search'].'" ';
    print 'placeholder="'.$lang['btn_search'].'" ';
    if(!$autocomplete) print 'autocomplete="off" ';
    print 'id="qsearch__in" accesskey="f" name="id" class="s field" title="[F]" />';
    if (!$dw) {
        print '<button type="submit" title="'.$lang['btn_search'].'">'.colormag_glyph($colormag['glyphs']['search'], true).'</button>';
    }
//    print '</div>';
//  REMOVED JSpopup class because when used, quick search result doesn't show up ("Found pages"). Original line: if ($ajax) print '<div id="qsearch__out" class="panel panel-default ajax_qsearch JSpopup"></div>';
    if ($ajax) print '<div id="qsearch__out" class="panel panel-default ajax_qsearch"></div>';
    print '</div></form>';
    return true;
}/* /colormag_searchform */

function colormag_social_link($network = null) {
    global $conf, $colormag;
//dbg($network);

//    // If there's a social network name and current wiki url is not included in given social network url
////dbg($colormag['socials'][$network]." vs ".trim(DOKU_URL, "/"));
//    if (($network != null) and (strpos($colormag['socials'][$network], trim(DOKU_URL, "/")) === false)) {
    if ($network != null) {
        $target = $conf['target']['extern'];
//dbg($colormag['socials'][$network]);
        $result = '<li><a href="'.$colormag['socials'][$network].'" class="social '.$network.' flex row"';
        if ($target != null) { $result .= ' target="'.$target.'"'; }
        if (($network == "digg") or ($network == "dribbble") or ($network == "facebook") or ($network == "flickr") or ($network == "reddit")) {
            $tooltip = $network;
        } elseif ($network == "codepen") {
            $tooltip = "CodePen";
        } elseif ($network == "github") {
            $tooltip = "GitHub";
        } elseif ($network == "google-plus") {
            $tooltip = "Google+";
        } elseif ($network == "stumbleupon") {
            $tooltip = "StumbleUpon";
        } elseif ($network == "wordpress") {
            $tooltip = "WordPress";
        } elseif ($network == "youtube") {
            $tooltip = "YouTube";
        } else {
            $tooltip = ucwords(str_replace("_", " ", $network));
        }
        if ($tooltip != null) { $result .= ' title="'.$tooltip.'"'; }
        $result .= ' rel="nofollow">';
//dbg($colormag['glyphs'][$network]);
//dbg($colormag['glyphs']['default']);
        //if (($colormag['glyphs'][$network] != null) and ($colormag['glyphs'][$network] != $colormag['glyphs']['default'])) {
        //    $result .= $colormag['glyphs'][$network];
        //} else {
        //    $result .= $tooltip;
        //}
//dbg($network);
//dbg($colormag['glyphs'][$network]);
//dbg(colormag_glyph($colormag['glyphs'][$network], true));
        $result .= colormag_glyph($colormag['glyphs'][$network], true);
        if (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) {
            $class = "";
        } else {
            $class=' class="a11y"';
        }
        $result .= '<span'.$class.'>'.$tooltip.'</span>';
        $result .= '</a></li>';
//dbg($result);
        if ($return) {
            return $result;
        } else {
            print $result;
            return 1;
        }
    }
}

/**
 * Adapted from tpl_pageinfo() core function
 *
 * Print some info about the current page
 *
 * @param bool $ret return content instead of printing it
 * @return bool|string
 */
function colormag_docinfo() {
    global $conf, $lang, $INFO, $ID;
    global $colormag;

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
//dbg($fn);
    $date = dformat($INFO['lastmod']);
    $date = colormag_date("short", $INFO['lastmod'], true, true);
    // print it
    //if($INFO['exists']) {
        $out = '';
//print "<img class='qrcode' src='".$colormag['qrcode']['id']."' alt='*this page*' />";
        if($INFO['editor']) {
            $out .= '<div title="'.tpl_getLang('lasteditor').'" class="flex">'.colormag_glyph($colormag['glyphs']['editor'], true);
            if ((isset($colormag['qrcode']['editor'])) and ($colormag['qrcode']['editor'] != null)) {
                $out .= "<img class='qrcode editor' src='".$colormag['qrcode']['editor']."' alt='*qrcode*' title='".tpl_getLang('lasteditor')."' />";
            }
            $out .= '<bdi>'.ucfirst(editorinfo($INFO['editor'])).'</bdi>';
        } else {
            $out .= '<div class="editor svgonly" title="'.ucfirst($lang['external_edit']).'">'.colormag_glyph($colormag['glyphs']['externaleditor'], true);
            //$out .= '['.$lang['external_edit'].']';
        }
        $out .= '</div>';
        $out .= '<div title="'.explode(':',$lang['lastmod'])[0].'" class="flex">'.colormag_glyph($colormag['glyphs']['lastmod'], true).$date.'</div>';
        if($INFO['locked']) {
            $out .= '<div title="'.$lang['lockedby'].'" class="locked">'.colormag_glyph($colormag['glyphs']['locked'], true);
            if ((isset($colormag['qrcode']['locked'])) and ($colormag['qrcode']['locked'] != null)) {
                $out .= "<img class='qrcode locked' src='".$colormag['qrcode']['locked']."' alt='*qrcode*' title='".$lang['lockedby']."' />";
            }
            $out .= '<bdi>'.ucfirst(editorinfo($INFO['locked'])).'</bdi>';
            $out .= '</div>';
        }
        $out .= '<div title="'.tpl_getLang('pagepath').'" class="flex">'.colormag_glyph($colormag['glyphs']['pagepath'], true);
        $out .= '<bdi>'.$fn.'</bdi></div>';

        return $out;
    //}
    return false;
}

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
function colormag_css_applystyle($css, $replacements) {
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
}

/**
 * Tell if given page is home (default, translated or untranslated) or not
 *
 * @param string $page
 * @return string or false
 */
function colormag_ishome($page) {
    global $conf;
    global $colormag;

//dbg($colormag['translation']['untranslatedhome']);
//dbg($page);
    // Default or untranslated wiki home ?
    if ($page == $conf['start']) {
        $ishome = "default";
    } elseif ($page == $colormag['translation']['untranslatedhome']) {
        $ishome = "untranslated";
    } elseif ($colormag['translation']['helper']) {
        $parts = $colormag['translation']['helper']->getTransParts($page);
        if (($parts[1] == $conf['start']) and (($parts[0] != "") and (strpos($conf['plugin']['translation']['translations'], $parts[0]) !== false))) {
            $ishome = "translated";
        }
    } else {
        $ishome = false;
    }
    return $ishome;
}

/**
 * Tell if given page is translated or not (ie. is in translated ns)
 *
 * @param string $page
 */
function colormag_istranslated($page) {
    global $conf;
    global $colormag;

//dbg($page);
    // Default or untranslated wiki home ?
    if ($colormag['translation']['helper']) {
        $parts = $colormag['translation']['helper']->getTransParts($page);
        if (($parts[0]) and ($parts[0] != $conf['lang']) and (strpos($conf['plugin']['translation']['translations'], $parts[0]) !== false)) {
            return true;
        }
    } else {
        return false;
    }
    return false;
}

function colormag_color($target, $inherit = false) {
    global $ID, $colormag, $INFO;
    $result = false;

    if (colormag_ishome($target)) {
//dbg("ici");
//dbg($colormag['initial_theme_color']);
        $result = $colormag['initial_theme_color'];
//dbg($result);
    } else {
//dbg("là");
        $themeinifile = colormag_inherit("theme.ini", "conf", $target);
        if (is_file($themeinifile['src'])) {
            $themeini = parse_ini_file($themeinifile['src'], true);
            $result = $themeini['replacements']['__theme_color__'];
        } elseif (tpl_getConf('autotheme') == 'pageid') {
            $result = "#".substr(md5(getNS($target)), 6, 6);
        } else {
            if ((getNS($target) == getNS($ID)) and (isset($colormag['images'][tpl_getConf('autotheme')]['path']))) {
                $image = @imagecreatefromstring(file_get_contents($colormag['images'][tpl_getConf('autotheme')]['path']));
            } elseif ($inherit) {
                $targetimage = colormag_inherit(tpl_getConf('autotheme'), "media", $target);
                if (isset($targetimage['path'])) {
                    $image = @imagecreatefromstring(file_get_contents($targetimage['path']));
                }
            }
            if ($image) {
                $thumb = imagecreatetruecolor(1,1);
                imagecopyresampled($thumb,$image,0,0,0,0,1,1,imagesx($image),imagesy($image));
                $result = "#".strtoupper(dechex(imagecolorat($thumb,0,0)));
            } else {
                return false;
            }
        }
    }
    return $result;
}

//function colormag_palette($imageFile, $size, $numColors, $granularity = 5) 
//{ 
//   $granularity = max(1, abs((int)$granularity)); 
//   $colors = array(); 
//   ///$size = @getimagesize($imageFile); 
//   if($size === false) 
//   { 
//      user_error("Unable to get image size data"); 
//      return false; 
//   } 
//   //$img = @imagecreatefromjpeg($imageFile);
//   $img = @imagecreatefromstring(file_get_contents($imageFile));
//   // Andres mentioned in the comments the above line only loads jpegs, 
//   // and suggests that to load any file type you can use this:
//   // $img = @imagecreatefromstring(file_get_contents($imageFile));// 
//   if(!$img) 
//   { 
//      user_error("Unable to open image file"); 
//      return false; 
//   } 
//   for($x = 0; $x < $size[0]; $x += $granularity) 
//   { 
//      for($y = 0; $y < $size[1]; $y += $granularity) 
//      { 
//         $thisColor = imagecolorat($img, $x, $y); 
//         $rgb = imagecolorsforindex($img, $thisColor); 
//         $red = round(round(($rgb['red'] / 0x33)) * 0x33); 
//         $green = round(round(($rgb['green'] / 0x33)) * 0x33); 
//         $blue = round(round(($rgb['blue'] / 0x33)) * 0x33); 
//         $thisRGB = sprintf('%02X%02X%02X', $red, $green, $blue); 
//         if(array_key_exists($thisRGB, $colors)) 
//         { 
//            $colors[$thisRGB]++; 
//         } 
//         else 
//         { 
//            $colors[$thisRGB] = 1; 
//         } 
//      } 
//   } 
//   arsort($colors); 
//dbg($colors);
//   return array_slice(array_keys($colors), 0, $numColors); 
//} 

/* TIMER FUNCTION
 *
 * See here : https://stackoverflow.com/questions/10290259/detect-main-colors-in-an-image-with-php
 */
function rutime($ru, $rus, $index) {
    return ($ru["ru_$index.tv_sec"]*1000 + intval($ru["ru_$index.tv_usec"]/1000))
     -  ($rus["ru_$index.tv_sec"]*1000 + intval($rus["ru_$index.tv_usec"]/1000));
}

function colormag_ui_image($type) {
    global $conf, $ID;
    global $colormag;

    if (($colormag['images'][$type]['src'] != null) and ($ACT != "edit") and ($ACT != "preview")) {
        $title = null;
        if ((tpl_getConf('uiimagetarget') == 'home') or (strpos($colormag['images'][$type]['ns'], 'wiki') !== false)) {
            $target = wl($conf['start']);
            $title = tpl_getLang('wikihome');
        } elseif (tpl_getConf('uiimagetarget') == 'image-ns') {
            $target = wl($colormag['images'][$type]['ns']);
            $title = $colormag['images'][$type]['ns'];
        } elseif (tpl_getConf('uiimagetarget') == 'current-ns') {
            $target = wl(getNS($ID).":".$conf['start']);
            $title = getNS($ID).":".$conf['start'];
        } elseif (tpl_getConf('uiimagetarget') == 'image-details') {
            $target = "lib/exe/detail.php?id=".$ID."&".explode("php?", $colormag['images'][$type]['src'])[1];
            $title = explode("php?", $colormag['images']['banner']['src'])[1];
        } else {
            $target = null;
        }
        if ($title == null) { $title = $target; }
        if (($colormag['images'][$type]['ns'] != null) and ($target != null)) {
            if ($type != 'sidecard') {
                $style = ' style="max-width:'.$colormag['images'][$type]['size'][0].'px"';
            }
            tpl_link(
                $target,
                '<img src="'.$colormag['images'][$type]['src'].'" title="'.$title.'" alt="*'.$type.'*" '.$colormag['images'][$type]['size'][3].$style.'/>'
            );
        } else {
            print '<img src="'.$colormag['images'][$type]['src'].'" alt="*'.$title.'*" '.$colormag['images'][$type]['size'][3].' class="mediacenter" />';
        }
    }
}