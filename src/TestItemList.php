<?php

namespace Digicol\SchemaOrg;


class TestItemList extends TestThing implements ItemListInterface
{
    const TOTAL_RESULTS = 57;

    /** @var SearchActionInterface */
    protected $search_action;

    /** @var array */
    protected $output_properties =
        [
            'numberOfItems' => 0,
            'opensearch:itemsPerPage' => 20,
            'opensearch:startIndex' => 1
        ];
    
    /** @var ThingInterface[] */
    protected $items = [ ];


    /**
     * @param array $params
     */
    public function __construct(SearchActionInterface $search_action, array $params = [ ])
    {
        parent::__construct($params);
        $this->search_action = $search_action;
    }


    /**
     * @return SearchActionInterface
     */
    public function getSearchAction()
    {
        return $this->search_action;
    }


    public function execute()
    {
        $this->output_properties[ 'opensearch:startIndex' ] = $this->search_action->getStartIndex();
        $this->output_properties[ 'opensearch:itemsPerPage' ] = $this->search_action->getItemsPerPage();
        $this->output_properties[ 'numberOfItems' ] = self::TOTAL_RESULTS;
        
        $result[ 'query' ] = (isset($this->params['query']) ? $this->params['query'] : '');

        $cnt = 0;
        
        for ($i = $this->output_properties[ 'opensearch:startIndex' ]; $i <= $this->output_properties[ 'numberOfItems' ]; $i++)
        {
            $cnt++;

            $this->items[ ] = new TestThing
            (
                [
                    '@type' => 'Photograph',
                    'sameAs' => 'http://example.com/thing/' . $i,
                    'query' => (isset($this->params['query']) ? $this->params['query'] : false)
                ]
            );

            if ($cnt >= $this->output_properties[ 'opensearch:itemsPerPage' ])
            {
                break;
            }
        }
        
    }
    
    
    /**
     * Get first hit returned
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->output_properties[ 'opensearch:startIndex' ];
    }


    /**
     * Get number of hits returned
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->output_properties[ 'opensearch:itemsPerPage' ];
    }
    

    /**
     * Get total number of hits
     *
     * @return int
     */
    public function getNumberOfItems()
    {
        return $this->output_properties[ 'numberOfItems' ];
    }


    /**
     * Get any search result parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getOutputProperty($key)
    {
        if (! isset($this->output_properties[ $key ]))
        {
            return false;
        }

        return $this->output_properties[ $key ];
    }


    /**
     * Get all search result parameters
     *
     * @return array
     */
    public function getOutputProperties()
    {
        return $this->output_properties;
    }


    /**
     * @return ThingInterface[]
     */
    public function getItems()
    {
        return $this->items;
    }

    
    /**
     * Get all property values
     *
     * @return array
     */
    public function getProperties()
    {
        $result = 
            [
                '@type' => 'ItemList',
                'numberOfItems' => $this->getNumberOfItems(),
                'opensearch:itemsPerPage' => $this->getItemsPerPage(),
                'opensearch:startIndex' => $this->getStartIndex(),
                'itemListElement' => [ ]
            ];

        $i = 0;
        
        foreach ($this->items as $thing)
        {
            $i++;

            $result[ 'itemListElement' ][ ] = 
                [
                    '@type' => 'ListItem',
                    'position' => $i,
                    'item' => $thing->getProperties()
                ];
        }

        return $result;
    }


    /**
     * ArrayAccess::offsetSet() implementation
     *
     * This method does nothing since we don't support adding items at runtime.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
    }


    /**
     * ArrayAccess::offsetExists() implementation
     *
     * @param mixed $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return isset($this->items[ $key ]);
    }


    /**
     * ArrayAccess::offsetUnset() implementation
     *
     * This method does nothing since we don't support removing items at runtime.
     *
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
    }


    /**
     * ArrayAccess::offsetGet() implementation
     *
     * @param mixed $key
     * @return ThingInterface
     */
    public function offsetGet($key)
    {
        if (! $this->offsetExists($key))
        {
            return null;
        }

        return $this->items[ $key ];
    }


    /**
     * Iterator::rewind() implementation
     */
    public function rewind()
    {
        reset($this->items);
    }


    /**
     * Iterator::current() implementation
     *
     * @return ThingInterface
     */
    public function current()
    {
        return $this->offsetGet(key($this->items));
    }


    /**
     * Iterator::key() implementation
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->items);
    }


    /**
     * Iterator::next() implementation
     */
    public function next()
    {
        next($this->items);
    }


    /**
     * Iterator::valid() implementation
     *
     * @return bool
     */
    public function valid()
    {
        return $this->offsetExists($this->key());
    }
}
