<?php namespace AdamWathan\Facktory\Relationship;

class BelongsTo extends Relationship
{
    public function build()
    {
        return $this->factoryLoader->__invoke()->build($this->attributes);
    }

    public function create()
    {
        return $this->factoryLoader->__invoke()->create($this->attributes);
    }

    protected function getRelatedModel()
    {
        return $this->factoryLoader->__invoke()->getModel();
    }
}
