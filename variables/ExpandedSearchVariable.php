<?php

namespace Craft;

/**
 * Expanded Search Template Variable
 *
 * @author    Compose[d] Creative. <c3po@composedcreative.com>
 * @copyright Copyright (c) 2016, Compose[d] Creative Corp.
 * @license   GNU GPLv3
 * @package   ExpandedSearch
 * @since     %NEXT_VERSION%
 */
class ExpandedSearchVariable
{
    /**
     * Wrapper to call the search service
     *
     * @param string $term
     * @return array search results
     */
    public function search($term)
    {
        return craft()->expandedSearch_search->search($term);
    }
}
