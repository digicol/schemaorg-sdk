<?php

namespace Digicol\SchemaOrg\Sdk;


interface ThingInterface
{
    /**
     * Get the adapter object
     *
     * @return AdapterInterface
     */
    public function getAdapter();


    /**
     * Get all parameter values
     *
     * @return array
     */
    public function getParams();


    /**
     * Get a single parameter value
     *
     * @param string $key
     * @return mixed
     */
    public function getParam($key);


    /**
     * Get identifier URI
     *
     * @return string
     */
    public function getSameAs();


    /**
     * Get item type
     *
     * @return string schema.org type like "ImageObject" or "Thing"
     */
    public function getType();


    /**
     * Get all property values
     *
     * @return array
     */
    public function getProperties();
}
