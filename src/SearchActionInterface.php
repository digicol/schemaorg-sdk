<?php

namespace Digicol\SchemaOrg;


interface SearchActionInterface extends ThingInterface
{
    /**
     * @return PotentialSearchActionInterface
     */
    public function getPotentialSearchAction();


    /**
     * Set query string
     * 
     * @param string $query
     * @return int
     */
    public function setQuery($query);


    /**
     * Get query string
     * 
     * @return string
     */
    public function getQuery();
    
    
    /**
     * Set first hit to return
     * 
     * 1-based, i.e. $index = 1 will return the first hit.
     * 
     * @param int $index
     * @return int
     */
    public function setStartIndex($index);


    /**
     * Get first hit returned
     * 
     * @return int
     */
    public function getStartIndex();
    
    
    /**
     * Set number of hits to return
     * 
     * @param int $items
     * @return int
     */
    public function setItemsPerPage($items);


    /**
     * Get number of hits returned
     * 
     * @return int
     */
    public function getItemsPerPage();
    
    
    /**
     * Set any search parameter
     *
     * @param string $key
     * @param mixed $value
     * @return int
     */
    public function setInputProperty($key, $value);


    /**
     * Get any search parameter
     * 
     * @param string $key
     * @return mixed
     */
    public function getInputProperty($key);
    
    
    /**
     * Get search parameters
     * 
     * @return array
     */
    public function getInputProperties();


    /**
     * @return ItemListInterface
     */
    public function getResult();
}
