<?php

namespace Digicol\SchemaOrg;


interface PotentialSearchActionInterface extends ThingInterface
{
    /** @return string */
    public function getName();


    /** @return string */
    public function getDescription();


    /**
     * @return array
     */
    public function describeInputProperties();


    /**
     * @return SearchActionInterface
     */
    public function newSearchAction();
}
