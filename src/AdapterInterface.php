<?php

namespace Digicol\SchemaOrg;


interface AdapterInterface
{
    /**
     * @param array $params
     */
    public function __construct(array $params);


    /** @return array */
    public function getParams();


    /** @return array */
    public function describeSearchActions();


    /**
     * @param array $search_params
     * @return \Digicol\SchemaOrg\SearchActionInterface
     */
    public function newSearchAction(array $search_params);


    /**
     * @param string $uri sameAs identifying URL
     * @return \Digicol\SchemaOrg\ThingInterface
     */
    public function newThing($uri);
}
