<?php

namespace Digicol\SchemaOrg;


class TestSearchAction implements SearchActionInterface
{
    /** @var array */
    protected $params = [ ];

    /** @var array */
    protected $input_properties = [ ];


    /**
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }


    /** @return array */
    public function describeInputProperties()
    {
        return [ ];
    }


    /**
     * @param array $values
     * @return int
     */
    public function setInputProperties(array $values)
    {
        $this->input_properties = $values;

        return 1;
    }


    /**
     * @param array $result
     * @return int
     */
    public function execute(&$result)
    {
        $result = [ ];
        
        return 1;
    }

}