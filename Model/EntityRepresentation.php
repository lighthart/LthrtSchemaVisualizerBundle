<?php

namespace Lthrt\SchemaVisualizerBundle\Model;

use Doctrine\ORM\Mapping\ClassMetadata;

class EntityRepresentation
{
    /**
     * @var string
     */
    private $name;

    /**
     * Get name.
     *
     * @return
     */

    /**
     * @var string
     */
    private $parent;

    /**
     * @var string
     */
    private $fields;

    /**
     * @var string
     */
    private $oneToOne;

    /**
     * @var string
     */
    private $oneToMany;

    /**
     * @var string
     */
    private $manyToOne;

    /**
     * @var string
     */
    private $manyToMany;

    public function __construct(ClassMetadata $metadata)
    {
        $this->name   = strrev(strstr(strrev($metadata->name), '\\', true));
        $this->parent = $metadata->parentClasses;
        $this->fields = array_keys(array_map(function ($f) {return $f['fieldName'];}, $metadata->fieldMappings));
        $this->oneToOne =  array_map(
            function ($f) { return strrev(strstr(strrev($f['targetEntity']), '\\', true));},
            array_filter($metadata->associationMappings,
                function ($a) { return ClassMetadata::ONE_TO_ONE == $a['type']; }
            )
        );
        $this->oneToMany = array_map(
            function ($f) { return strrev(strstr(strrev($f['targetEntity']), '\\', true));},
            array_filter($metadata->associationMappings,
                function ($a) { return ClassMetadata::ONE_TO_MANY == $a['type']; }
            )
        );
        $this->manyToOne = array_map(
            function ($f) { return strrev(strstr(strrev($f['targetEntity']), '\\', true));},
            array_filter($metadata->associationMappings,
                function ($a) { return ClassMetadata::MANY_TO_ONE == $a['type']; }
            )
        );
        $this->manyToMany = array_map(
            function ($f) { return strrev(strstr(strrev($f['targetEntity']), '\\', true));},
            array_filter($metadata->associationMappings,
                function ($a) { return ClassMetadata::MANY_TO_MANY == $a['type']; }
            )
        );
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get parent.
     *
     * @return
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set parent.
     *
     * @param
     *
     * @return $this
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get fields.
     *
     * @return
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Set fields.
     *
     * @param
     *
     * @return $this
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get oneToOne.
     *
     * @return
     */
    public function getOneToOne()
    {
        return $this->oneToOne;
    }

    /**
     * Set oneToOne.
     *
     * @param
     *
     * @return $this
     */
    public function setOneToOne($oneToOne)
    {
        $this->oneToOne = $oneToOne;

        return $this;
    }

    /**
     * Get oneToMany.
     *
     * @return
     */
    public function getOneToMany()
    {
        return $this->oneToMany;
    }

    /**
     * Set oneToMany.
     *
     * @param
     *
     * @return $this
     */
    public function setOneToMany($oneToMany)
    {
        $this->oneToMany = $oneToMany;

        return $this;
    }

    /**
     * Get manyToOne.
     *
     * @return
     */
    public function getManyToOne()
    {
        return $this->manyToOne;
    }

    /**
     * Set manyToOne.
     *
     * @param
     *
     * @return $this
     */
    public function setManyToOne($manyToOne)
    {
        $this->manyToOne = $manyToOne;

        return $this;
    }

    /**
     * Get manyToMany.
     *
     * @return
     */
    public function getManyToMany()
    {
        return $this->manyToMany;
    }

    /**
     * Set manyToMany.
     *
     * @param
     *
     * @return $this
     */
    public function setManyToMany($manyToMany)
    {
        $this->manyToMany = $manyToMany;

        return $this;
    }
}
