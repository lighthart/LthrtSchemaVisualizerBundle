<?php

namespace Lthrt\SchemaVisualizerBundle\Services;

use Lthrt\SchemaVisualizerBundle\Model\EntityRepresentation;
use Lthrt\SchemaVisualizerBundle\Model\JSONRepresentation;

class RepresentationService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function getJSON($class)
    {
        $class                = str_replace('_', '\\', $class);
        $metadata             = $this->em->getClassMetadata($class);
        $entityRepresentation = new EntityRepresentation($metadata);
        $jsonRepresentation   = new JSONRepresentation($entityRepresentation);

        return $jsonRepresentation->getJSON();
    }

    public function getAllJSON()
    {
        $classes = array_map(function ($m) {return $m->getName();},
            $this->em->getMetadataFactory()->getAllMetadata()
        );

        foreach ($classes as $key => $class) {
            $metadata                = $this->em->getClassMetadata($class);
            $entityRepresentations[] = new EntityRepresentation($metadata);
        }
        $jsonRepresentation = new JSONRepresentation($entityRepresentations);

        return $jsonRepresentation->getJSON();
    }
}
