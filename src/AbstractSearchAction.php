<?php

namespace Digicol\SchemaOrg\Sdk;


abstract class AbstractSearchAction extends AbstractThing implements SearchActionInterface
{
    /** @var PotentialSearchActionInterface */
    protected $potentialSearchAction;

    /** @var array */
    protected $inputProperties =
        [
            'query' => '',
            'opensearch:itemsPerPage' => 20,
            'opensearch:startIndex' => 1
        ];


    /**
     * @param AdapterInterface $adapter
     * @param PotentialSearchActionInterface $potentialSearchAction
     * @param array $params
     */
    public function __construct(
        AdapterInterface $adapter,
        PotentialSearchActionInterface $potentialSearchAction,
        array $params = []
    ) {
        $this->potentialSearchAction = $potentialSearchAction;

        if (empty($params['@type'])) {
            $params['@type'] = 'SearchAction';
        }

        parent::__construct($adapter, $params);
    }


    /**
     * @return PotentialSearchActionInterface
     */
    public function getPotentialSearchAction()
    {
        return $this->potentialSearchAction;
    }


    /**
     * Set query string
     *
     * @param string $query
     * @return int
     */
    public function setQuery($query)
    {
        $this->inputProperties['query'] = $query;

        return 1;
    }


    /**
     * Get query string
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->inputProperties['query'];
    }


    /**
     * Set first hit to return
     *
     * 1-based, i.e. $index = 1 will return the first hit.
     *
     * @param int $index
     * @return int
     */
    public function setStartIndex($index)
    {
        $this->inputProperties['opensearch:startIndex'] = max(1, intval($index));

        return 1;
    }


    /**
     * Get first hit returned
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->inputProperties['opensearch:startIndex'];
    }


    /**
     * Set number of hits to return
     *
     * @param int $items
     * @return int
     */
    public function setItemsPerPage($items)
    {
        $this->inputProperties['opensearch:itemsPerPage'] = max(1, intval($items));

        return 1;
    }


    /**
     * Get number of hits returned
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->inputProperties['opensearch:itemsPerPage'];
    }


    /**
     * Set any search parameter
     *
     * @param string $key
     * @param mixed $value
     * @return int
     */
    public function setInputProperty($key, $value)
    {
        $this->inputProperties[$key] = $value;

        return 1;
    }


    /**
     * Get any search parameter
     *
     * @param string $key
     * @return mixed
     */
    public function getInputProperty($key)
    {
        if (! isset($this->inputProperties[$key])) {
            return false;
        }

        return $this->inputProperties[$key];
    }


    /**
     * Get search parameters
     *
     * @return array
     */
    public function getInputProperties()
    {
        return $this->inputProperties;
    }


    public function getProperties()
    {
        $result = Utils::getSearchActionSkeleton();

        $result['actionStatus'] = 'ActiveActionStatus';
        $result['query'] = $this->getQuery();

        return $result;
    }


    /**
     * @return ItemListInterface
     */
    abstract public function getResult();


    /**
     * @param StreamHandlerInterface $streamHandler
     * @return int
     */
    public function streamResult(StreamHandlerInterface $streamHandler)
    {
        // Override this method for real streaming! This is just a stupid
        // default implementation feeding the whole result at once to the callback.
        
        $itemList = $this->getResult();
        
        $ok = $streamHandler->onListMetadata($itemList);
        
        if ($ok >= 0) {
            foreach ($itemList->getItems() as $item) {
                $ok = $streamHandler->onListItem($item);
                
                if ($ok < 0) {
                    break;
                }
            }
        }
        
        if ($ok >= 0) {
            $streamHandler->onComplete();
        }
        
        return $ok;
    }
}
