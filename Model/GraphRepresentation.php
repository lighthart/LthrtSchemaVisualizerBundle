<?php

namespace Lthrt\SchemaVisualizerBundle\Model;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GraphRepresentation
{
    /**
     * @var EntityRepresentation
     */
    private $links;

    // mixed to handle arrays of entityRepresentations

    public function __construct($entityRepresentations)
    {
        foreach ($entityRepresentations as $entityRepresentation) {
            foreach (['oneToOne', 'oneToMany', 'manyToOne', 'manyToMany'] as $type) {
                $getMethod = 'get'.ucfirst($type);
                foreach ($entityRepresentation->$getMethod() as $key => $relation) {
                    $link['source'] = $entityRepresentation->getName();
                    $link['target'] = $relation;
                    $link['type'] = $type;
                    $this->links[] = $link;
                }
            }
        }
    }

    public function getJSON()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['id']);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);
        $json       = $serializer->serialize($this->links, 'json');
        return $json;
    }
}
