<?php
/**
 * Template header, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>

<!-- ********** HEADER ********** -->
<header id="dokuwiki__header">
    <div class="pad group">

        <?php tpl_includeFile('header.html') ?>

        <div class="flex">
            <div id="namespaced__site-branding" class="headings flex justify-start grow1">

                <div id="namespaced__site-branding-logo">
                    <?php
                        // get logo either out of the template images folder or data/media folder
                        $logoSize = array();
                        $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false, $logoSize);

                        // display logo and wiki title in a link to the home page
                        tpl_link(
                            wl(),
                            '<img id="namespaced__site-logo" src="'.$logo.'" '.$logoSize[3].' alt="" />',
                            'accesskey="h" title="[H]"'
                        );
                    ?>
                </div>
                <div id="namespaced__site-branding-text" class="flex column">
                    <h1 id="namespaced__site-title">
                        <?php
                            // get logo either out of the template images folder or data/media folder
                            $logoSize = array();
                            $logo = tpl_getMediaFile(array(':wiki:logo.png', ':logo.png', 'images/logo.png'), false, $logoSize);

                            // display logo and wiki title in a link to the home page
                            tpl_link(
                                wl(),
                                '<span>'.$conf['title'].'</span>',
                                'accesskey="h" title="[H]"'
                            );
                        ?>
                    </h1>
                    <?php if ($conf['tagline']): ?>
                        <p id="namespaced__site-description" class="claim"><?php echo $conf['tagline']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div id="namespaced__header-tools" class="tools flex column align-end grow4">

                <!-- SITE TOOLS -->
                <aside id="dokuwiki__sitetools">
                    <h3 class="a11y"><?php echo $lang['site_tools']; ?></h3>
                    <?php tpl_searchform(); ?>
                    <div class="mobileTools">
                        <?php echo (new \dokuwiki\Menu\MobileMenu())->getDropdown($lang['tools']); ?>
                    </div>
                    <ul>
                        <?php echo (new \dokuwiki\Menu\SiteMenu())->getListItems('action ', false); ?>
                    </ul>
                </aside>

            </div>
        </div>

        <nav id="namespaced__site-nav">
            <nav id="namespaced__site-navbar" class="flex navbar">
                <div id="namespaced_ns-content">
                    <h6 class="a11y"><?php echo tpl_getLang('ns-content'); ?></h6>
                    <ul>
                        <!-- NAMESPACE CONTENT -->
                        <li>test</li>
                    </ul>
                </div>
                <!-- USER TOOLS -->
                <?php if ($conf['useacl']): ?>
                    <div id="dokuwiki__usertools">
                        <h6 class="a11y"><?php echo $lang['user_tools']; ?></h6>
                        <ul>
                            <?php
                                if (!empty($_SERVER['REMOTE_USER'])) {
                                    echo '<li class="user">';
                                    tpl_userinfo(); /* 'Logged in as ...' */
                                    echo '</li>';
                                }
                                echo (new \dokuwiki\Menu\UserMenu())->getListItems('action ');
                            ?>
                        </ul>
                    </div>
                <?php endif ?>
            </nav>
            <!-- BREADCRUMBS -->
            <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
                <nav class="breadcrumbs flex navbar">
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



        <hr class="a11y" />
    </div>
</header><!-- /header -->
