<?php

namespace Digicol\SchemaOrg;


class Utils
{
    public static function getNamespaceContext()
    {
        return
        [
            '@vocab' => 'http://schema.org/',
            'digicol' => 'http://www.digicol.com/xmlns/digicol/'
        ];
    }
    
    
    /**
     * @param string $type
     * @param array $properties
     * @param array $params
     * @return array
     */
    public static function reconcileThingProperties($type, array $properties, array $params = [ ])
    {
        $result =
            [
                'description' => [ [ '@value' => '' ] ],
                'name' => [ [ '@value' => '(No name)' ] ],
                'text' => [ [ '@value' => '' ] ],
                'thumbnail' => false,
                'digicol:previewImage' => false
            ];

        // description

        if (! empty($properties[ 'description' ][ 0 ][ '@value' ]))
        {
            $result[ 'description' ] = $properties[ 'description' ];
        }

        // name

        if (! empty($properties[ 'headline' ][ 0 ][ '@value' ]))
        {
            $result[ 'name' ] = $properties[ 'headline' ];
        }
        elseif (! empty($properties[ 'name' ][ 0 ][ '@value' ]))
        {
            $result[ 'name' ] = $properties[ 'name' ];
        }

        // text
        // If "text" is not provided, copy "articleBody" or "caption".
        // Last resort: Copy "description"

        $text_map =
            [
                'Article' => 'articleBody',
                'ImageObject' => 'caption',
                'NewsArticle' => 'articleBody',
                'VideoObject' => 'caption'
            ];

        if (! empty($properties[ 'text' ][ 0 ][ '@value' ]))
        {
            $result[ 'text' ] = $properties[ 'text' ];
        }
        elseif (isset($text_map[ $type ]) && (! empty($properties[ $text_map[ $type ] ][ 0 ][ '@value' ])))
        {
            $result[ 'text' ] = $properties[ $text_map[ $type ] ];
        }
        elseif (! empty($result[ 'description' ][ 0 ][ '@value' ]))
        {
            $result[ 'text' ] = $result[ 'description' ];
        }

        // Thumbnail image
        // TODO: Support thumbnail/ImageObject/contentUrl, image/thumbnail/ImageObject, image/@id

        if (! empty($properties[ 'image' ][ 0 ][ '@id' ]))
        {
            $result[ 'thumbnail' ] =
                [
                    'contentUrl' => $properties[ 'image' ]
                ];
        }

        // Preview image

        if (! empty($properties[ 'digicol:previewImage' ][ 0 ][ '@id' ]))
        {
            $result[ 'digicol:previewImage' ] =
                [
                    'contentUrl' => $properties[ 'digicol:previewImage' ]
                ];
        }
        else
        {
            $result[ 'digicol:previewImage' ] = $result[ 'thumbnail' ];
        }

        return $result;
    }


    /**
     * @return array Empty search result template
     */
    public static function getSearchActionSkeleton()
    {
        return
            [
                '@context' => array_merge
                    (
                        self::getNamespaceContext(),
                        [
                            'opensearch' => 'http://a9.com/-/spec/opensearch/1.1/'
                        ]
                    ),
                '@type' => 'SearchAction',
                'actionStatus' => 'CompletedActionStatus',
                'query' => '',
                'result' =>
                    [
                        '@type' => 'ItemList',
                        'numberOfItems' => 0,
                        'opensearch:startIndex' => 1,
                        'opensearch:itemsPerPage' => 1,
                        'itemListElement' => [ ]
                    ]
            ];
    }
    
    
    /**
     * @param array $input_properties
     * @param int $default_pagesize
     * @return int
     */
    public static function getItemsPerPage(array $input_properties, $default_pagesize)
    {
        if (! isset($input_properties[ 'opensearch:count' ]))
        {
            return $default_pagesize;
        }

        return max(1, intval($input_properties[ 'opensearch:count' ]));
    }


    /**
     * @param array $input_properties
     * @return int
     */
    public static function getStartPage(array $input_properties)
    {
        if (! isset($input_properties[ 'opensearch:startPage' ]))
        {
            return 1;
        }

        return max(1, intval($input_properties[ 'opensearch:startPage' ]));
    }


    /**
     * @param array $input_properties
     * @param int $default_pagesize
     * @return int
     */
    public static function getStartIndex(array $input_properties, $default_pagesize)
    {
        return
            (
                (
                    self::getItemsPerPage($input_properties, $default_pagesize)
                    * (self::getStartPage($input_properties) - 1)
                )
                + 1
            );
    }

}
