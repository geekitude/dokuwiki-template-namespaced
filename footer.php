<?php
/**
 * Namespaced template footer, included in the main and detail files
 */

// must be run from within DokuWiki
if (!defined('DOKU_INC')) die();
?>

<!-- ********** FOOTER ********** -->
<footer id="namespaced__footer" class="<?php print tpl_getConf("footerstyle") ?><?php print (strpos(tpl_getConf('neutralize'), 'footer') !== false) ? ' neu' : '' ?><?php print (tpl_getConf('footerwidgetstyle') == "labeled") ? ' toppadding10' : '' ?>">

    <?php namespaced_include("footer-head") ?>

    <div class="pad">
        <?php tpl_flush() ?>
        <?php tpl_includeFile('footertop.html') ?>

        <?php if(@count($namespaced['widgets']['footer']) > 0): ?>
            <div id="namespaced__footer_widgets" class="flex justify-evenly nowrap">
                <?php namespaced_widgets('footer') ?>
            </div>
        <?php endif ?>

        <?php tpl_includeFile('footerbottom.html') ?>

    </div><!-- /.pad -->

    <div  id="namespaced__footer_sole" class="flex column justify-center">
        <div class="buttons">
            <ul class="nostyle inline">
                <li>
                    <a href="https://dokuwiki.org/" title="Driven by DokuWiki"<?php print $external ?>><img src="<?php echo tpl_basedir() ?>images/button-dw.png" width="80" height="15" alt="Driven by DokuWiki" /></a>
                </li>
                <li>
                    <a href="https://translate.dokuwiki.org/" title="Localized"<?php print $external ?>><img src="<?php echo tpl_basedir() ?>images/button-localized.png" width="80" height="15" alt="Localized" /></a>
                </li>
                <li>
                    <a href="https://www.dokuwiki.org/donate" title="Donate"<?php print $external ?>><img src="<?php echo tpl_basedir() ?>images/button-donate.png" width="80" height="15" alt="Donate" /></a>
                </li>
                <li>
                    <a href="https://php.net" title="Powered by PHP"<?php print $external ?>><img src="<?php echo tpl_basedir() ?>images/button-php.png" width="80" height="15" alt="Powered by PHP" /></a>
                </li>
                <li>
                    <a href="//validator.w3.org/check/referer" title="Valid HTML5"<?php print $external ?>><img src="<?php echo tpl_basedir() ?>images/button-html5.png" width="80" height="15" alt="Valid HTML5" /></a>
                </li>
                <li>
                    <a href="//jigsaw.w3.org/css-validator/check/referer?profile=css3" title="Valid CSS"<?php print $external ?>><img src="<?php echo tpl_basedir() ?>images/button-css.png" width="80" height="15" alt="Valid CSS" /></a>
                </li>
            </ul>
        </div>
        <div class="center">
            <h6><a href="http://www.dokuwiki.org/template:namespaced"  title="Namespaced documentation"<?php print $external ?>><img src="/lib/tpl/namespaced/images/namespaced_logo_85.png" width="85" height="16" alt="" /></a></h6> - <a href="https://github.com/geekitude/dokuwiki-template-namespaced/"  title="Github"<?php print $external ?>><?php print namespaced_glyph('github', true)?></a>
            <p><?php print tpl_getLang('namespaced') ?></p>
        </div>

    </div><!-- /#namespaced__footer_sole -->

    <?php namespaced_include("footer-foot") ?>

</footer>

<?php
tpl_includeFile('footer.html');
