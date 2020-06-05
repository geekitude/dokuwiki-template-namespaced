<?php
/**
 * Namespaced header, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>

<!-- ********** FOOTER ********** -->
<footer id="namespaced__footer">
    <div class="pad">
        <div>
            <?php //tpl_license(''); // license text ?>
                <?php if(@count($namespaced['widgets']['footer']) > 0): ?>
                    <!-- ********** ASIDE ********** -->
                    <div id="namespaced__footer_widgets_container">
                        <div class="pad aside include">
                            <?php tpl_flush() ?>
                            <?php tpl_includeFile('footertop.html') ?>
                            <?php //tpl_include_page($conf['sidebar'], true, true) ?>
                            <div  id="namespaced__footer_widgets" class="flex nowrap justify-evenly align-start">
                                <?php namespaced_widgets('footer') ?>
                            </div>
                            <?php tpl_includeFile('footerbottom.html') ?>
                        </div>
                    </div><!-- /aside -->
                    <hr class="vertical<?php print (($_GET['debug'] == 1) or ($_GET['debug'] == 'a11y')) ? '' : ' a11y' ?>" />
                <?php endif; ?>
        </div>

        <div class="buttons">
            <?php
                $target = ($conf['target']['extern']) ? 'target="'.$conf['target']['extern'].'"' : '';
            ?>
            <a href="https://www.dokuwiki.org/donate" title="Donate" <?php echo $target?>><img
                src="<?php echo tpl_basedir(); ?>images/button-donate.png" width="80" height="15" alt="Donate" /></a>
            <a href="https://php.net" title="Powered by PHP" <?php echo $target?>><img
                src="<?php echo tpl_basedir(); ?>images/button-php.png" width="80" height="15" alt="Powered by PHP" /></a>
            <a href="//validator.w3.org/check/referer" title="Valid HTML5" <?php echo $target?>><img
                src="<?php echo tpl_basedir(); ?>images/button-html5.png" width="80" height="15" alt="Valid HTML5" /></a>
            <a href="//jigsaw.w3.org/css-validator/check/referer?profile=css3" title="Valid CSS" <?php echo $target?>><img
                src="<?php echo tpl_basedir(); ?>images/button-css.png" width="80" height="15" alt="Valid CSS" /></a>
            <a href="https://dokuwiki.org/" title="Driven by DokuWiki" <?php echo $target?>><img
                src="<?php echo tpl_basedir(); ?>images/button-dw.png" width="80" height="15"
                alt="Driven by DokuWiki" /></a>
        </div>
    </div>
</footer><!-- /footer -->

<?php
tpl_includeFile('footer.html');
