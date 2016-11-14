<?php

namespace Digicol\SchemaOrg;


abstract class AbstractThing implements ThingInterface
{
    protected $type;
    protected $params = [ ];


    /**
     * ThingInterface constructor.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;

        if (isset($params[ '@type' ]))
        {
            $this->type = $params[ '@type' ];
        }
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
