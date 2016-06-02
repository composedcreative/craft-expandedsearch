# Expanded Search Plugin for Craft CMS

## Installation

`composer require composed/expandedsearch`

## Example

In your search results template

```
{% set expandedResults = craft.expandedSearch.search(query) %}
{% for result in expandedResults %}
    <strong data-field="{{result.matchedField}}">{{result.entry.title}}</strong><br>
    <p>{{result.matchedValue}}</p>
    <a href="{{result.entry.url}}">{{result.entry.url}}</a>
{% else %}
    <p>Sorry, no results for {{query}}.</p>
{% endfor %}
```
