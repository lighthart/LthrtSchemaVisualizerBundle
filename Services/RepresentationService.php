<?php

namespace Lthrt\SchemaVisualizerBundle\Services;

use Lthrt\SchemaVisualizerBundle\Model\EntityRepresentation;
use Lthrt\SchemaVisualizerBundle\Model\GraphRepresentation;
use Lthrt\SchemaVisualizerBundle\Model\JSONRepresentation;

class RepresentationService
{
    private $em;

    public function __construct($em, $router)
    {
        $this->em = $em;
        $this->router = $router;
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

    public function getAllGraphJSON()
    {
        $classes = array_map(function ($m) {return $m->getName();},
            $this->em->getMetadataFactory()->getAllMetadata()
        );

        foreach ($classes as $key => $class) {
            $metadata                = $this->em->getClassMetadata($class);
            $entityRepresentations[] = new EntityRepresentation($metadata);
        }

        $graphRepresentation = new GraphRepresentation($entityRepresentations);

        return $graphRepresentation->getJSON();
    }

    public function getJSON($class)
    {
        $class                = str_replace('_', '\\', $class);
        $metadata             = $this->em->getClassMetadata($class);
        $entityRepresentation = new EntityRepresentation($metadata);
        $jsonRepresentation   = new JSONRepresentation($entityRepresentation);

        return $jsonRepresentation->getJSON();
    }

    public function getGraphJSON($class)
    {
        $class = str_replace('_', '\\', $class);
        $classes =
        array_map(
            function($d) { return $d->name; },
            array_filter(
                $this->em->getMetadataFactory()->getAllMetadata(),
                function($m) use ($class) {
                    return in_array($class,
                        array_map(
                            function($md) { return $md['targetEntity'];},
                            $m->associationMappings
                        )
                    );
                }
            )
        );
        $classes[] = $this->em->getClassMetadata($class)->name;
        $classes = array_unique($classes);
        foreach ($classes as $key => $newClass) {
            $metadata                = $this->em->getClassMetadata($newClass);
            $entityRepresentations[] = new EntityRepresentation($metadata, $class);
        }

        $graphRepresentation = new GraphRepresentation($entityRepresentations, $this->router);

        return $graphRepresentation->getJSON();
    }

}
