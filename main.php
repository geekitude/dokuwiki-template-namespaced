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

<body id="dokuwiki__top" class="<?php print namespaced_bodyclasses(); ?>">
    <a class="skip center<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : ' a11y' ?>" href="#namespaced__content"><?php echo $lang['skip_to_content']; ?></a>
    <div id="namespaced__site" class="site <?php echo tpl_classes(); ?> <?php echo ($showSidebar) ? 'showSidebar' : ''; ?> <?php echo ($hasSidebar) ? 'hasSidebar' : ''; ?>">

        <?php include('header.php') ?>

        <main class="flex nowrap align-stretch">

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
                    <hr class="vertical<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : ' a11y' ?>" />
                <?php endif; ?>

                <!-- ********** CONTENT ********** -->
                <article id="namespaced__content">

                    <div>
                        <?php html_msgarea() ?>

                        <div class="flex">
                            <div class="pageId">
                                <span><?php echo hsc($ID) ?></span>
                            </div>
                            <!-- TRANSLATIONS -->
                            <?php if(true): ?>
                                <nav id="namespaced__translations">
                                    <span class="dbg">*Translations*</span>
                                </nav>
                            <?php endif ?>
                        </div>

                        <div class="page">
                            <?php tpl_flush() ?>
                            <?php tpl_includeFile('pageheader.html') ?>
                            <hr class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>" />
                            <!-- wikipage start -->
                            <?php tpl_content() ?>
                            <!-- wikipage stop -->
                            <hr class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>" />
                            <?php tpl_includeFile('pagefooter.html') ?>
                        </div>

                        <div class="docInfo"><?php tpl_pageinfo() ?></div>

                        <?php tpl_flush() ?>
                    </div>

                </article><!-- /content -->

            </div><!-- /wrapper -->

            <!-- PAGE ACTIONS -->
            <aside id="namespaced__pagetools" class="gutter flex column">
                <nav class="tools<?php print (strpos(tpl_getConf('uicolorize'), 'pagetools') !== false) ? " uicolor-pagetools" : "" ?>">
                    <ul class="nostyle">
                        <li><h6 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? "" : "a11y " ?>aside-title"><?php print $lang['page_tools']; ?></h6></li>
                        <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems(); ?>
                        <?php //echo (new \dokuwiki\Menu\NamespacedPageTools())->getListItems(); ?>
                        <li class="bottom"><a href="#namespaced__footer" title="<?php print tpl_getLang('go_to_bottom'); ?> [b]" rel="nofollow" accesskey="b"><span><?php print tpl_getLang('go_to_bottom') ?></span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="24" height="24" viewBox="0 0 24 24"><path d="M11,4H13V16L18.5,10.5L19.92,11.92L12,19.84L4.08,11.92L5.5,10.5L11,16V4Z" /></svg></a></li>
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
