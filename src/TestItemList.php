<?php

namespace Digicol\SchemaOrg;


class TestItemList extends AbstractItemList implements ItemListInterface
{
    const TOTAL_RESULTS = 57;


    public function execute()
    {
        $this->output_properties[ 'opensearch:startIndex' ] = $this->search_action->getStartIndex();
        $this->output_properties[ 'opensearch:itemsPerPage' ] = $this->search_action->getItemsPerPage();
        $this->output_properties[ 'numberOfItems' ] = self::TOTAL_RESULTS;
        
        $result[ 'query' ] = (isset($this->params['query']) ? $this->params['query'] : '');

        $cnt = 0;
        
        for ($i = $this->output_properties[ 'opensearch:startIndex' ]; $i <= $this->output_properties[ 'numberOfItems' ]; $i++)
        {
            $cnt++;

            $this->items[ ] = new TestThing
            (
                [
                    '@type' => 'Photograph',
                    'sameAs' => 'http://example.com/thing/' . $i,
                    'query' => (isset($this->params['query']) ? $this->params['query'] : false)
                ]
            );

            if ($cnt >= $this->output_properties[ 'opensearch:itemsPerPage' ])
            {
                break;
            }
        }
        
    }
}
