<?php

namespace avadim\Evotor;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

/**
 * Простая коллекция для результатов запросов.
 * Заменяет DusanKasan\Knapsack\Collection, от которого SDK зависел ранее.
 */
class Collection implements IteratorAggregate, Countable
{
    /** @var array */
    protected $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * @param array|Traversable $items
     *
     * @return static
     */
    public static function from($items)
    {
        if ($items instanceof Traversable) {
            $items = iterator_to_array($items);
        }

        return new static((array)$items);
    }

    public function toArray()
    {
        return $this->items;
    }

    /**
     * @return static
     */
    public function map(callable $callback)
    {
        return new static(array_map($callback, $this->items));
    }

    /**
     * Значения, для которых $callback вернул истину. Без $callback отбрасывает пустые значения.
     *
     * @return static
     */
    public function filter(?callable $callback = null)
    {
        if ($callback === null) {
            return new static(array_filter($this->items));
        }

        return new static(array_filter($this->items, $callback, ARRAY_FILTER_USE_BOTH));
    }

    /**
     * @return static
     */
    public function reject(callable $callback)
    {
        return $this->filter(function ($value, $key) use ($callback) {
            return !$callback($value, $key);
        });
    }

    /**
     * @return $this
     */
    public function each(callable $callback)
    {
        foreach ($this->items as $key => $value) {
            if ($callback($value, $key) === false) {
                break;
            }
        }

        return $this;
    }

    /**
     * @param mixed $initial
     *
     * @return mixed
     */
    public function reduce(callable $callback, $initial = null)
    {
        return array_reduce($this->items, $callback, $initial);
    }

    /**
     * Значения одного поля из каждого элемента.
     *
     * @param string|int $column
     * @param string|int|null $index
     *
     * @return static
     */
    public function pluck($column, $index = null)
    {
        return new static(array_column($this->items, $column, $index));
    }

    /**
     * @param string|int $key
     *
     * @return static
     */
    public function keyBy($key)
    {
        $result = [];
        foreach ($this->items as $item) {
            if (is_array($item) && isset($item[$key])) {
                $result[$item[$key]] = $item;
            }
        }

        return new static($result);
    }

    /**
     * @return static
     */
    public function sort(?callable $callback = null)
    {
        $items = $this->items;
        if ($callback === null) {
            asort($items);
        } else {
            uasort($items, $callback);
        }

        return new static($items);
    }

    /**
     * @return static
     */
    public function reverse()
    {
        return new static(array_reverse($this->items, true));
    }

    /**
     * @return static
     */
    public function values()
    {
        return new static(array_values($this->items));
    }

    /**
     * @return static
     */
    public function keys()
    {
        return new static(array_keys($this->items));
    }

    /**
     * @return static
     */
    public function slice(int $offset, ?int $length = null)
    {
        return new static(array_slice($this->items, $offset, $length, true));
    }

    /**
     * @return static
     */
    public function take(int $count)
    {
        return $this->slice(0, $count);
    }

    /**
     * @return mixed|null
     */
    public function first()
    {
        foreach ($this->items as $item) {
            return $item;
        }

        return null;
    }

    /**
     * @return mixed|null
     */
    public function last()
    {
        if (!$this->items) {
            return null;
        }

        return $this->items[array_key_last($this->items)];
    }

    /**
     * @param mixed $value
     */
    public function contains($value): bool
    {
        return in_array($value, $this->items, true);
    }

    public function isEmpty(): bool
    {
        return !$this->items;
    }

    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->items);
    }

    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}
