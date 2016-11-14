<?php

namespace Digicol\SchemaOrg;


class TestPotentialSearchAction extends AbstractPotentialSearchAction  implements PotentialSearchActionInterface
{
    /**
     * @return SearchActionInterface
     */
    public function newSearchAction()
    {
        return new TestSearchAction($this);
    }
}
