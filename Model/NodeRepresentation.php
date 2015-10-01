<?php

namespace Lthrt\SchemaVisualizerBundle\Model;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class NodeRepresentation
{
    /**
     * @var EntityRepresentation
     */
    private $entityRepresentation;

    private $links;

    // mixed to handle arrays of entityRepresentations

    public function __construct($entityRepresentations)
    {
        foreach ($entityRepresentations as $entityRepresentation) {
            foreach (['oneToOne', 'oneToMany', 'manyToOne', 'manyToMany'] as $relation) {
                $getMethod = 'get'.ucfirst($relation);
                foreach ($entityRepresentation->$getMethod() as $key => $type) {
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
        $rep        = $this->entityRepresentation;
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['id']);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);
        $json       = $serializer->serialize($this->links, 'json');

        return $json;
    }
}
