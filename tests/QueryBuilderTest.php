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

    public function testQueryBuildWithWhereSentences(): void
    {
        $query = (new QueryBuilder())
            ->select('*')
            ->from('my_table')
            ->where('id=1')
            ->andWhere('id = 4')
            ->orWhere('id is null')
            ->andWhere('id = 5')
            ->orWhere('id is not null')
            ->__toString();
        $this->expectOutputString($query);
        $this->assertIsString($query);
    }
}
