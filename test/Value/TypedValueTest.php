<?php

declare(strict_types=1);

namespace Reinfi\TypedParams\Test\Value;

use DateTimeImmutable;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Reinfi\TypedParams\Value\TypedValue;
use TypeError;

class TypedValueTest extends TestCase
{
    public function testAsBooleanReturnsBoolean(): void
    {
        self::assertTrue((new TypedValue(true))->asBoolean());
        self::assertFalse((new TypedValue(false))->asBoolean());
    }

    public function testAsBooleanThrowsForNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue(null))->asBoolean();
    }

    public function testAsBooleanOrNullReturnsNullableBoolean(): void
    {
        self::assertTrue((new TypedValue(true))->asBooleanOrNull());
        self::assertNull((new TypedValue(null))->asBooleanOrNull());
    }

    public function testAsIntegerReturnsInteger(): void
    {
        self::assertSame(42, (new TypedValue(42))->asInteger());
        self::assertSame(7, (new TypedValue('7'))->asInteger());
    }

    public function testAsIntegerThrowsForInvalidValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue('not-an-integer'))->asInteger();
    }

    public function testAsIntegerOrNullReturnsNullableInteger(): void
    {
        self::assertSame(42, (new TypedValue(42))->asIntegerOrNull());
        self::assertNull((new TypedValue(null))->asIntegerOrNull());
    }

    public function testAsPositiveInteger(): void
    {
        self::assertSame(1, (new TypedValue(1))->asPositiveInteger());
    }

    public function testAsPositiveIntegerThrowsForZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue(0))->asPositiveInteger();
    }

    public function testAsPositiveIntegerOrNull(): void
    {
        self::assertSame(5, (new TypedValue(5))->asPositiveIntegerOrNull());
        self::assertNull((new TypedValue(null))->asPositiveIntegerOrNull());
    }

    public function testAsNaturalInteger(): void
    {
        self::assertSame(0, (new TypedValue(0))->asNaturalInteger());
        self::assertSame(3, (new TypedValue(3))->asNaturalInteger());
    }

    public function testAsNaturalIntegerThrowsForNegative(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue(-1))->asNaturalInteger();
    }

    public function testAsNaturalIntegerOrNull(): void
    {
        self::assertSame(0, (new TypedValue(0))->asNaturalIntegerOrNull());
        self::assertNull((new TypedValue(null))->asNaturalIntegerOrNull());
    }

    public function testAsStringReturnsString(): void
    {
        self::assertSame('hello', (new TypedValue('hello'))->asString());
    }

    public function testAsStringThrowsForNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue(null))->asString();
    }

    public function testAsStringOrNull(): void
    {
        self::assertSame('hello', (new TypedValue('hello'))->asStringOrNull());
        self::assertNull((new TypedValue(null))->asStringOrNull());
    }

    public function testAsNonEmptyString(): void
    {
        self::assertSame('hello', (new TypedValue('hello'))->asNonEmptyString());
    }

    public function testAsNonEmptyStringThrowsForEmptyString(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue(''))->asNonEmptyString();
    }

    public function testAsNonEmptyStringOrNull(): void
    {
        self::assertSame('hello', (new TypedValue('hello'))->asNonEmptyStringOrNull());
        self::assertNull((new TypedValue(null))->asNonEmptyStringOrNull());
    }

    public function testAsNonEmptyStrings(): void
    {
        self::assertSame(
            ['a', 'b'],
            (new TypedValue(['a', 'b']))->asNonEmptyStrings()
        );
    }

    public function testAsNonEmptyStringsThrowsForEmptyValue(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new TypedValue(['a', '']))->asNonEmptyStrings();
    }

    public function testAsDateTimeImmutable(): void
    {
        $value = new TypedValue('2026-08-04');

        self::assertInstanceOf(
            DateTimeImmutable::class,
            $value->asDateTimeImmutable()
        );
    }

    public function testAsDateTimeImmutableWithFormat(): void
    {
        $value = new TypedValue('04082026');
        $date = $value->asDateTimeImmutable('dmY');

        self::assertSame('2026-08-04', $date->format('Y-m-d'));
    }

    public function testAsDateTimeImmutableThrowsForInvalidDate(): void
    {
        $this->expectException(TypeError::class);
        (new TypedValue('not-a-date'))->asDateTimeImmutable();
    }
}
