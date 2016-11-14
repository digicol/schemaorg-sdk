<?php

namespace Digicol\SchemaOrg;


class TestAdapter implements AdapterInterface
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
        $result = [ ];
        
        $result[ 'test' ] = new TestPotentialSearchAction
        (
            [
                'name' => 'Test',
                'description' => 'Static test data'
            ]
        );
        
        return $result;
    }
    

    /**
     * @param string $uri sameAs identifying URL
     * @return \Digicol\SchemaOrg\ThingInterface
     */
    public function newThing($uri)
    {
        return new TestThing
        (
            [
                '@type' => 'Photograph',
                'sameAs' => $uri
            ]
        );
    }
}
