<?php
/**
 * Dokuwiki Namespaced template
 *
 * @link    https://www.dokuwiki.org/template:namespaced
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 *
 * An experimental polymorphic and responsive DokuWiki template based on flexbox with many namespace related features
 * Based on DokuWiki default template by Anika Henke <anika@selfthinker.org> and Clarence Lee <clarencedglee@gmail.com>
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/namespaced.php'); /* include hook for template functions */

session_start();
// Store ID from HTTP_REFERER (aka origin URL) into PHP Session if it contains current wiki URL and doesn't contain `admin` or `playground` 
if ((strpos($_SERVER["HTTP_REFERER"], DOKU_URL) !== false) and (strpos($_SERVER["HTTP_REFERER"], 'admin') === false) and (strpos($_SERVER["HTTP_REFERER"], 'playground') === false)) {
    // get what's after "id="
    $tmp = explode("id=", $_SERVER["HTTP_REFERER"]);
    // get what's before potential "&"
    $tmp = explode("&", $tmp[1]);
    // store in PHP session
    $_SESSION["origID"] = $tmp[0];
}


global $namespaced, $external;
// Reset $namespaced to make sure we don't inherit any value from previous page
$namespaced = array();
namespaced_init();
$external = ($conf['target']['extern']) ? ' target="'.$conf['target']['extern'].'"' : '';

