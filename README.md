# Arrays

```php
use Hail\Arrays\Arrays;

assert(Arrays::isAssoc(['a',1]) === false);
assert(Arrays::isAssoc([1, 'a' => 2]) === true);

$array = ['a' => 1, 'b' => 2, 'c' => 3];
assert(Arrays::shift($array) === [1, 'a']);

$array = ['a', 'b', 'c'];
assert(Arrays::shift($array) === ['a', 0]);
assert($array === [1 => 'b', 2 => 'c']);
```
```php
use Hail\Arrays\Dot;

$array = new Dot([
    'a' => 1,
    'b' => [
        'c' => 2
    ]
]);

assert($array->get('a.b.c') === 2);
assert($array['a.b.c'] === $array->get('a.b.c'));
```