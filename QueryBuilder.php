<?php

namespace Core;

/**
 * Class QueryBuilder
 * @package Core
 */
class QueryBuilder
{
    private array $fields = [];
    private array $conditions = [];
    private array $from = [];
    private int $limit = 0;
    private array $order = [];
    private array $joins = [];
    private const INNER_JOIN = 'i';
    private const LEFT_JOIN = 'l';
    private const RIGHT_JOIN = 'r';

    /**
     * @return string
     */
    public function __toString(): string
    {
        $query = 'SELECT '.implode(', ', $this->fields)
            .' FROM '.implode(', ', $this->from);
        if (!empty($this->joins)) {
            foreach ($this->joins as $item) {
                if ($item['type'] == self::INNER_JOIN) {
                    $query .= ' INNER JOIN '.implode(' ON ', $item['join']);
                }
                if ($item['type'] == self::LEFT_JOIN) {
                    $query .= ' LEFT JOIN '.implode(' ON ', $item['join']);
                }
                if ($item['type'] == self::RIGHT_JOIN) {
                    $query .= ' RIGHT JOIN '.implode(' ON ', $item['join']);
                }
            }
        }
        $query .= empty($this->conditions) ? '' : ' WHERE '.implode(' AND ', $this->conditions);
        $query .= empty($this->order) ? '' : ' ORDER BY '.implode(', ', $this->order);
        $query .= $this->limit === 0 ? '' : ' LIMIT '.$this->limit;
        return $query;
    }

    /**
     * @param  string  ...$select
     * @return $this
     */
    public function select(string ...$select): self
    {
        foreach ($select as $arg) {
            $this->fields[] = $arg;
        }
        return $this;
    }

    /**
     * @param  string  ...$where
     * @return $this
     */
    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    /**
     * @param  string  $table
     * @param  string|null  $alias
     * @return $this
     */
    public function from(string $table, ?string $alias = null): self
    {
        $this->from[] = $alias === null ? $table : "${table} AS ${alias}";
        return $this;
    }

    /**
     * @param  int  $limit
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param  string  ...$order
     * @return $this
     */
    public function orderBy(string ...$order): self
    {
        foreach ($order as $arg) {
            $this->order[] = $arg;
        }
        return $this;
    }

    /**
     * @param  string  ...$joins
     * @return $this
     */
    public function innerJoin(string ...$joins): self
    {
        $this->join(self::INNER_JOIN, $joins);
        return $this;
    }

    /**
     * @param  string  ...$joins
     * @return $this
     */
    public function leftJoin(string ...$joins): self
    {
        $this->join(self::LEFT_JOIN, $joins);
        return $this;
    }

    /**
     * @param  string  ...$joins
     * @return $this
     */
    public function rightJoin(string ...$joins): self
    {
        $this->join(self::RIGHT_JOIN, $joins);
        return $this;
    }

    /**
     * @param  string  $type
     * @param  array  $join
     */
    private function join(string $type, array $join)
    {
        $this->joins[] = [
            'type' => $type,
            'join' => $join
        ];
    }
}