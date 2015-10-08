<?php

namespace Lthrt\SchemaVisualizerBundle\Model;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdjacencyListRepresentation
{
    /**
     * @var EntityRepresentation
     */
    private $adjacencyList;

    // mixed to handle arrays of entityRepresentations

    public function __construct($entityRepresentations, $router, $level = 0)
    {
        var_dump('AL constructor:%%%%%%%%%%%%%%%% ');
        foreach ($entityRepresentations as $entityRepresentation) {
            foreach (['oneToOne', 'oneToMany', 'manyToOne', 'manyToMany'] as $type) {
                $getMethod = 'get'.ucfirst($type);
                if ('Lthrt_ContactBundle_Entity_Person' == $entityRepresentation->getClass() ) {
                var_dump($type);
                var_dump('Ent: '.$entityRepresentation->getClass());
                var_dump($entityRepresentation->$getMethod());
                var_dump(get_class_methods($entityRepresentation));
            }
                foreach ($entityRepresentation->$getMethod() as $key => $relation) {
                if ('Lthrt_ContactBundle_Entity_Person' == $entityRepresentation->getClass() ) {
                    var_dump('AL relation: '. $relation);
                }
                    $this->adjacencyList[$entityRepresentation->getClass()][] = $relation;
                    if (!isset($this->adjacencyList[$relation])) {
                        $this->adjacencyList[$relation] = [];
                    }
                }
            }
        }
        var_dump($this->adjacencyList);
    }

    public function getJSON()
    {
        $normalizer = new ObjectNormalizer();
        $normalizer->setIgnoredAttributes(['id']);
        $serializer = new Serializer([$normalizer], [new JsonEncoder()]);
        $json       = $serializer->serialize($this->adjacencyList, 'json');
        return $json;
    }
}
