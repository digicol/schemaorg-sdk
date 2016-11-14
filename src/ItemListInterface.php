<?php

namespace Digicol\SchemaOrg;


interface ItemListInterface extends \Iterator, \ArrayAccess, ThingInterface
{
    /**
     * @return SearchActionInterface
     */
    public function getSearchAction();


    /**
     * Get total number of hits
     * 
     * @return int
     */
    public function getNumberOfItems();
    
    
    /**
     * Get first hit returned
     * 
     * @return int
     */
    public function getStartIndex();
    
    
    /**
     * Get number of hits returned
     * 
     * @return int
     */
    public function getItemsPerPage();


    /**
     * Get any search result parameter
     * 
     * @param string $key
     * @return mixed
     */
    public function getOutputProperty($key);
    
    
    /**
     * Get all search result parameters
     * 
     * @return array
     */
    public function getOutputProperties();


    /**
     * @return ThingInterface[]
     */
    public function getItems();
}
