<?php namespace AdamWathan\Facktory\Relationship;

abstract class Relationship
{
    protected $factoryLoader;
    protected $foreign_key;
    protected $attributes;
    protected $related_model;

    public function __construct($related_model, $factoryLoader, $foreign_key = null, $attributes = [])
    {
        $this->related_model = $related_model;
        $this->factoryLoader = $factoryLoader;
        $this->foreign_key = $foreign_key;
        $this->attributes = $attributes;
    }

    public function foreignKey()
    {
        if (! is_null($this->foreign_key)) {
            return $this->foreign_key;
        }
        return $this->guessForeignKey();
    }

    protected function guessForeignKey()
    {
        return snake_case($this->relatedModelBase()).'_id';
    }

    protected function relatedModelBase()
    {
        $class_pieces = explode('\\', $this->related_model);
        return array_pop($class_pieces);
    }

    public function attributes($attributes)
    {
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    public function __set($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    abstract public function build();
}
