<?php
namespace Tests\Unit\ChapmanDigital\Util\Type;

use App\Core\Type\Exception\ConstraintException;
use App\Core\Type\Id;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class IdTest extends TestCase
{
    public function testIdWillCreateNewValueWhenBlank(): void
    {
        $id = $this->getId('', true);
        $this->assertNotEmpty($id);
        $this->assertInstanceOf(Uuid::class, $id->getUuid());
    }

    public function testIdWillPopulateFromSpecifiedValue(): void
    {
        $id = $this->getId('bca90489-4127-46e0-ab8c-13edb02ad083', false);
        $this->assertEquals('bca90489-4127-46e0-ab8c-13edb02ad083', $id->getUuid()->toString());
    }

    public function testIdWillThrowExceptionIfEmptyAndNotAllowedToBe(): void
    {
        $this->expectException(ConstraintException::class);
        $this->getId('', false);
    }

    private function getId(string $uuid, bool $generateNewIdIfEmpty): Id
    {
        return new Class($uuid, $generateNewIdIfEmpty) extends Id
        {
            public function __construct(string $uuid = '', bool $generateNewIdIfEmpty = false)
            {
                parent::__construct($uuid, $generateNewIdIfEmpty);
            }
        };
    }
}