<?php

namespace Digicol\SchemaOrg\Sdk\Example;

use Digicol\SchemaOrg\Sdk\AbstractItemList;
use Digicol\SchemaOrg\Sdk\ItemListInterface;


class ExampleItemList extends AbstractItemList implements ItemListInterface
{
    const TOTAL_RESULTS = 57;


    public function execute()
    {
        $this->outputProperties['opensearch:startIndex'] = $this->searchAction->getStartIndex();
        $this->outputProperties['opensearch:itemsPerPage'] = $this->searchAction->getItemsPerPage();
        $this->outputProperties['numberOfItems'] = self::TOTAL_RESULTS;

        $result['query'] = (isset($this->params['query']) ? $this->params['query'] : '');

        $cnt = 0;

        for ($i = $this->outputProperties['opensearch:startIndex']; $i <= $this->outputProperties['numberOfItems']; $i++) {
            $cnt++;

            $this->items[] = new ExampleThing
            (
                $this->getAdapter(),
                [
                    '@type' => 'Photograph',
                    'sameAs' => 'http://example.com/thing/' . $i,
                    'query' => (isset($this->params['query']) ? $this->params['query'] : false)
                ]
            );

            if ($cnt >= $this->outputProperties['opensearch:itemsPerPage']) {
                break;
            }
        }

    }
}
