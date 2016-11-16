<?php

namespace Digicol\SchemaOrg\Sdk;


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
    public static function reconcileThingProperties($type, array $properties)
    {
        $result =
            [
                'description' => [ [ '@value' => '' ] ],
                'name' => [ [ '@value' => '(No name)' ] ],
                'text' => [ [ '@value' => '' ] ],
                'thumbnailUrl' => false
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

        // Get thumbnail image URL from:
        // - thumbnail/contentUrl
        // - associatedMedia/*/thumbnail/contentUrl
        // (Note that we expect thumbnail to be an array of thumbnails.)

        if (! empty($properties['thumbnail']))
        {
            foreach ($properties['thumbnail'] as $thumbnail)
            {
                if (! empty($thumbnail['contentUrl']))
                {
                    $result['thumbnailUrl'] = $thumbnail['contentUrl'];
                    break;
                }
            }
        }
        elseif (isset($properties['associatedMedia']) && is_array($properties['associatedMedia']))
        {
            foreach ($properties['associatedMedia'] as $media)
            {
                if (! isset($media['thumbnail']))
                {
                    continue;
                }

                foreach ($media['thumbnail'] as $thumbnail)
                {
                    if (! empty($thumbnail['contentUrl']))
                    {
                        $result['thumbnailUrl'] = $thumbnail['contentUrl'];
                        break;
                    }
                }
            }
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
                'actionStatus' => 'PotentialActionStatus',
                'query' => ''
            ];
    }
    
    
    /**
     * @param array $input_properties
     * @param int $default_pagesize
     * @return int
     */
    public static function getItemsPerPage(array $input_properties, $default_pagesize)
    {
        if (! isset($input_properties[ 'opensearch:itemsPerPage' ]))
        {
            return $default_pagesize;
        }

        return max(1, intval($input_properties[ 'opensearch:itemsPerPage' ]));
    }


    /**
     * @param array $input_properties
     * @param int $default_pagesize
     * @return int
     */
    public static function getStartIndex(array $input_properties)
    {
        if (! isset($input_properties[ 'opensearch:startIndex' ]))
        {
            return 1;
        }

        return max(1, intval($input_properties[ 'opensearch:startIndex' ]));
    }
}
