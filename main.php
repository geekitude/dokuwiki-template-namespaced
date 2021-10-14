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

        <main class="flex nowrap align-stretch">

            <!-- CONTEXT TOOLS -->
            <aside id="namespaced__contools" class="gutter flex column">
                <nav class="tools<?php print (strpos(tpl_getConf('uicolorize'), 'pagetools') !== false) ? " uicolor-pagetools" : "" ?>">
                    <ul class="nostyle">
                        <li><h6 class="aside-title<?php print $namespaced['a11y']['extraclass'] ?>"><?php print tpl_getLang('context_tools') ?></h6></li>
                        <!-- NAV BUTTON(S) -->
                        <?php
                            if (tpl_getConf('combonav')) {
                                if ((strpos(tpl_getConf('navbuttons'), 'back-to-article') !== false) and ((($ACT == "recent") or ($ACT == "media") or ($ACT == "index") or ($ACT == "admin") or (strpos($ID, 'playground:') === 0)) and (isset($_SESSION["origID"])))) {
                                    print '<li>';
                                        // display link to namespace home page
                                        tpl_link(
                                            wl($_SESSION["origID"]),
                                            namespaced_glyph('back-to-article', true).'<span>'.tpl_getLang('back-to-article').'</span>',
                                            'title="'.$_SESSION["origID"].'" rel="nofollow"'
                                        );
                                    print '</li>';
                                } elseif ((strpos(tpl_getConf('navbuttons'), 'nshome') !== false) and ($namespaced['ishome'] == false)) {
                                    print '<li>';
                                        // display link to namespace home page
                                        tpl_link(
                                            wl(getns($ID).':'.$conf['start']),
                                            namespaced_glyph('nshome', true).'<span>'.tpl_getLang('nshome').'</span>',
                                            'title="'.tpl_getLang('nshome').'" rel="nofollow"'
                                        );
                                    print '</li>';
                                } elseif ((strpos(tpl_getConf('navbuttons'), 'parentns') !== false) and (getns(getns($ID)) != null)) {
                                    print '<li>';
                                        // display link to parent namespace home page
                                        tpl_link(
                                            wl(getns(getns($ID)).':'.$conf['start']),
                                            namespaced_glyph('parentns', true).'<span>'.tpl_getLang('parentns').'</span>',
                                            'title="'.tpl_getLang('parentns').'" rel="nofollow"'
                                        );
                                    print '</li>';
                                } elseif ((strpos(tpl_getConf('navbuttons'), 'wikihome') !== false) and (!in_array($namespaced['ishome'], array("default", "untranslated", "translated")))) {
                                    print '<li>';
                                        // display link to the home page
                                        tpl_link(
                                            wl(),
                                            namespaced_glyph('home', true).'<span>'.tpl_getLang('wikihome').'</span>',
                                            'accesskey="h" title="'.tpl_getLang('wikihome').' [H]" rel="nofollow"'
                                        );
                                    print '</li>';
                                }
                            } else {
                                if ((strpos(tpl_getConf('navbuttons'), 'wikihome') !== false) and (!in_array($namespaced['ishome'], array("default", "untranslated", "translated")))) {
                                    print '<li>';
                                        // display link to the home page
                                        tpl_link(
                                            wl(),
                                            namespaced_glyph('home', true).'<span>'.tpl_getLang('wikihome').'</span>',
                                            'accesskey="h" title="'.tpl_getLang('wikihome').' [H]" rel="nofollow"'
                                        );
                                    print '</li>';
                                }
                                //if ((strpos(tpl_getConf('navbuttons'), 'parentns') !== false) and (($namespaced['ishome'] == "nshome") and (getns(getns($ID)) != null))) {
                                if ((strpos(tpl_getConf('navbuttons'), 'parentns') !== false) and (getns(getns($ID)) != null)) {
                                    print '<li>';
                                        // display link to parent namespace home page
                                        tpl_link(
                                            wl(getns(getns($ID)).':'.$conf['start']),
                                            namespaced_glyph('parentns', true).'<span>'.tpl_getLang('parentns').'</span>',
                                            'title="'.tpl_getLang('parentns').'" rel="nofollow"'
                                        );
                                    print '</li>';
                                }
                                if ((strpos(tpl_getConf('navbuttons'), 'nshome') !== false) and ($namespaced['ishome'] == false)) {
                                    print '<li>';
                                        // display link to namespace home page
                                        tpl_link(
                                            wl(getns($ID).':'.$conf['start']),
                                            namespaced_glyph('nshome', true).'<span>'.tpl_getLang('nshome').'</span>',
                                            'title="'.tpl_getLang('nshome').'" rel="nofollow"'
                                        );
                                    print '</li>';
                                }
                                if ((strpos(tpl_getConf('navbuttons'), 'back-to-article') !== false) and ((($ACT == "recent") or ($ACT == "media") or ($ACT == "index") or ($ACT == "admin")) and (isset($_SESSION["origID"])))) {
                                    print '<li>';
                                        // display link to namespace home page
                                        tpl_link(
                                            wl($_SESSION["origID"]),
                                            namespaced_glyph('back-to-article', true).'<span>'.tpl_getLang('back-to-article').'</span>',
                                            'title="'.$_SESSION["origID"].'" rel="nofollow"'
                                        );
                                    print '</li>';
                                }
                            }
                            // Playground
                            if ((strpos(tpl_getConf('extratools'), 'playground') !== false) and (strpos($ID, 'playground:') !== 0)){
                                print '<li class="action playground"><a href="/doku.php?id=playground:playground&amp;do=edit" rel="nofollow" title="playground:playground">'.namespaced_glyph('playground', true).'<span>'.tpl_getLang('playground').'</span></a></li>';
                            }
                            // Save settings
                            if((strpos(tpl_getConf('extratools'), 'save') !== false) && ($INFO['isadmin'] || $INFO['ismanager']) && ($_GET['do'] == "admin") && ($_GET['page'] == "config")) {
                                print '<li class="action savesettings"><button class="flex" type="submit" form="dw__configform" value="submit" title="'.$lang['btn_save'].' [s]">'.namespaced_glyph('save', true).'<span>'.$lang['btn_save'].'</span></button></li>';
                            }
                            // Reset settings
                            if((strpos(tpl_getConf('extratools'), 'reset') !== false) && ($INFO['isadmin'] || $INFO['ismanager']) && ($_GET['do'] == "admin") && ($_GET['page'] == "config")) {
                                print '<li class="action resetsettings"><button class="flex" type="reset" form="dw__configform" value="reset" title="'.$lang['btn_reset'].'">'.namespaced_glyph('reset', true).'<span>'.$lang['btn_reset'].'</span></button></li>';
                            }
                        ?>
                        <?php if($ACT=='edit'): ?>
                            <li class="syntax"><a href="/doku.php?id=wiki:syntax" title="<?php print tpl_getLang('syntax') ?>" rel="nofollow"><?php namespaced_glyph('syntax') ?><span><?php print tpl_getLang('syntax') ?></span></a></li>
                        <?php endif ?>
                    </ul>
                </nav><!-- /.tools -->
            </aside><!-- /#dokuwiki__pagetools -->

            <div id="namespaced__main_subflex" class="flex nowrap align-stretch">

                <?php //if($showSidebar): ?>
                <?php if(($ACT=='show') && (@count($namespaced['widgets']['side']) > 0)): ?>
                    <!-- ********** ASIDE ********** -->
                    <div id="namespaced__aside">
                        <div class="aside include">
                            <h6 class="toggle"><?php echo $lang['sidebar'] ?></h6>
                            <div class="content">
                                <?php tpl_flush() ?>
                                <?php tpl_includeFile('sidebarheader.html') ?>
                                <?php //tpl_include_page($conf['sidebar'], true, true) ?>
                                <?php namespaced_widgets('side') ?>
                                <?php tpl_includeFile('sidebarfooter.html') ?>
                            </div>
                        </div>
                    </div><!-- /aside -->
                    <hr class="vertical<?php print $namespaced['a11y']['extraclass'] ?>" />
                <?php endif ?>

                <!-- ********** CONTENT ********** -->
                <article id="namespaced__content">

                    <div class="flex column align-stretch">

                        <?php
                            html_msgarea();
                            // If in playground...
                            if (strpos($ID, 'playground') !== false) {
                                // ...and admin, show a link to managing page...
                                if ($INFO['isadmin']) {
                                    msg(tpl_getLang('playground_admin'), 2);
                                // ...else, show a few hints on what it's for
                                } else {
                                    msg(tpl_getLang('playground_user'), 0);
                                }
                            }
                        ?>

                        <nav class="flex">
                            <aside id="namespaced__page_nav" class="flex between">
                                <div class="flex column align-start">
                                    <div class="pageId h6">
                                        <span><?php echo hsc($ID) ?></span>
                                    </div>
                                    <!-- TRANSLATIONS -->
                                    <?php if(true): ?>
                                        <nav id="namespaced__translations">
                                            <span class="dbg">*Translations*</span>
                                        </nav>
                                    <?php endif ?>
                                </div>
                                <div class="flex column align-end">
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
                                    <?php
                                        if (tpl_getConf('docinfopos') == "pagenav") {
                                            print '<div class="docInfo">';
                                            tpl_pageinfo();
                                            print '</div>';
                                        }
                                    ?>
                                </div>
                            </aside>
                        </nav>

                        <div class="page">
                            <?php tpl_flush() ?>
                            <?php tpl_includeFile('pageheader.html') ?>
                            <hr<?php print $namespaced['a11y']['standalone'] ?> />
                            <!-- wikipage start -->
                            <?php tpl_content() ?>
                            <!-- wikipage stop -->
                            <hr<?php print $namespaced['a11y']['standalone'] ?> />
                            <?php tpl_includeFile('pagefooter.html') ?>
                        </div>

                        <?php
                            if (tpl_getConf('docinfopos') == "standalone") {
                                print '<div class="docInfo">';
                                tpl_pageinfo();
                                print '</div>';
                            }
                        ?>

                        <?php tpl_flush() ?>
                    </div>

                </article><!-- /content -->

            </div><!-- /wrapper -->

            <!-- PAGE ACTIONS -->
            <aside id="namespaced__pagetools" class="gutter flex column">
                <nav class="tools<?php print (strpos(tpl_getConf('uicolorize'), 'pagetools') !== false) ? " uicolor-pagetools" : "" ?>">
                    <ul class="nostyle">
                        <li><h6 class="aside-title<?php print $namespaced['a11y']['extraclass'] ?>"><?php print $lang['page_tools'] ?></h6></li>
                        <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems() ?>
                        <li class="bottom"><a href="#namespaced__footer" title="<?php print tpl_getLang('go_to_bottom') ?> [b]" rel="nofollow" accesskey="b"><span><?php print tpl_getLang('go_to_bottom') ?></span><?php namespaced_glyph('bottom') ?></svg></a></li>
                    </ul>
                </nav><!-- /.tools -->
            </aside><!-- /#dokuwiki__pagetools -->

        </main>

        <?php include('footer.php') ?>

    </div><!-- /site -->

    <div id="namespaced__housekeeper" class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>
</body>
</html>
