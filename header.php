<?php
/**
 * Namespaced header, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>

<!-- ********** HEADER ********** -->
<header id="namespaced__header">
    <div class="pad group">

        <?php tpl_includeFile('header.html') ?>

        <div class="flex">
            <div id="namespaced__site_branding" class="headings flex justify-start grow1">

                <div id="namespaced__site_branding_logo">
                    <?php
                        // get logo either out of the template images folder or data/media folder
                        $logoSize = array();
                        $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false, $logoSize);

                        // display logo and wiki title in a link to the home page
                        tpl_link(
                            wl(),
                            '<img id="namespaced__site_logo" src="'.$logo.'" '.$logoSize[3].' alt="" />',
                            'accesskey="h" title="'.tpl_getLang('wikihome').' [H]"'
                        );
                    ?>
                </div>
                <div id="namespaced__site_branding_text" class="flex column">
                    <h1 id="namespaced__site_title">
                        <?php
                            // display logo and wiki title in a link to the home page
                            tpl_link(
                                wl(),
                                '<span>'.$conf['title'].'</span>',
                                'accesskey="h" title="'.tpl_getLang('wikihome').' [H]"'
                            );
                        ?>
                    </h1>
                    <?php if ($conf['tagline']): ?>
                        <p id="namespaced__site_description" class="claim"><?php echo $conf['tagline']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="flex column align-end">
                <div id="namespaced__banner_wrap" class="flex column end<?php print (strpos(tpl_getConf('print'), 'siteheader-banner') !== false) ? '' : ' noprint' ?>">
                    <?php
                        tpl_includeFile("bannerheader");
                        namespaced_ui_image('banner');
                        tpl_includeFile("bannerfooter");
                    ?>
                </div>
                <div id="namespaced__header_tools" class="tools flex column align-end grow4">

                    <!-- SITE TOOLS -->
                    <aside id="namespaced__sitetools">
                        <h6 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>"><?php echo $lang['site_tools']; ?></h6>

                        <div class="mobiletools">
                            <?php echo (new \dokuwiki\Menu\MobileMenu())->getDropdown($lang['tools']); ?>
                        </div>
                        <ul class="nostyle inline">
                            <?php echo (new \dokuwiki\Menu\SiteMenu())->getListItems('action ', tpl_getConf('glyphs')); ?>
                        </ul>
                    </aside>

                </div>
            </div>
        </div>

        <hr class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>" />
    </div>

    <nav id="namespaced__site_nav" class="flex navbar pad">
        <div id="namespaced_ns_menu">
            <h6 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>"><?php echo tpl_getLang('ns_content'); ?></h6>
            <ul class="nostyle">
                <!-- HOME -->
                <?php
                    if ((strpos(tpl_getConf('navbuttons'), 'wikihome') !== false) and (!in_array($namespaced['ishome'], array("default", "untranslated", "translated")))) {
                        print '<li>';
                            // display link to the home page
                            tpl_link(
                                wl(),
                                namespaced_glyph('home', true).'<span class="a11y">'.tpl_getLang('wikihome').'</span>',
                                'accesskey="h" title="'.tpl_getLang('wikihome').' [H]"'
                            );
                        print '</li>';
                    }
                    //if ((strpos(tpl_getConf('navbuttons'), 'parentns') !== false) and (($namespaced['ishome'] == "nshome") and (getns(getns($ID)) != null))) {
                    if ((strpos(tpl_getConf('navbuttons'), 'parentns') !== false) and (getns(getns($ID)) != null)) {
                        print '<li>';
                            // display link to parent namespace home page
                            tpl_link(
                                wl(getns(getns($ID)).':'.$conf['start']),
                                namespaced_glyph('parentns', true).'<span class="a11y">'.tpl_getLang('parentns').'</span>',
                                'title="'.tpl_getLang('parentns').'"'
                            );
                        print '</li>';
                    }
                    if ((strpos(tpl_getConf('navbuttons'), 'nshome') !== false) and ($namespaced['ishome'] == false)) {
                        print '<li>';
                            // display link to namespace home page
                            tpl_link(
                                wl(getns($ID).':'.$conf['start']),
                                namespaced_glyph('nshome', true).'<span class="a11y">'.tpl_getLang('nshome').'</span>',
                                'title="'.tpl_getLang('nshome').'"'
                            );
                        print '</li>';
                    }
                ?>
                <!-- NAMESPACE CONTENT -->
                <li class="dbg"><a id="dummy1"><span>*namespace menu*</span></a></li>
                <!-- NAMESPACE CONTENT -->
                <li class="dbg"><a id="dummy2"><span>*dummy2*</span></a></li>
            </ul>
        </div>
        <!-- USER TOOLS -->
        <?php if ($conf['useacl']): ?>
            <div id="namespaced__usertools">
                <h6 class="<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : 'a11y' ?>"><?php echo $lang['user_tools']; ?></h6>
                <ul class="nostyle">
                    <?php
                        if ($namespaced['defaultsearch'] == true) {
                            print '<li class="search">';
                                tpl_searchform();
                            print '</li>';
                        }
                        //if (!empty($_SERVER['REMOTE_USER'])) {
                        //    echo '<li class="user">';
                        //    tpl_userinfo(); /* 'Logged in as ...' */
                        //    echo '</li>';
                        //}
                        //echo (new \dokuwiki\Menu\UserMenu())->getListItems('action ', tpl_getConf('glyphs'));
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
    <?php endif; ?>

    <nav id="namespaced__page_nav">
        <!-- BREADCRUMBS -->
        <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
            <nav class="breadcrumbs flex navbar pad">
                <?php if($conf['youarehere']): ?>
                    <div class="youarehere"><?php tpl_youarehere() ?></div>
                <?php endif ?>
                <?php if($conf['breadcrumbs']): ?>
                    <div class="trace"><?php tpl_breadcrumbs() ?></div>
                <?php endif ?>
            </nav>
        <?php endif ?>
        <!-- TRANSLATIONS -->
        <?php if(true): ?>
            <aside class="navbar center">
                <span style="background-color:gold;">*Translations*</span>
            </aside>
        <?php endif ?>
    <nav>

</header><!-- /header -->
