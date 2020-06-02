<?php
/**
 * Dokuwiki Namespaced template
 *
 * @link    https://www.dokuwiki.org/template:namespaced
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
function namespaced_init() {
    global $ID;
    global $namespaced;

    // Enable default search untill it's proven useless
    $namespaced['defaultsearch'] = true;

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
        //$namespaced['widgets'][$area] = array_filter($namespaced['widgets'][$area]);
        if (is_array($namespaced['widgets'][$area]) and (count($namespaced['widgets'][$area]) > 0)) {
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
                    $target = namespaced_inherit($widget, $type, $ID, true, $propagate);
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
                    // Localized title for "about Namespaced" widget
                    if ($title == "About Namespaced") {
                        $namespaced['widgets'][$area][$widget]['title'] = tpl_getLang("about_namespaced");
                    // ignore title for Sidecard, Search and Sidebar
                    } elseif (($title != "Sidecard") and ($title != "Search") and ($title != "Sidebar")) {
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
//dbg($namespaced['widgets']);

    // Adding test alerts if debug is enabled
    if (($_GET['debug'] == 1) or ($_GET['debug'] == "alerts")) {
        msg("This is an error [-1] alert with a <a href='#'>dummy link</a>", -1);
        msg("This is an info [0] message with a <a href='#'>dummy link</a>", 0);
        msg("This is a success [1] message with a <a href='#'>dummy link</a>", 1);
        msg("This is a notification [2] with a <a href='#'>dummy link</a>", 2);
    }
}

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
//$namespaced['widgets'][$area][$widget]['title'] = $title;
//$namespaced['widgets'][$area][$widget]['type'] = $type;
//$namespaced['widgets'][$area][$widget]['target'] = $target;
//dbg($data);
//dbg($data['target']);
        $widgetid = "namespaced__widget_".str_replace(".html", "", str_replace(":", "_", ltrim($widget, ":")));
        print '<aside id="'.$widgetid.'"class="widget">';
            if (isset($data['title'])) {
                print '<h6 class="widget-title"><span>'.$data['title'].'</span></h6>';
            }
            //print $data['target'];
            if ($data['type'] == "media") {
                print '<img src="'.$data['target']['src'].'" alt="*'.$data['target']['title'].'*" '.$data['target']['size'][3].' class="mediacenter" />';
            } elseif ($data['type'] == "include") {
                tpl_includeFile($widget);
            } else {
                //tpl_include_page($data['target'], true, false, true);
                //print p_wiki_xhtml($data['target'], '', false);
                //print p_render('xhtml',p_get_instructions(io_readWikiPage($data['target'],$id,$rev)),$info,$date_at);
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
}
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
}
