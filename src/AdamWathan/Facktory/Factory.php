<?php namespace AdamWathan\Facktory;

class Factory
{
	protected $model;
	protected $attributes;
	protected static $sequence = 0;

	public function __construct($model, $attributes = [])
	{
		$this->model = $model;
		$this->attributes = $attributes;
	}

	public function __set($key, $value)
	{
		$this->setAttribute($key, $value);
	}

	public function __get($key)
	{
		return $this->getAttribute($key);
	}

	protected function getAttribute($key)
	{
		if (is_callable($this->attributes[$key])) {
			return $this->attributes[$key]($this, static::$sequence);
		}
		return $this->attributes[$key];
	}

	public function setAttributes($attributes)
	{
		$this->attributes = $attributes;
	}

	protected function setAttribute($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	public function build($override_attributes)
	{
		$instance = $this->newModel();
		$attributes = array_merge($this->attributes, $override_attributes);
		foreach ($attributes as $attribute => $value) {
			if(is_callable($value)) {
				$instance->{$attribute} = $value($this, static::$sequence);
				continue;
			}
			$instance->{$attribute} = $value;
		}
		static::$sequence++;
		return $instance;
	}

	public function create($override_attributes)
	{
		$instance = $this->build($override_attributes);
		$instance->save();
		return $instance;
	}

	public function sequence($attribute, $callback)
	{
		$this->setAttribute($attribute, $callback);
	}

	protected function newModel($attributes = [])
	{
		$model = $this->model;
		return new $model($attributes);
	}

	public function add($name, $definitionCallback)
	{
		$callback = function($f) use ($definitionCallback) {
			$f->setAttributes($this->attributes);
			$definitionCallback($f);
		};
		Facktory::add([$name, $this->model], $callback);
	}
}
