<?php

declare(strict_types=1);

namespace avadim\Evotor;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    /** @var array */
    private $items;

    /** @var Collection */
    private $collection;

    protected function setUp(): void
    {
        $this->items = [
            ['id' => '123', 'name' => 'foo', 'price' => 10],
            ['id' => '321', 'name' => 'bar', 'price' => 30],
            ['id' => '213', 'name' => 'baz', 'price' => 20],
        ];
        $this->collection = Collection::from($this->items);
    }

    public function testToArray()
    {
        $this->assertSame($this->items, $this->collection->toArray());
    }

    public function testFromTraversable()
    {
        $collection = Collection::from(new \ArrayIterator($this->items));
        $this->assertSame($this->items, $collection->toArray());
    }

    public function testMap()
    {
        $ids = $this->collection->map(function ($item) {
            return $item['id'];
        })->toArray();
        $this->assertSame(['123', '321', '213'], $ids);
    }

    public function testFilter()
    {
        $filtered = $this->collection->filter(function ($item) {
            return $item['price'] > 15;
        })->values()->toArray();
        $this->assertCount(2, $filtered);
        $this->assertSame('321', $filtered[0]['id']);
    }

    public function testFilterWithoutCallback()
    {
        $this->assertSame([1, 2], Collection::from([1, 0, 2, null])->filter()->values()->toArray());
    }

    public function testReject()
    {
        $rejected = $this->collection->reject(function ($item) {
            return $item['price'] > 15;
        })->values()->toArray();
        $this->assertCount(1, $rejected);
        $this->assertSame('123', $rejected[0]['id']);
    }

    public function testEach()
    {
        $sum = 0;
        $this->collection->each(function ($item) use (&$sum) {
            $sum += $item['price'];
        });
        $this->assertSame(60, $sum);
    }

    public function testEachStopsOnFalse()
    {
        $count = 0;
        $this->collection->each(function () use (&$count) {
            $count++;
            return false;
        });
        $this->assertSame(1, $count);
    }

    public function testReduce()
    {
        $sum = $this->collection->reduce(function ($carry, $item) {
            return $carry + $item['price'];
        }, 0);
        $this->assertSame(60, $sum);
    }

    public function testPluck()
    {
        $this->assertSame(['foo', 'bar', 'baz'], $this->collection->pluck('name')->toArray());
        $this->assertSame(
            ['123' => 'foo', '321' => 'bar', '213' => 'baz'],
            $this->collection->pluck('name', 'id')->toArray()
        );
    }

    public function testKeyBy()
    {
        $keyed = $this->collection->keyBy('id')->toArray();
        // числовые строки PHP приводит к int-ключам
        $this->assertSame([123, 321, 213], array_keys($keyed));
        $this->assertSame('foo', $keyed['123']['name']);
    }

    public function testSort()
    {
        $sorted = $this->collection->sort(function ($a, $b) {
            return $a['price'] <=> $b['price'];
        })->values()->pluck('price')->toArray();
        $this->assertSame([10, 20, 30], $sorted);
    }

    public function testReverse()
    {
        $this->assertSame([3, 2, 1], Collection::from([1, 2, 3])->reverse()->values()->toArray());
    }

    public function testKeysAndValues()
    {
        $collection = Collection::from(['a' => 1, 'b' => 2]);
        $this->assertSame(['a', 'b'], $collection->keys()->toArray());
        $this->assertSame([1, 2], $collection->values()->toArray());
    }

    public function testSliceAndTake()
    {
        $this->assertSame([2, 3], Collection::from([1, 2, 3, 4])->slice(1, 2)->values()->toArray());
        $this->assertSame([1, 2], Collection::from([1, 2, 3, 4])->take(2)->toArray());
    }

    public function testFirstAndLast()
    {
        $this->assertSame($this->items[0], $this->collection->first());
        $this->assertSame($this->items[2], $this->collection->last());
        $this->assertNull(Collection::from([])->first());
        $this->assertNull(Collection::from([])->last());
    }

    public function testContains()
    {
        $this->assertTrue(Collection::from([1, 2])->contains(2));
        $this->assertFalse(Collection::from([1, 2])->contains('2'));
    }

    public function testCountAndIsEmpty()
    {
        $this->assertCount(3, $this->collection);
        $this->assertFalse($this->collection->isEmpty());
        $this->assertTrue(Collection::from([])->isEmpty());
    }

    public function testIsIterable()
    {
        $ids = [];
        foreach ($this->collection as $item) {
            $ids[] = $item['id'];
        }
        $this->assertSame(['123', '321', '213'], $ids);
    }
}
