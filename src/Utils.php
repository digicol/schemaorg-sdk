<?php

namespace Digicol\SchemaOrg;


class Utils
{
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