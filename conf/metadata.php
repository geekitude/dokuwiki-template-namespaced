<?php
/**
 * Dokuwiki Namespaced template
 *
 * @link    https://www.dokuwiki.org/template:namespaced
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 2 (https://www.gnu.org/licenses/gpl-2.0.html)
 * 
 * Configuration metadata
 */

/* global look */
$meta['layout']             = array('multichoice','_choices' => array('box','wide','box2wide','mix'));
$meta['flexflip']           = array('multicheckbox','_choices' => array('banner','pagenav','sidepanel','pagetools','socket'),'_other' => 'never');
$meta['stickies']           = array('multicheckbox','_choices' => array('navbar','pagenav','sidebar','docinfo'),'_other' => 'never');
$meta['datelocale']         = array('string');
$meta['longdatestring']     = array('string');
$meta['shortdatestring']    = array('string');
$meta['tablestyle']         = array('multichoice','_choices' => array('colored','striped','dynamic'));
$meta['kbdstyle']           = array('multichoice','_choices' => array('basic','default','deep-blue','dark-apple','type-writer','dw-red','dw-green','dw-blue','dw-yellow'));
$meta['neutralize']         = array('multicheckbox','_choices' => array('pagenav','toc','docinfo','side-widgets','footer-widgets'),'_other' => 'never');
/* functionnalities */
$meta['glyphs']             = array('onoff');
$meta['splitnav']           = array('onoff');
$meta['nsindexexclude']     = array('array');
$meta['docinfopos']         = array('multichoice','_choices' => array('standalone','pagenav'));
$meta['searches']           = array('multicheckbox','_choices' => array('quicksearch','autocomplete'),'_other' => 'never');
$meta['licensevisual']      = array('multichoice','_choices' => array('badge','button','none'));
$meta['uiimagetarget']      = array('multichoice','_choices' => array('image-ns','current-ns','home','image-details','none'));
/*file names*/
$meta['banner']             = array('string');
$meta['pattern']            = array('string');
$meta['sidecard']           = array('string');
$meta['widebanner']         = array('string');
