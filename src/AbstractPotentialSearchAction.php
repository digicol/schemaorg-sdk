<?php

namespace Digicol\SchemaOrg\Sdk;


abstract class AbstractPotentialSearchAction extends AbstractThing implements PotentialSearchActionInterface
{
    /**
     * @param AdapterInterface $adapter
     * @param array $params
     */
    public function __construct(AdapterInterface $adapter, array $params)
    {
        parent::__construct($adapter, $params);
        $this->type = 'SearchAction';
    }


    /**
     * @return SearchActionInterface
     */
    abstract public function newSearchAction();


    /** 
     * @return array 
     */
    public function describeInputProperties()
    {
        return [ ];
    }


    /**
     * Get all property values
     *
     * @return array
     */
    public function getProperties()
    {
        $result = Utils::getSearchActionSkeleton();
        
        $result[ 'name' ] = $this->params[ 'name' ];
        $result[ 'description' ] = $this->params[ 'description' ];
        
        return $result;
    }


    /** @return string */
    public function getName()
    {
        return $this->params[ 'name' ];
    }


    /** @return string */
    public function getDescription()
    {
        return $this->params[ 'description' ];
    }
}
