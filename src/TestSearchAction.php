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
     * @return int
     */
    public function execute()
    {
        return 1;
    }


    /**
     * Get search results
     *
     * @return array Array of objects implementing ThingInterface
     */
    public function getResult()
    {
        $result =
            [
                new TestThing
                (
                    [
                        'type' => 'Thing',
                        'properties' =>
                        [
                            'name' => 'Thing #1',
                            'description' => 'Some text about thing #1 here.'
                        ]
                    ]
                ),
                new TestThing
                (
                    [
                        'type' => 'Thing',
                        'properties' =>
                            [
                                'name' => 'Thing #2',
                                'description' => 'Some text about thing #2 here.'
                            ]
                    ]
                )
            ];

        if (! empty($this->input_properties[ 'q' ]))
        {
            $result[ ] =
                [
                    new TestThing
                    (
                        [
                            'type' => 'Thing',
                            'properties' =>
                                [
                                    'name' => 'Thing with ' . $this->input_properties[ 'q' ],
                                    'description' => 'This is here to prove your search term did come through.'
                                ]
                        ]
                    )
                ];
        }

        return $result;
    }

}