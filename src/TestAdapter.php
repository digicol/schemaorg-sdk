<?php
/**
 * Created by PhpStorm.
 * User: tim
 * Date: 13.05.16
 * Time: 11:15
 */

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
     */
    public function newSearchAction(array $search_params)
    {
        return new TestSearchAction($search_params);
    }
}