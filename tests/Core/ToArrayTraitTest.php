<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: avermeulen
 * Date: 2021-02-03
 */

namespace Core;

use JTL\Generic\GenericCollection;
use JTL\SCX\Lib\Channel\Core\ToArrayTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \JTL\SCX\Lib\Channel\Core\ToArrayTrait
 */
class ToArrayTraitTest extends TestCase
{
    public function testCanConvertCollectionToArray(): void
    {
        $a = uniqid();
        $b = random_int(1, 99999999);
        $c = new \DateTimeImmutable();
        $d = ['foo' => 'bar'];
        $e = new My2ndTestClass($a);
        $collection = new MyTestClassCollection();
        $collection->add(new MyTestClass($a, $b, $c, $d, $e));

        self::assertSame([
            ["a" => $a, "b" => $b, "c" => $c->format('c'), "d" => $d, 'e' => ['a' => $a]]
        ], $collection->toArray());
    }

    public function testCanConvertObject(): void
    {
        $a = uniqid();
        $b = random_int(1, 99999999);
        $c = new \DateTimeImmutable();
        $d = ['foo' => 'bar'];
        $e = new My2ndTestClass($a);
        $obj = new MyTestClass($a, $b, $c, $d, $e);

        self::assertSame(["a" => $a, "b" => $b, "c" => $c->format('c'), "d" => $d, 'e' => ['a' => $a]], $obj->toArray());
    }
}

class MyTestClass
{
    use ToArrayTrait;

    private string $a;
    private int $b;
    private \DateTimeImmutable $c;
    private array $d;
    private My2ndTestClass $e;

    public function __construct(string $a, int $b, \DateTimeImmutable $c, array $d, My2ndTestClass $e)
    {
        $this->a = $a;
        $this->b = $b;
        $this->c = $c;
        $this->d = $d;
        $this->e = $e;
    }
}

class My2ndTestClass
{
    use ToArrayTrait;

    private string $a;

    public function __construct(string $a)
    {
        $this->a = $a;
    }
}

class MyTestClassCollection extends GenericCollection
{
    use ToArrayTrait;

    public function __construct()
    {
        parent::__construct(MyTestClass::class);
    }
}
