<?php

namespace Digicol\SchemaOrg\Sdk\Example;

use Digicol\SchemaOrg\Sdk\AbstractThing;
use Digicol\SchemaOrg\Sdk\ThingInterface;
use Digicol\SchemaOrg\Sdk\Utils;


class ExampleThing extends AbstractThing implements ThingInterface
{
    protected $type = 'Photograph';


    /**
     * Get all property values
     *
     * @return array
     */
    public function getProperties()
    {
        $i = basename(parse_url($this->params[ 'sameAs' ], PHP_URL_PATH));

        if (empty($this->params['query']))
        {
            $name = sprintf('%s #%s', $this->getType(), $i);
        }
        else
        {
            $name = $this->params['query'] . ' #' . $i;
        }

        return
            [
                '@context' => Utils::getNamespaceContext(),
                '@type' => $this->getType(),
                'name' => [ [ '@value' => $name ] ],
                'description' => [ [ '@value' => 'This is the description of item #' . $i ] ],
                'text' => 
                    [ 
                        [
                            '@value' => sprintf('<p>This is the text of <b>item #%s</b>, in XHTML format.', $i), 
                            '@type' => 'http://www.w3.org/1999/xhtml'
                        ] 
                    ],
                'dateCreated' => [ [ '@value' => date('c', (time() - ($i * 10000))), '@type' => 'DateTime' ] ],
                'sameAs' => [ [ '@id' => $this->params[ 'sameAs' ] ] ],
                'associatedMedia' =>
                    [
                        [
                            '@type' => 'ImageObject',
                            'contentUrl' => 'http://www.digicol.de/wp-content/uploads/2015/02/Semantic-ipad2-e1424180671222.png',
                            'name' => 'ipad2.png',
                            'width' => 300,
                            'height' => 235,
                            'contentSize' => 50181,
                            'fileFormat' => 'image/png',
                            'thumbnail' =>
                                [
                                    [
                                        '@type' => 'ImageObject',
                                        'contentUrl' => 'http://www.digicol.de/wp-content/uploads/2015/02/Semantic-ipad2-e1424180671222.png',
                                        'width' => 300,
                                        'height' => 235,
                                        'contentSize' => 50181,
                                        'fileFormat' => 'image/png'
                                    ]
                                ]
                        ]
                    ]
            ];
    }
}
