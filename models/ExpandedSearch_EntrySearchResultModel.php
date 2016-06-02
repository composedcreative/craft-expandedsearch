<?php

namespace Craft;

use Craft\BaseModel;

/**
 * Expanded Search Entry Result Model
 *
 * @author    Compose[d] Creative. <c3po@composedcreative.com>
 * @copyright Copyright (c) 2016, Compose[d] Creative Corp.
 * @license   GNU GPLv3
 * @package   ExpandedSearch
 * @since     %NEXT_VERSION%
 */
class ExpandedSearch_EntrySearchResultModel extends BaseModel
{
    /**
     * The field that the search query matched against
     *
     * @var string
     */
    public $matchedField;

    /**
     * The value that the search query matched against
     *
     * @var string
     */
    public $matchedValue;

    /**
     * The field that the search query matched against
     *
     * @var array
     */
    public $relatedValues = [];

    /**
     * The matched entry
     *
     * @var Craft\EntryModel
     */
    public $entry;

    /**
     * Defines the model's attributes
     *
     * @return array
     */
    protected function defineAttributes()
    {
        return array_merge(parent::defineAttributes(), [
            'matchedField' => AttributeType::String,
            'matchedValue' => AttributeType::String,
            'relatedValues' => AttributeType::Mixed,
            'entry' => AttributeType::Mixed,
        ]);
    }

    /*
     * TODO: call entry fields and methods natively from result in template code
     *
     * Example
     * currently the call would look like `result.entry.url`
     * ideally it would simply be `result.url`
     */
}
