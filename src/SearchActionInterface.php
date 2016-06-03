<?php

namespace Digicol\SchemaOrg;


interface SearchActionInterface extends ThingInterface
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
}
