<?php

namespace Craft;

use Craft\BaseApplicationComponent;
use Craft\BaseElementModel;
use Craft\ExpandedSearch_EntrySearchResultModel;

/**
 * Expanded Search Service
 *
 * @author    Compose[d] Creative. <c3po@composedcreative.com>
 * @copyright Copyright (c) 2016, Compose[d] Creative Corp.
 * @license   GNU GPLv3
 * @package   ExpandedSearch
 * @since     %NEXT_VERSION%
 */
class ExpandedSearch_SearchService extends BaseApplicationComponent
{
    /**
     * Searches entries for the given term
     *
     * @param string $term
     * @return array the search results
     */
    public function search($term)
    {
        $criteria = craft()->elements->getCriteria(ElementType::Entry);
        $criteria->search = '*' . $term . '*';
        $criteria->order = 'score';
        $results = [];
        foreach ($criteria->find() as $entry) {
            $result = new ExpandedSearch_EntrySearchResultModel();
            $result->entry = $entry;
            list ($result->matchedField, $result->matchedValue, $result->relatedValues) = $this->findMatchesInFieldSet($entry, $term);
            $results[] = $result;
        }
        return $results;
    }

    /**
     * Converts an Element into a kvp array of its fields
     *
     * @param Craft\BaseElementModel $element
     * @return array
     */
    protected function getFieldSetValues(BaseElementModel $element)
    {
        $values = [];
        foreach ($element->getFieldLayout()->getFields() as $fieldLayoutField) {
            $fieldHandle = craft()->fields->getFieldById($fieldLayoutField->fieldId)->handle;
            $fieldContents = $element->getFieldValue($fieldHandle);
            $values[$fieldHandle] = $fieldContents;
        }
        return $values;
    }

    /**
     * Gets a normalized representation of the given value
     *
     * @param mixed $value
     * @return scalar
     */
    protected function getNormalizedValue($value)
    {
        if (is_object($value) && $value instanceof \Craft\ElementCriteriaModel && $value->getElementType() instanceof \Craft\AssetElementType) {
            $assetUrls = [];
            foreach ($value as $asset) {
                $assetUrls[] = $asset->getUrl();
            }
            return 1 == count($assetUrls) ? array_shift($assetUrls) : $assetUrls;
        } elseif (is_object($value)) {
            return get_class($value);
        }
        return $value;
    }

    /**
     * Finds matches in an element's field values
     *
     * @param Craft\BaseElementModel $element
     * @param string $term the search term
     * @return array indexed array consisting of
     *                - The field handle
     *                - The matched value
     *                - Associative array of related values (handle => value)
     */
    protected function findMatchesInFieldSet(BaseElementModel $element, $term)
    {
        foreach ($this->getFieldSetValues($element) as $fieldHandle => $fieldContents) {
            if (is_scalar($fieldContents)) {
                if (stripos($fieldContents, $term) !== false) {
                    return [$fieldHandle, $fieldContents, []];
                }
            } elseif (is_object($fieldContents) && $fieldContents instanceof \Craft\ElementCriteriaModel && $fieldContents->getElementType() instanceof \Craft\MatrixBlockElementType) {
                $relatedValues = [];
                $matchedValue = '';
                foreach ($fieldContents as $matrixBlock) {
                    $matrixMatches = $this->findMatchesInFieldSet($matrixBlock, $term);
                    if (!is_null($matrixMatches)) {
                        $matchedValue = $matrixMatches[1];
                        foreach ($this->getFieldSetValues($matrixBlock) as $k => $v) {
                            $relatedValues[$k] = $this->getNormalizedValue($v);
                        }
                    }
                }
                // TODO: Should we append the matched sub-field handle to the higher-level handle?
                return [$fieldHandle, $matchedValue, $relatedValues];
            } elseif (is_object($fieldContents) && $fieldContents instanceof \Craft\RichTextData) {
                if (stripos($fieldContents->getParsedContent(), $term)) {
                    return [$fieldHandle, $fieldContents->getParsedContent(), []];
                }
            } else {
                // TODO: handle more data types
            }
        }
        return null;
    }
}
