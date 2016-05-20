<?php

namespace Digicol\SchemaOrg;


class Utils
{
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
                'thumbnail' => false,
                'name' => [ [ '@value' => '(No name)' ] ],
                'text' => [ [ '@value' => '' ] ]
            ];

        // Name

        if (! empty($properties[ 'headline' ][ 0 ][ '@value' ]))
        {
            $result[ 'name' ] = $properties[ 'headline' ];
        }
        elseif (! empty($properties[ 'name' ][ 0 ][ '@value' ]))
        {
            $result[ 'name' ] = $properties[ 'name' ];
        }

        // Text

        $text_map =
            [
                'Article' => 'articleBody',
                'ImageObject' => 'caption',
                'NewsArticle' => 'articleBody',
                'VideoObject' => 'caption'
            ];

        if (isset($text_map[ $type ]) && (! empty($properties[ $text_map[ $type ] ][ 0 ][ '@value' ])))
        {
            $result[ 'text' ] = $properties[ $text_map[ $type ] ];
        }
        elseif (! empty($properties[ 'description' ][ 0 ][ '@value' ]))
        {
            $result[ 'text' ] = $properties[ 'description' ];
        }
        elseif (! empty($properties[ 'text' ][ 0 ][ '@value' ]))
        {
            $result[ 'text' ] = $properties[ 'text' ];
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

        return $result;
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
