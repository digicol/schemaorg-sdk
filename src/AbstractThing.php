<?php

namespace Digicol\SchemaOrg;


abstract class AbstractThing implements ThingInterface
{
    /** @var AdapterInterface */
    protected $adapter;

    /** @var string */
    protected $type;
    
    /** @var array */
    protected $params = [ ];


    /**
     * ThingInterface constructor.
     *
     * @param AdapterInterface $adapter
     * @param array $params
     */
    public function __construct(AdapterInterface $adapter, array $params)
    {
        $this->adapter = $adapter;
        $this->params = $params;

        if (isset($params[ '@type' ]))
        {
            $this->type = $params[ '@type' ];
        }
    }


    /**
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }


    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }


    /**
     * Get identifier URI
     *
     * @return string
     */
    public function getSameAs()
    {
        $properties = $this->getProperties();
        
        if (! isset($properties[ 'sameAs' ][ '@id' ]))
        {
            return '';
        }
        
        return $properties[ 'sameAs' ][ '@id' ];
    }


    /**
     * Get item type
     *
     * @return string schema.org type like "ImageObject" or "Thing"
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * Get all property values
     *
     * @return array
     */
    abstract public function getProperties();
}
