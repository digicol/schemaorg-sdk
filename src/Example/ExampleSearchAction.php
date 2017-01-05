<?php

namespace Digicol\SchemaOrg\Sdk\Example;

use Digicol\SchemaOrg\Sdk\AbstractSearchAction;
use Digicol\SchemaOrg\Sdk\ItemListInterface;
use Digicol\SchemaOrg\Sdk\SearchActionInterface;


class ExampleSearchAction extends AbstractSearchAction implements SearchActionInterface
{
    /**
     * @return ItemListInterface
     */
    public function getResult()
    {
        $result = new ExampleItemList($this->getAdapter(), $this, ['query' => $this->getQuery()]);
        $result->execute();

        return $result;
    }
}
