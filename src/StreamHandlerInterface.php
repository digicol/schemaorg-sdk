<?php

namespace Digicol\SchemaOrg\Sdk;


interface StreamHandlerInterface
{
    /**
     * @param ItemListInterface $itemList
     * @return int
     */
    public function onListMetadata(ItemListInterface $itemList);


    /**
     * @param ThingInterface $thing
     * @return int
     */
    public function onListItem(ThingInterface $thing);


    /**
     * @return int
     */
    public function onComplete();
}
