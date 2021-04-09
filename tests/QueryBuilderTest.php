<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use QueryBuilder\QueryBuilder;

final class QueryBuilderTest extends TestCase
{
    public function testQueryIsString(): void
    {
        $string = (new QueryBuilder())->__toString();
        $this->assertIsString($string);
    }
}
