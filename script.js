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
    }
}

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

    // increase sidebar length to match content (desktop mode only)
//    var sidebar_height = jQuery('.desktop #dokuwiki__aside').height();
//    var pagetool_height = jQuery('.desktop #dokuwiki__pagetools ul:first').height();
    // pagetools div has no height; ul has a height
//    var content_min = Math.max(sidebar_height || 0, pagetool_height || 0);

//    var content_height = jQuery('#dokuwiki__content div.page').height();
//    if(content_min && content_min > content_height) {
//        var $content = jQuery('#dokuwiki__content div.page');
//        $content.css('min-height', content_min);
//    }

    // blur when clicked
    jQuery('#dokuwiki__pagetools div.tools>ul>li>a').on('click', function(){
        this.blur();
    });
});

//jQuery(document).ready(function() {
//    jQuery('#namespaced__updown .up').fadeIn(0);
//});

jQuery(document).scroll(function() {
  var $scrollTop = jQuery(document).scrollTop();
  if ($scrollTop >= 600) {
    // user scrolled 50 pixels or more;
    // do stuff
    jQuery('#namespaced__pagetools ul li.top').fadeIn(500);
    //jQuery('#namespaced__pagetools ul li.bottom').fadeOut(0);
      if ($scrollTop >= $docHeight - 1200) {
        jQuery('#namespaced__pagetools ul li.bottom').fadeOut(0);
      } else {
        //jQuery('#namespaced__pagetools ul li.top').fadeOut(0);
        jQuery('#namespaced__pagetools ul li.bottom').fadeIn(500);
      }
  } else {
    jQuery('#namespaced__pagetools ul li.top').fadeOut(0);
    //jQuery('#namespaced__pagetools ul li.bottom').fadeIn(500);
  }
});
