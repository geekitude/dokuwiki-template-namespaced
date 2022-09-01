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
$meta['stickies']           = array('multicheckbox','_choices' => array('navbar','pagenav','sidepanel','docinfo'),'_other' => 'never');
$meta['datelocale']         = array('string');
$meta['longdatestring']     = array('string');
$meta['shortdatestring']    = array('string');
$meta['tablestyle']         = array('multichoice','_choices' => array('colored','striped','dynamic'));
$meta['kbdstyle']           = array('multichoice','_choices' => array('basic','default','deep-blue','dark-apple','type-writer','dw-red','dw-green','dw-blue','dw-yellow'));
$meta['pagenavstyle']       = array('multichoice','_choices' => array('theme','secondary','dark','fourborders','oneborder'));
$meta['sidewidgetstyle']    = array('multichoice','_choices' => array('labeled','theme','secondary','dark','fourborders','oneborder'));
$meta['subnsaltidxstyle']   = array('multichoice','_choices' => array('theme','secondary','dark','fourborders','oneborder'));
$meta['tocstyle']           = array('multichoice','_choices' => array('theme','secondary','dark','fourborders','oneborder'));
$meta['docinfostyle']       = array('multichoice','_choices' => array('theme','secondary','dark','fourborders','oneborder'));
$meta['footerstyle']        = array('multichoice','_choices' => array('theme','secondary','dark','oneborder','sitebg'));
$meta['footerwidgetstyle']  = array('multichoice','_choices' => array('labeled','theme','secondary','dark','fourborders','oneborder','transparent'));
$meta['neutralize']         = array('multicheckbox','_choices' => array('pagenav','toc','docinfo','side-widgets','subnsaltidx','footer-widgets','footer'),'_other' => 'never');
$meta['collapsible-toc']    = array('onoff');
$meta['acordion-toc']       = array('onoff');
$meta['forcesidepanel']     = array('onoff');

/* functionnalities */
$meta['splitnav']           = array('onoff');
$meta['nsindexexclude']     = array('array');
$meta['subnsaltidx']        = array('multichoice','_choices' => array('never','home','start','always'));
$meta['subnsaltidximage']   = array('multichoice','_choices' => array('none','banner','cover','mix'));
$meta['docinfopos']         = array('multichoice','_choices' => array('standalone','pagenav'));
$meta['searches']           = array('multicheckbox','_choices' => array('quicksearch','autocomplete'),'_other' => 'never');
$meta['licensevisual']      = array('multichoice','_choices' => array('badge','button','none'));
$meta['uiimagetarget']      = array('multichoice','_choices' => array('image-ns','current-ns','home','image-details','none'));

/*file names*/
$meta['banner']             = array('string');
$meta['pattern']            = array('string');
$meta['cover']              = array('string');
$meta['widebanner']         = array('string');
