<?php

/*
 * This file is part of the slince/shopify-api-php
 *
 * (c) Slince <taosikai@yeah.net>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Slince\Shopify\Hydrator;

use Symfony\Component\Serializer\SerializerInterface;

class Hydrator implements HydratorInterface
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    public function __construct($cacheDir, $metaDirs)
    {
        $this->serializer = SerializerBuilder::create()
            ->setCacheDir($cacheDir)
            ->setMetadataDirs($metaDirs)
            ->build();
    }

    /**
     * {@inheritdoc}
     */
    public function extract($object)
    {
        return $this->serializer->toArray($object, $this->createDefaultContext());
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate($target, array $data)
    {
        return $this->serializer->fromArray($data, $target);
    }

    /**
     * Creates a default serializer context
     *
     * @return SerializationContext
     */
    protected function createDefaultContext()
    {
        return SerializationContext::create()->setSerializeNull(true);
    }
}