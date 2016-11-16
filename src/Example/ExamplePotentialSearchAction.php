<?php

namespace Digicol\SchemaOrg\Sdk\Example;

use Digicol\SchemaOrg\Sdk\AbstractPotentialSearchAction;
use Digicol\SchemaOrg\Sdk\PotentialSearchActionInterface;
use Digicol\SchemaOrg\Sdk\SearchActionInterface;


class ExamplePotentialSearchAction extends AbstractPotentialSearchAction implements PotentialSearchActionInterface
{
    /**
     * @return SearchActionInterface
     */
    public function newSearchAction()
    {
        return new ExampleSearchAction($this->getAdapter(), $this);
    }
}
