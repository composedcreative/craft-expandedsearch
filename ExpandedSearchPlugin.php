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
    public function getName()
    {
         return Craft::t('Expanded Search');
    }

    public function getDescription()
    {
        return 'Expanded meta information for search results';
    }

    public function getVersion()
    {
        return '0.1.0';
    }

    public function getDeveloper()
    {
        return 'Compose[d] Creative';
    }

    public function getDeveloperUrl()
    {
        return 'http://www.composedcreative.com';
    }

    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/composedcreative/craft-expandedsearch/master/releases.json';
    }
}
