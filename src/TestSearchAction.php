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
        $items_per_page = $this->getItemsPerPage();
        $cnt = 0;

        for ($i = $this->getStartIndex(); $i <= self::TOTAL_RESULTS; $i++)
        {
            $cnt++;

            if (empty($this->input_properties['q']))
            {
                $name = 'Thing #' . $i;
            }
            else
            {
                $name = $this->input_properties['q'] . ' #' . $i;
            }

            $result[] = new TestThing
            (
                [
                    'type' => 'Thing',
                    'properties' =>
                        [
                            'name' => $name,
                            'description' => 'This is the description of item #' . $i,
                            'image' => 'http://www.digicol.de/wp-content/uploads/2015/02/Semantic-ipad2-e1424180671222.png'
                        ]
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
            'opensearch:startIndex' => $this->getStartIndex(),
            'opensearch:itemsPerPage' => $this->getItemsPerPage()
        ];
    }


    protected function getItemsPerPage()
    {
        if (! isset($this->input_properties[ 'opensearch:count' ]))
        {
            return self::DEFAULT_PAGESIZE;
        }

        return max(1, intval($this->input_properties[ 'opensearch:count' ]));
    }


    protected function getStartPage()
    {
        if (! isset($this->input_properties[ 'opensearch:startPage' ]))
        {
            return 1;
        }

        return max(1, intval($this->input_properties[ 'opensearch:startPage' ]));
    }


    protected function getStartIndex()
    {
        return (($this->getItemsPerPage() * ($this->getStartPage() - 1)) + 1);
    }
}