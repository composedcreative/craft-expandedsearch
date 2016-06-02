<?php

namespace Craft;

use Craft\BasePlugin;

/**
 * Expanded Search Plugin for Craft CMS
 *
 * @author    Compose[d] Creative. <c3po@composedcreative.com>
 * @copyright Copyright (c) 2016, Compose[d] Creative Corp.
 * @license   GNU GPLv3
 * @package   ExpandedSearch
 * @since     %NEXT_VERSION%
 */
class ExpandedSearchPlugin extends BasePlugin
{
    function getName()
    {
         return Craft::t('Expanded Search');
    }

    function getVersion()
    {
        return '0.1.0';
    }

    function getDeveloper()
    {
        return 'Compose[d] Creative';
    }

    function getDeveloperUrl()
    {
        return 'http://www.composedcreative.com';
    }
}
