<?php

namespace Digicol\SchemaOrg;


class TestSearchAction extends TestThing implements SearchActionInterface
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


    /**
     * Get item type
     *
     * @return string schema.org type like "ImageObject" or "Thing"
     */
    public function getType()
    {
        return 'SearchAction';
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
     * Get search parameters
     *
     * @return array
     */
    public function getInputProperties()
    {
        return $this->input_properties;
    }


    /**
     * @return int
     */
    public function execute()
    {
        return 1;
    }


    /**
     * Get all property values
     *
     * @return array
     */
    public function getProperties()
    {
        $result = Utils::getSearchActionSkeleton();
        
        $items_per_page = Utils::getItemsPerPage($this->input_properties, self::DEFAULT_PAGESIZE);
        $start_index = Utils::getStartIndex($this->input_properties, self::DEFAULT_PAGESIZE);

        $result[ 'query' ] = (isset($this->input_properties['query']) ? $this->input_properties['query'] : '');
        $result[ 'result' ][ 'numberOfItems' ] = self::TOTAL_RESULTS;
        $result[ 'result' ][ 'opensearch:itemsPerPage' ] = $items_per_page;
        $result[ 'result' ][ 'opensearch:startIndex' ] = $start_index;

        $cnt = 0;

        for ($i = $start_index; $i <= self::TOTAL_RESULTS; $i++)
        {
            $cnt++;

            $result[ 'result' ][ 'itemListElement' ][ ] = 
                [
                    '@type' => 'ListItem',
                    'position' => $i,
                    'item' => new TestThing
                    (
                        [
                            '@type' => 'Photograph',
                            'sameAs' => 'http://example.com/thing/' . $i,
                            'query' => (isset($this->input_properties['query']) ? $this->input_properties['query'] : false)
                        ]
                    )
                ];

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
