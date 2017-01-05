<?php

namespace Digicol\SchemaOrg\Sdk\Example;

use Digicol\SchemaOrg\Sdk\AdapterInterface;
use Digicol\SchemaOrg\Sdk\PotentialSearchActionInterface;
use Digicol\SchemaOrg\Sdk\ThingInterface;


class ExampleAdapter implements AdapterInterface
{
    protected $params;


    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }


    /** @return array */
    public function getParams()
    {
        return $this->params;
    }


    /**
     * @return PotentialSearchActionInterface[]
     */
    public function getPotentialSearchActions()
    {
        $result = [];

        $result['test'] = new ExamplePotentialSearchAction
        (
            $this,
            [
                'name' => 'Test',
                'description' => 'Static test data'
            ]
        );

        return $result;
    }


    /**
     * @param string $uri sameAs identifying URL
     * @return ThingInterface
     */
    public function newThing($uri)
    {
        return new ExampleThing
        (
            $this,
            [
                '@type' => 'Photograph',
                'sameAs' => $uri
            ]
        );
    }
}
