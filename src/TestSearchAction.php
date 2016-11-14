<?php

namespace Digicol\SchemaOrg;


class TestSearchAction extends AbstractSearchAction implements SearchActionInterface
{
    /**
     * @return ItemListInterface
     */
    public function getResult()
    {
        $result = new TestItemList($this, [ 'query' => $this->getQuery() ]);
        $result->execute();
        
        return $result;
    }
}
