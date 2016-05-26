<?php

namespace Digicol\SchemaOrg;


interface SearchActionInterface
{
    /** @return array */
    public function getParams();


    /** @return array */
    public function describeInputProperties();


    /**
     * Set search parameters
     *
     * Common values that should be supported:
     *   query (string)
     *   opensearch:count (int; items per page)
     *   opensearch:startPage (int; 1 for the first page)
     * 
     * @param array $values
     * @return int
     */
    public function setInputProperties(array $values);


    /**
     * @return int
     */
    public function execute();


    /**
     * Get search results
     *
     * @return array Array of objects implementing ThingInterface
     */
    public function getResult();


    /**
     * Get search result metadata
     *
     * The array should contain at least these three values:
     *
     *   opensearch:totalResults (int)
     *   opensearch:startIndex (int; 1 for the first document)
     *   opensearch:itemsPerPage (int)
     *
     * @return array
     */
    public function getResultMeta();
}