?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo (($_GET['dir'] <> null)) ? $_GET['dir'] : $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <style type="text/css">
        <?php
            if (isset($namespaced['theme'])) {
                echo $namespaced['theme'];
            }
        ?>
    </style>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body id="dokuwiki__top" class="<?php print namespaced_bodyclasses() ?>">
    <div id="screen__mode" class="dbg"><span>MediaQ : </span></div>
    <a class="skip center<?php print $namespaced['a11y']['extraclass'] ?>" href="#namespaced__content"><?php echo $lang['skip_to_content'] ?></a>
    <div id="namespaced__site" class="site <?php echo tpl_classes() ?> <?php echo ($showSidebar) ? 'showSidebar' : '' ?> <?php echo ($hasSidebar) ? 'hasSidebar' : '' ?>">

        <?php include('header.php') ?>

        <div id="namespaced__site_nav_labels" class="pad flex justify-between">
            <h6<?php print $namespaced['a11y']['standalone'] ?>><?php echo tpl_getLang('ns_content') ?></h6>
            <h6<?php print $namespaced['a11y']['standalone'] ?>><?php echo $lang['user_tools'] ?></h6>
        </div>
        <nav id="namespaced__site_nav" class="flex navbar pad<?php print (strpos(tpl_getConf('stickies'), 'navbar') !== false) ? ' sticky' : '' ?>">
            <div id="namespaced_ns_menu">
                <ul class="nostyle">
                    <!-- NAMESPACE CONTENT -->
                    <?php //namespaced_nsindex(true) ?>
                    <?php
                        // Print pages links
                        if (count($namespaced['nsindex']['pages']) != 0) {
                            foreach ($namespaced['nsindex']['pages'] as $key => $value) {
                                //print $key."ici - ";
                                print '<li>'.$namespaced['nsindex']['pages'][$key]['link'].'</li>';
                                
                            }
                        } else {
                            print '<li class="menu-item action no-pages" title="'.tpl_getLang("no_pages").'">'.namespaced_glyph('info', true).'<span'.$namespaced['a11y']['standalone'].'>'.tpl_getLang("no_pages").'</span></li>';
                        }
                        // Print sub-namespaces links
                        if (count($namespaced['nsindex']['subns']) != 0) {
                            foreach ($namespaced['nsindex']['subns'] as $key => $value) {
                                print '<li>'.$namespaced['nsindex']['subns'][$key]['link'].'</li>';
                            }
                        }
                    ?>
                </ul>
            </div>
            <!-- USER TOOLS -->
            <?php if ($conf['useacl']): ?>
                <div id="namespaced__usertools">
                    <ul class="nostyle">
                        <?php
                            namespaced_usertools();
                        ?>
                    </ul>
                </div>
            <?php endif ?>
        </nav>

        <?php if($ACT == "show"): ?>
            <div id="namespaced__widebanner_wrap" class="group<?php print (strpos(tpl_getConf('print'), 'widebanner') !== false) ? '' : ' noprint' ?>">
                <?php
                    namespaced_ui_image('widebanner');
                ?>
            </div><!-- #namespaced__widebanner_wrap -->
        <?php endif ?>

        <nav id="namespaced__page_nav" class="flex between gap20 <?php print tpl_getConf('pagenavstyle') ?><?php print (strpos(tpl_getConf('neutralize'), 'pagenav') !== false) ? ' neu' : '' ?><?php print (strpos(tpl_getConf('stickies'), 'pagenav') !== false) ? ' sticky' : '' ?><?php print (strpos(tpl_getConf('stickies'), 'navbar') !== false) ? ' stickynav' : '' ?>">
                <div class="flex column align-start">
                    <div class="pageId h6">
                        <span><?php echo hsc($ID) ?></span>
                    </div>
                    <?php
                        if ((tpl_getConf('docinfopos') == "pagenav") and (strpos(tpl_getConf('stickies'), 'docinfo') === false)) {
                            namespaced_docinfo();
                            print '</div>';
                            print '<div class="flex column align-end">';
                            $closed = true;
                        }
                    ?>
                    <!-- TRANSLATIONS -->
                    <?php
                        if (!($conf['breadcrumbs'] and $conf['youarehere'])) {
                            print '</div>';
                            print '<div class="flex column align-end">';
                            $closed = true;
                        }
                        if ($namespaced['translation']['helper']) {
                            print '<nav id="namespaced__translations">';
                                print $namespaced['translation']['helper']->showTranslations();
                            print '</nav>';
                        }
                        if ($closed != true) {
                            print '</div>';
                            print '<div class="flex column align-end">';
                        }
                    ?>
                    <!-- BREADCRUMBS -->
                    <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
                        <nav class="breadcrumbs flex column end align-stretch">
                            <?php if($conf['youarehere']): ?>
                                <div class="youarehere"><?php tpl_youarehere() ?></div>
                            <?php endif ?>
                            <?php if($conf['breadcrumbs']): ?>
                                <div class="trace"><?php tpl_breadcrumbs() ?></div>
                            <?php endif ?>
                        </nav>
                    <?php endif ?>
                </div>
        </nav>

        <main class="flex nowrap align-stretch">

            <!-- CONTEXT TOOLS -->
            <aside id="namespaced__contools" class="gutter flex column">
                <nav class="tools<?php print (strpos(tpl_getConf('uicolorize'), 'contools') !== false) ? " uicolor-contools" : "" ?><?php print (strpos(tpl_getConf('stickies'), 'navbar') !== false) ? ' stickynav' : '' ?>">
                    <ul class="nostyle">
                        <li><h6 class="aside-title<?php print $namespaced['a11y']['extraclass'] ?>"><?php print tpl_getLang('context_tools') ?></h6></li>
                        <?php namespaced_contools() ?>
                    </ul>
                </nav><!-- /.tools -->
            </aside><!-- /#namespaced__contools -->

            <div id="namespaced__main_subflex" class="flex nowrap align-stretch">

                <?php //if($showSidebar): ?>
                <?php if(($ACT=='show') && (@count($namespaced['widgets']['side']) > 0)): ?>
                    <!-- ********** ASIDE ********** -->
                    <aside id="namespaced__aside">
                        <div class="aside include<?php print (strpos(tpl_getConf('stickies'), 'sidebar') !== false) ? ' sticky' : '' ?><?php print (strpos(tpl_getConf('stickies'), 'navbar') !== false) ? ' stickynav' : '' ?><?php print (strpos(tpl_getConf('stickies'), 'pagenav') !== false) ? ' stickypagenav' : '' ?>">
                            <h6 class="toggle"><?php echo $lang['sidebar'] ?></h6>
                            <div class="content">
                                <?php tpl_flush() ?>
                                <?php tpl_includeFile('sidebarheader.html') ?>
                                <?php //tpl_include_page($conf['sidebar'], true, true) ?>
                                <?php namespaced_widgets('side') ?>
                                <?php tpl_includeFile('sidebarfooter.html') ?>
                            </div>
                        </div>
                    </aside><!-- /aside -->
                    <!-- <hr class="vertical<?php //print $namespaced['a11y']['extraclass'] ?>" /> -->
                <?php endif ?>

                <!-- ********** CONTENT ********** -->
                <article id="namespaced__content">

                    <div class="flex column align-stretch">

                        <?php
                            html_msgarea();
                            // Namespaced messages
                            // if in playground...
                            if (strpos($ID, 'playground') !== false) {
                                // ...and admin, show a link to managing page...
                                if ($INFO['isadmin']) {
                                    msg(tpl_getLang('playground_admin'), 2);
                                // ...else, show a few hints on what it's for
                                } else {
                                    msg(tpl_getLang('playground_user'), 0);
                                }
                            // if at settings page
                            } elseif (($ACT == "admin") && ($_GET['page'] == "config")) {
                                msg(tpl_getLang('jump_to_namespaced'), 2);
                            }
                            // Display Translation plugin alerts
                            if ($namespaced['translation']['helper']) {
                                print $namespaced['translation']['helper']->checkage();
                            }
                        ?>

                        <div class="page">
                            <?php tpl_flush() ?>
                            <?php tpl_includeFile('pageheader.html') ?>
                            <!-- <hr<?php //print $namespaced['a11y']['standalone'] ?> /> -->
                            <!-- wikipage start -->
                            <?php tpl_content() ?>
                            <!-- wikipage stop -->
                            <!-- <hr<?php //print $namespaced['a11y']['standalone'] ?> /> -->
                            <?php tpl_includeFile('pagefooter.html') ?>
                        </div>

                        <?php tpl_flush() ?>
                    </div>

                </article><!-- /content -->

            </div><!-- /wrapper -->

            <!-- PAGE TOOLS -->
            <aside id="namespaced__pagetools" class="gutter flex column">
                <nav class="tools<?php print (strpos(tpl_getConf('uicolorize'), 'pagetools') !== false) ? " uicolor-pagetools" : "" ?><?php print (strpos(tpl_getConf('stickies'), 'navbar') !== false) ? ' stickynav' : '' ?>">
                    <ul class="nostyle">
                        <li><h6 class="aside-title<?php print $namespaced['a11y']['extraclass'] ?>"><?php print $lang['page_tools'] ?></h6></li>
                        <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems() ?>
                        <li class="bottom"><a href="#namespaced__footer" title="<?php print tpl_getLang('go_to_bottom') ?> [b]" rel="nofollow" accesskey="b"><span><?php print tpl_getLang('go_to_bottom') ?></span><?php namespaced_glyph('bottom') ?></svg></a></li>
                    </ul>
                </nav><!-- /.tools -->
            </aside><!-- /#namespaced__pagetools -->

        </main>

        <?php
            if ((tpl_getConf('docinfopos') === "standalone") or (strpos(tpl_getConf('stickies'), 'docinfo') !== false)) {
                $classes = tpl_getConf("docinfostyle");
                if (strpos(tpl_getConf('stickies'), 'docinfo') !== false) {
                    $classes .= " sticky";
                }
                if (strpos(tpl_getConf('neutralize'), 'docinfo') !== false) {
                    $classes .= " neu";
                }
                print '<aside id="namespaced__docinfo" class="'.ltrim($classes, " ").'">';
                    namespaced_docinfo();
                print '</aside>';
            }
        ?>

        <?php include('footer.php') ?>

    </div><!-- /site -->

    <div id="namespaced__housekeeper" class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>
</body>
</html>
