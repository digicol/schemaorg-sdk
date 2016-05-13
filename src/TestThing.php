<?php

namespace Digicol\SchemaOrg;


class TestThing implements ThingInterface
{
    protected $type = 'Thing';
    protected $properties = [ ];


    /**
     * ThingInterface constructor.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->type = $params[ 'type' ];
        $this->properties = $params[ 'properties' ];
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
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

}