<?php

namespace Digicol\SchemaOrg\Sdk;


abstract class AbstractItemList extends AbstractThing implements ItemListInterface
{
    /** @var SearchActionInterface */
    protected $searchAction;

    /** @var array */
    protected $outputProperties =
        [
            'numberOfItems' => 0,
            'opensearch:itemsPerPage' => 20,
            'opensearch:startIndex' => 1
        ];

    /** @var ThingInterface[] */
    protected $items = [];


    /**
     * @param AdapterInterface $adapter
     * @param SearchActionInterface $searchAction
     * @param array $params
     */
    public function __construct(AdapterInterface $adapter, SearchActionInterface $searchAction, array $params = [])
    {
        parent::__construct($adapter, $params);
        $this->searchAction = $searchAction;
    }


    /**
     * @return SearchActionInterface
     */
    public function getSearchAction()
    {
        return $this->searchAction;
    }


    /**
     * Get first hit returned
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->outputProperties['opensearch:startIndex'];
    }


    /**
     * Get number of hits returned
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->outputProperties['opensearch:itemsPerPage'];
    }


    /**
     * Get total number of hits
     *
     * @return int
     */
    public function getNumberOfItems()
    {
        return $this->outputProperties['numberOfItems'];
    }


    /**
     * Get any search result parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getOutputProperty($key)
    {
        if (! isset($this->outputProperties[$key])) {
            return false;
        }

        return $this->outputProperties[$key];
    }


    /**
     * Get all search result parameters
     *
     * @return array
     */
    public function getOutputProperties()
    {
        return $this->outputProperties;
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
                'itemListElement' => []
            ];

        $i = 0;

        foreach ($this->items as $thing) {
            $i++;

            $result['itemListElement'][] =
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
        return isset($this->items[$key]);
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
        if (! $this->offsetExists($key)) {
            return null;
        }

        return $this->items[$key];
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
