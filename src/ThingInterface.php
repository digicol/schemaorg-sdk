<?php

namespace Digicol\SchemaOrg;


interface ThingInterface
{
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
