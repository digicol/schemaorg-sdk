<?php

namespace Digicol\SchemaOrg\Sdk;


abstract class AbstractSearchAction extends AbstractThing implements SearchActionInterface
{
    /** @var PotentialSearchActionInterface */
    protected $potential_search_action;
    
    /** @var array */
    protected $input_properties = 
        [
            'query' => '',
            'opensearch:itemsPerPage' => 20,
            'opensearch:startIndex' => 1
        ];


    /**
     * @param AdapterInterface $adapter
     * @param PotentialSearchActionInterface $potential_search_action
     * @param array $params
     */
    public function __construct(AdapterInterface $adapter, PotentialSearchActionInterface $potential_search_action, array $params = [ ])
    {
        $this->potential_search_action = $potential_search_action;
        
        if (empty($params[ '@type' ]))
        {
            $params[ '@type' ] = 'SearchAction';
        }
        
        parent::__construct($adapter, $params);
    }


    /**
     * @return PotentialSearchActionInterface
     */
    public function getPotentialSearchAction()
    {
        return $this->potential_search_action;
    }


    /**
     * Set query string
     *
     * @param string $query
     * @return int
     */
    public function setQuery($query)
    {
        $this->input_properties[ 'query' ] = $query;
        
        return 1;
    }


    /**
     * Get query string
     *
     * @return string
     */
    public function getQuery()
    {
        return $this->input_properties[ 'query' ];
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
        $this->input_properties[ 'opensearch:startIndex' ] = max(1, intval($index));

        return 1;
    }


    /**
     * Get first hit returned
     *
     * @return int
     */
    public function getStartIndex()
    {
        return $this->input_properties[ 'opensearch:startIndex' ];
    }


    /**
     * Set number of hits to return
     *
     * @param int $items
     * @return int
     */
    public function setItemsPerPage($items)
    {
        $this->input_properties[ 'opensearch:itemsPerPage' ] = max(1, intval($items));

        return 1;
    }


    /**
     * Get number of hits returned
     *
     * @return int
     */
    public function getItemsPerPage()
    {
        return $this->input_properties[ 'opensearch:itemsPerPage' ];
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
        $this->input_properties[ $key ] = $value;
        
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
        if (! isset($this->input_properties[ $key ]))
        {
            return false;
        }
        
        return $this->input_properties[ $key ];
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


    public function getProperties()
    {
        $result = Utils::getSearchActionSkeleton();
        
        $result[ 'actionStatus' ] = 'ActiveActionStatus';
        $result[ 'query' ] = $this->getQuery();
        
        return $result;
    }


    /**
     * @return ItemListInterface
     */
    abstract public function getResult();
}
