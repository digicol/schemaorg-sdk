<?php

namespace Digicol\SchemaOrg;


interface SearchActionInterface
{
    /**
     * @param array $params
     */
    public function __construct(array $params);


    /** @return array */
    public function describeInputProperties();


    /**
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
}