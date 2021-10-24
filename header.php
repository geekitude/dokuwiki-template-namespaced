<?php
/**
 * Namespaced template header, included in the main and detail files
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
                        <p id="namespaced__site_description" class="claim"><?php echo $conf['tagline'] ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div id="namespaced__secondary_header" class="flex column align-end gap5">
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
                        <h6<?php print $namespaced['a11y']['standalone'] ?>><?php echo $lang['site_tools'] ?></h6>

                        <div class="mobiletools">
                            <?php echo (new \dokuwiki\Menu\MobileMenu())->getDropdown($lang['tools']) ?>
                        </div>
                        <ul class="nostyle inline">
                            <?php echo (new \dokuwiki\Menu\SiteMenu())->getListItems('action ', tpl_getConf('glyphs')) ?>
                        </ul>
                    </aside>
                </div>
                <?php if ($namespaced['defaultsearch'] == true): ?>
                    <div id="namespaced__search" class="tools flex row align-end">
                        <?php
                            //namespaced_searchform(true);
                            tpl_searchform($namespaced['search']['quicksearch'], $namespaced['search']['autocomplete']);
                            namespaced_searchbutton();
                        ?>
                    </div>
                <?php endif ?>
            </div>
        </div>

        <hr<?php print $namespaced['a11y']['standalone'] ?> />
    </div>

</header><!-- /header -->
