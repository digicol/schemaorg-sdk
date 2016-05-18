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
    public function describeSearchActions()
    {
        $result =
            [
                'test' =>
                    [
                        'name' => 'Test',
                        'description' => 'Static test data'
                    ]
            ];

        return $result;
    }


    /**
     * @param array $search_params
     * @return \Digicol\SchemaOrg\SearchActionInterface
     */
    public function newSearchAction(array $search_params)
    {
        return new TestSearchAction($search_params);
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
                'type' => 'Thing',
                'sameAs' => $uri
            ]
        );
    }
}