<?php

namespace Digicol\SchemaOrg\Sdk;


interface AdapterInterface
{
    /**
     * @param array $params
     */
    public function __construct(array $params);


    /**
     * @return array
     */
    public function getParams();


    /**
     * @return PotentialSearchActionInterface[]
     */
    public function getPotentialSearchActions();


    /**
     * @param string $uri sameAs identifying URL
     * @return ThingInterface
     */
    public function newThing($uri);
}
