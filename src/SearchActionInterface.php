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
     * @param array $result
     * @return int
     */
    public function execute(&$result);
}