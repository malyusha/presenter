<?php

namespace Malyusha\Presenter;

abstract class Presenter
{
    use CachesAttributes;

    /**
     * @var mixed
     *
     */
    protected $entity;

    /**
     * Presenter constructor.
     *
     * @param $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    public function __call($name, $arguments)
    {
        return $this->cached('method_' . $name, $this->entity->{$name}(...$arguments));
    }

    public function __get($name)
    {
        return $this->cached('property_' . $name, $this->entity->{$name});
    }
}