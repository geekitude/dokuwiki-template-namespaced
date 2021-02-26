<?php
/**
 * Dokuwiki Namespaced template
 *
 * @link    https://www.dokuwiki.org/template:namespaced
 * @author  Simon DELAGE <sdelage@gmail.com>
 * @license GPL 3 (https://www.gnu.org/licenses/gpl-3.0.html)
 * 
 * Configuration metadata
 */

/* global look */
$meta['layout']             = array('multichoice','_choices' => array('box','wide','box2wide','mix'));
$meta['flexflip']           = array('multicheckbox','_choices' => array('banner','pagenav','sidepanel','pagetools','socket'),'_other' => 'never');
/* functionnalities */
$meta['glyphs']             = array('onoff');
$meta['navbuttons']         = array('multicheckbox','_choices' => array('wikihome','parentns','nshome'),'_other' => 'never');
$meta['licensevisual']      = array('multichoice','_choices' => array('badge','button','none'));
$meta['uiimagetarget']      = array('multichoice','_choices' => array('image-ns','current-ns','home','image-details','none'));
/*file names*/
$meta['banner']             = array('string');
$meta['pattern']            = array('string');
$meta['sidecard']           = array('string');
$meta['widebanner']         = array('string');
