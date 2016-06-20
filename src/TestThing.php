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
     * Get identifier URI
     *
     * @return string
     */
    public function getSameAs()
    {
        $properties = $this->getProperties();
        
        return $properties[ 'sameAs' ][ '@id' ];
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
     * Get all property values
     *
     * @return array
     */
    public function getProperties()
    {
        $i = basename(parse_url($this->params[ 'sameAs' ], PHP_URL_PATH));

        if (empty($this->params['query']))
        {
            $name = 'Thing #' . $i;
        }
        else
        {
            $name = $this->params['query'] . ' #' . $i;
        }

        return
            [
                '@context' => 'http://schema.org/',
                '@type' => $this->getType(),
                'name' => [ [ '@value' => $name ] ],
                'description' => [ [ '@value' => 'This is the description of item #' . $i ] ],
                'sameAs' => [ [ '@id' => $this->params[ 'sameAs' ] ] ],
                'image' => [ [ '@id' => 'http://www.digicol.de/wp-content/uploads/2015/02/Semantic-ipad2-e1424180671222.png' ] ]
            ];
    }

    
    /**
     * @return array
     */
    public function getReconciledProperties()
    {
        return Utils::reconcileThingProperties
        (
            $this->getType(),
            $this->getProperties()
        );
    }
}
