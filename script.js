/**
 * Dokuwiki Namespaced template java file
 *
 * @link    https://www.dokuwiki.org/template:namespaced
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 * 
 * Here comes java magic
 *
 * We handle several device classes based on browser width.
 *  - desktop:   > __tablet_width__ (as set in style.ini)
 *  - mobile:
 *    - tablet   <= __tablet_width__
 *    - phone    <= __phone_width__
 */
var device_class = ''; // not yet known
var device_classes = 'desktop mobile tablet phone';
var $docHeight = jQuery(document).height();
var $sitenavH = 0;
if (jQuery('#namespaced__site_nav').hasClass("sticky")) $sitenavH = jQuery('#namespaced__site_nav').outerHeight();
var $pagenavH = 0;
if (jQuery('#namespaced__page_nav').hasClass("sticky")) $pagenavH = jQuery('#namespaced__page_nav').outerHeight();
var $scrollDelta = $sitenavH + $pagenavH;
//// blur when clicked
//jQuery('#dokuwiki__pagetools div.tools>ul>li>a').on('click', function(){
//    this.blur();
//});

// RESIZE WATCHER
jQuery(function(){
    var resizeTimer;
    dw_page.makeToggle('#namespaced__aside h6.toggle','#namespaced__aside div.content');

    tpl_dokuwiki_mobile();
    jQuery(window).on('resize',
        function(){
            if (resizeTimer) clearTimeout(resizeTimer);
            resizeTimer = setTimeout(tpl_dokuwiki_mobile,200);
        }
    );
});

function tpl_dokuwiki_mobile(){

    // the z-index in mobile.css is (mis-)used purely for detecting the screen mode here
    var screen_mode = jQuery('#screen__mode').css('z-index') + '';

    // determine our device pattern
    // TODO: consider moving into dokuwiki core
    switch (screen_mode) {
        case '2002':
            if (device_class.match(/extract-sidebar/)) return;
            device_class = 'desktop extract-sidebar';
            break;
        case '2001':
            if (device_class.match(/extract-toc/)) return;
            device_class = 'desktop extract-toc';
            break;
        case '1001':
            if (device_class.match(/phone/)) return;
            device_class = 'mobile phone';
            break;
        default:
            if (device_class == 'desktop') return;
            device_class = 'desktop';
    }

    jQuery('html').removeClass(device_classes).addClass(device_class);

    // handle some layout changes based on change in device
    var $handle = jQuery('#namespaced__aside h6.toggle');
    var $toc = jQuery('#dw__toc h3');

    if (device_class == 'desktop') {
        // reset for desktop mode
        if($handle.length) {
            $handle[0].setState(1);
            //$handle.hide();
        }
        if($toc.length) {
            $toc[0].setState(1);
        }
    }
    if (device_class.match(/mobile/)){
        // toc and sidebar hiding
        if($handle.length) {
            //$handle.show();
            $handle[0].setState(-1);
        }
        if($toc.length) {
            $toc[0].setState(-1);
        }
        // dynamic table magic (https://css-tricks.com/simple-css-row-column-highlighting/)
        jQuery("td, th")
            .attr("tabindex", "1")
            // When they are tapped, focus them
            .on("touchstart", function() {
                jQuery(this).focus();
            });
    }
}

// SCROLL WATCHER
// Watch scroll to show/hide got-to-top/bottom page tools
jQuery(document).scroll(function() {
    var $scrollTop = jQuery(document).scrollTop();
    if ($scrollTop >= 600) {
        // user scrolled 600 pixels or more;
        jQuery('#namespaced__pagetools ul li.top').fadeIn(500);
        if ($scrollTop >= $docHeight - 1200) {
            // user scrolled 600 pixels or more;
            jQuery('#namespaced__pagetools ul li.bottom').fadeOut(0);
        } else {
            jQuery('#namespaced__pagetools ul li.bottom').fadeIn(500);
        }
    } else {
        jQuery('#namespaced__pagetools ul li.top').fadeOut(0);
    }
});

// CLICK WATCHER
// Add scroll delta from stickies when clicking a link
//jQuery('a[href*="#"]:not([href="#spacious__main"])').click(function(e) {
jQuery('a[href*="#"]').click(function() {
    var $target = jQuery(this.hash);
    //if ($target.length == 0) target = jQuery('a[name="' + this.hash.substr(1) + '"]');
    if ($target.length == 0) $target = jQuery('html');
    // Move to intended target with delta depending on stickies
    jQuery('html, body').scrollTop($target.offset().top - $scrollDelta );
    return false;
});

//jQuery(document).ready(function() {
//    jQuery('#namespaced__updown .up').fadeIn(0);
//});

// MEDIA MANAGER FILE SELECTION WATCHER
jQuery('#mediamanager__page div.filelist').on('DOMSubtreeModified', function(){
    console.log('changed');
        jQuery('#mediamanager__page div.filelist a.image').click(function() {
            //console.log("scroll!");
            jQuery("#mediamanager__page div.file").show();
            jQuery("#mediamanager__page div.file").get(0).scrollIntoView();
        }
    );
});