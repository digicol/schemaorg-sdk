<?php

namespace Digicol\SchemaOrg;


class TestThing implements ThingInterface
{
    protected $type = 'Thing';
    protected $params = [ ];


    /**
     * ThingInterface constructor.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->type = $params[ 'type' ];
        $this->params = $params;
    }


    /**
     * Get item type
     *
     * @return string schema.org type like "ImageObject" or "Thing"
     */
    public function getType()
    {
        return $this->type;
    }


    /**
     * @return array
     */
    public function getProperties()
    {
        $i = basename(parse_url($this->params[ 'sameAs' ], PHP_URL_PATH));

        if (empty($this->params['q']))
        {
            $name = 'Thing #' . $i;
        }
        else
        {
            $name = $this->params['q'] . ' #' . $i;
        }

        return
            [
                'name' => $name,
                'description' => 'This is the description of item #' . $i,
                'sameAs' => $this->params[ 'sameAs' ],
                'image' => 'http://www.digicol.de/wp-content/uploads/2015/02/Semantic-ipad2-e1424180671222.png'
            ];
    }

}