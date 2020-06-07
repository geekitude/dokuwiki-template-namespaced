<?php

namespace dokuwiki\Menu;

/**
 * Class NamespacedPageMenu
 *
 * Actions manipulating the current page. Shown as a floating menu in the dokuwiki template
 *
 * Adapted from core to remove "back to top" item
 */
class NamespacedPageTools extends AbstractMenu {

    protected $view = 'page';

    protected $types = array(
        'Edit',
        'Revert',
        'Revisions',
        'Backlink',
        'Subscribe',
    );

}
