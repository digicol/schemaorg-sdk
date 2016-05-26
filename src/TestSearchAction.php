<?php

namespace Digicol\SchemaOrg;


class TestSearchAction implements SearchActionInterface
{
    const DEFAULT_PAGESIZE = 20;
    const TOTAL_RESULTS = 57;

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
    public function getParams()
    {
        return $this->params;
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
        $result = [ ];
        $items_per_page = Utils::getItemsPerPage($this->input_properties, self::DEFAULT_PAGESIZE);
        $cnt = 0;
        $start_index = Utils::getStartIndex($this->input_properties, self::DEFAULT_PAGESIZE);

        for ($i = $start_index; $i <= self::TOTAL_RESULTS; $i++)
        {
            $cnt++;

            $result[ ] = new TestThing
            (
                [
                    'type' => 'Thing',
                    'sameAs' => 'http://example.com/thing/' . $i,
                    'q' => (isset($this->input_properties['q']) ? $this->input_properties['q'] : false)
                ]
            );

            if ($cnt >= $items_per_page)
            {
                break;
            }
        }

        return $result;
    }


    /**
     * Get search result metadata
     *
     * @return array
     */
    public function getResultMeta()
    {
        return
        [
            'opensearch:totalResults' => self::TOTAL_RESULTS,
            'opensearch:startIndex' => Utils::getStartIndex($this->input_properties, self::DEFAULT_PAGESIZE),
            'opensearch:itemsPerPage' => Utils::getItemsPerPage($this->input_properties, self::DEFAULT_PAGESIZE)
        ];
    }
}
