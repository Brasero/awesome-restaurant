<?php

interface SQLQueryBuilder{
    public function select(string $table, array $fields): SQLQueryBuilder;
    public function insert(string $table, array $fields): SQLQueryBuilder;
    public function values(array $values): SQLQueryBuilder;
    public function where(string $field, string $value, string $operator = "="): SQLQueryBuilder;
    public function group(string $field): SQLQueryBuilder;
    public function order(string $field, string $sort = 'ASC'): SQLQueryBuilder;
    public function limit(int $start, int $offset): SQLQueryBuilder;
    public function getSQL(): string;
}

?>