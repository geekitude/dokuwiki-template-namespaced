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

                <ul class="a11y skip">
                    <li><a href="#dokuwiki__content"><?php echo $lang['skip_to_content']; ?></a></li>
                </ul>

        <?php tpl_includeFile('header.html') ?>

        <div class="flex" style="background-color:red;">
            <div class="headings flex grow1" style="background-color:green;">

                <div style="background-color:gold;">
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
                <div id="namespaced__site-branding" class="flex column" style="background-color:chocolate;">
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
                        <p id="namespaced__stire-description" class="claim"><?php echo $conf['tagline']; ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="tools grow4" style="background-color:blue;">
                <!-- USER TOOLS -->
                <?php if ($conf['useacl']): ?>
                    <div id="dokuwiki__usertools">
                        <h3 class="a11y"><?php echo $lang['user_tools']; ?></h3>
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

                <!-- SITE TOOLS -->
                <div id="dokuwiki__sitetools">
                    <h3 class="a11y"><?php echo $lang['site_tools']; ?></h3>
                    <?php tpl_searchform(); ?>
                    <div class="mobileTools">
                        <?php echo (new \dokuwiki\Menu\MobileMenu())->getDropdown($lang['tools']); ?>
                    </div>
                    <ul>
                        <?php echo (new \dokuwiki\Menu\SiteMenu())->getListItems('action ', false); ?>
                    </ul>
                </div>

            </div>
        </div>

        <!-- BREADCRUMBS -->
        <?php if($conf['breadcrumbs'] || $conf['youarehere']): ?>
            <nav class="breadcrumbs">
                <?php if($conf['youarehere']): ?>
                    <div class="youarehere"><?php tpl_youarehere() ?></div>
                <?php endif ?>
                <?php if($conf['breadcrumbs']): ?>
                    <div class="trace"><?php tpl_breadcrumbs() ?></div>
                <?php endif ?>
            </nav>
        <?php endif ?>



        <hr class="a11y" />
    </div>
</header><!-- /header -->
