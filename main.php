<?php
/**
 * Dokuwiki Namespaced template
 *
 * @link    https://www.dokuwiki.org/template:namespaced
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 3 (https://www.gnu.org/licenses/gpl-3.0.html)
 *
 * An experimental polymorphic and responsive DokuWiki template based on flexbox with many namespace related features
 * Based on DokuWiki default template by Anika Henke <anika@selfthinker.org> and Clarence Lee <clarencedglee@gmail.com>
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/functions.php'); /* include hook for template functions */

global $namespaced;
// Reset $colormag to make sure we don't inherit any value from previous page
$namespaced = array();
namespaced_init();

?><!DOCTYPE html>
<html lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="utf-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>
</head>

<body id="namespaced__top">
    <a class="skip center<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : ' a11y' ?>" href="#namespaced__content"><?php echo $lang['skip_to_content']; ?></a>
    <div id="namespaced__site" class="site <?php echo tpl_classes(); ?> <?php echo ($showSidebar) ? 'showSidebar' : ''; ?> <?php echo ($hasSidebar) ? 'hasSidebar' : ''; ?>">

        <?php include('header.php') ?>

        <main class="flex nowrap align-stretch">

            <aside class="tools"></aside>

            <div class="flex nowrap align-stretch">

                <?php //if($showSidebar): ?>
                <?php if(@count($namespaced['widgets']['side']) > 0): ?>
                    <!-- ********** ASIDE ********** -->
                    <div id="namespaced__aside">
                        <div class="pad aside include">
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
                <?php endif; ?>

                <!-- ********** CONTENT ********** -->
                <article id="namespaced__content">

                    <div class="pad">
                        <?php html_msgarea() ?>

                        <div class="pageId"><span><?php echo hsc($ID) ?></span></div>

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

            <aside class="tools">
                <!-- PAGE ACTIONS -->
                <nav id="namespaced__pagetools">
                    <h6 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>"><?php echo $lang['page_tools']; ?></h6>
                    <div>
                        <ul>
                            <?php echo (new \dokuwiki\Menu\PageMenu())->getListItems(); ?>
                        </ul>
                    </div>
                </nav>
            </aside>

        </main>

        <?php include('footer.php') ?>

    </div><!-- /site -->

    <div id="namespaced__housekeeper" class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    <div id="screen__mode" class="no"></div><?php /* helper to detect CSS media query in script.js */ ?>
</body>
</html>
