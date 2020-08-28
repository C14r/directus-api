<?php

declare(strict_types=1);

namespace C14r\Directus\ORM;

use C14r\Directus\API;

class Item extends Model
{
    protected static $collection;
    protected static array $fields = [];

    protected array $attributes = [];
    protected array $original = [];
    protected array $fillable = [];
    protected bool $exists = false;
    

    public function __construct(array $attributes = [])
    {
        $this->syncOriginal();
        $this->fill($attributes);

        if ( ! isset(static::$fields[static::class])) {
            $fields = $this->api()->fields(static::getCollection())->get();

            foreach ($fields->data as $field) {
                static::$fields[static::class][$field->field] = new Field($field);
            }

            print_r(static::$fields[static::class]);
        }
    }

    public function syncOriginal()
    {
        $this->original = $this->attributes;

        return $this;
    }

    public function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }

        return $this;
    }

    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    public function isFillable($key)
    {
        if (in_array($key, $this->fillable)) {
            return true;
        }

        return empty($this->fillable);
    }

    public function setAttribute($key, $value)
    {
        if ($this->hasSetMutator($key)) {
            $method = 'set' . static::studly($key);

            return $this->{$method}($value);
        }

        $this->attributes[$key] = $value;
    }

    public function hasSetMutator($key)
    {
        return method_exists($this, 'set' . static::studly($key));
    }

    /*public function newInstance($attributes = [], $exists = false)
    {
        $model = new static((array) $attributes);
        $model->exists = $exists;

        return $model;
    }*/

    public static function find($id): self
    {
        return static::newInstance(static::api()->item(static::getCollection(), $id)->get());
    }

    public static function findAll(): Collection
    {
        return static::newCollection(static::api()->items(static::getCollection())->get());
    }

    public static function getCollection()
    {
        return (empty(static::$collection)) ? static::pluralize(strtolower(static::class)) : static::$collection;
    }

    public function create(): object
    {
        $this->exists = true;

        return static::query()->create($this->attributes);
    }

    public function update(): object
    {
        return static::query($this->id)->update($this->attributes);
    }

    public function delete(): object
    {
        return static::query($this->id)->delete();
    }

    public static function query($id = null): API
    {
        if (is_null($id)) {
            return static::api()->items(static::getCollection());
        }

        return static::api()->item(static::getCollection(), $id);
    }

    /**
     * Pluralizes a word if quantity is not one.
     *
     * @param string $singular Singular form of word
     * @param int $quantity Number of items
     * @param string $plural Plural form of word; function will attempt to deduce plural form from singular if not provided
     * @return string Pluralized word if quantity is not one, otherwise singular
     */
    public static function pluralize(string $singular, int $quantity = 2, ?string $plural = null): string
    {
        if ($quantity == 1 or !strlen($singular)) {
            return $singular;
        }

        if (!is_null($plural)) {
            return $plural;
        }

        $last_letter = strtolower($singular[strlen($singular) - 1]);

        switch ($last_letter) {
            case 'y':
                return substr($singular, 0, -1) . 'ies';
            case 's':
                return $singular . 'es';
            default:
                return $singular . 's';
        }
    }

    public static function studly($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return str_replace(' ', '', $value);
    }
}