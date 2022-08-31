<?php


class MySqlQueryBuilder implements SQLQueryBuilder
{
    protected $query;

    protected function reset(): void
    {
        $this->query = new \stdClass;
    }


    public function select(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'SELECT ' . implode(', ', $fields) . ' FROM ' . $table;
        $this->query->type = 'select';

        return $this;
    }

    public function insert(string $table, array $fields): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'INSERT INTO ' . $table . ' (' . implode(', ', $fields) . ')';
        $this->query->type = 'insert';

        return $this;
    }

    public function update(string $table): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'UPDATE ' . $table . ' SET ';
        $this->query->type = 'update';

        return $this;
    }

    public function delete(string $table): SQLQueryBuilder
    {
        $this->reset();
        $this->query->base = 'DELETE FROM ' . $table . ' ';
        $this->query->type = 'delete';

        return $this;
    }

    public function set(array $keyValue): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['update'])) {
            throw new \Exception("la clause SET ne peut être utilisée qu'avec une requête de type UPDATE");
        }
        $this->query->setValue = [];
        foreach ($keyValue as $key => $value) {
            $this->query->setValue[] = "$key = $value";
        }

        return $this;
    }




    public function values(array $values): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['insert'])) {
            throw new \Exception('clause VALUES uniquement possible avec une requête de type INSERT INTO');
        }

        foreach ($values as $value) {
            $this->query->values[] = "(" . implode(', ', $value) . ")";
        }
        return $this;
    }

    public function where(string $field, string $value, string $operator = "="): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete'])) {
            throw new \Exception('clause WHERE possible uniquement sur les requête de type SELECT, UPDATE, ou DELETE');
        }

        $this->query->where[] = "$field $operator $value";

        return $this;
    }

    public function group(string $field): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception('clause GROUP BY uniquement possible avec une requête de type SELECT');
        }

        $this->query->group = ' GROUP BY ' . $field;

        return $this;
    }

    public function order(string $field, string $sort = 'ASC'): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception('clause ORDER BY uniquement possible avec une requête de type SELECT');
        }

        $this->query->order = ' ORDER BY ' . $field . ' ' . $sort;

        return $this;
    }

    public function limit(int $start, int $offset): SQLQueryBuilder
    {
        if (!in_array($this->query->type, ['select'])) {
            throw new \Exception('clause LIMIT uniquement possible avec une requête de type SELECT');
        }
        $this->query->limit = " LIMIT $start, $offset";

        return $this;
    }

    public function getSQL(): string
    {
        $query = $this->query;
        $sql = $query->base;
        if ($query->type == 'update') {
            $sql .= implode(', ', $this->query->setValue);
        }
        if (!empty($query->where)) {
            $sql .= " WHERE " . implode(' AND ', $query->where);
        }

        if ($query->type == 'insert') {
            $sql .= " VALUES " . implode(', ', $query->values) . "";
        }


        if (isset($query->group)) {
            $sql .= $query->group;
        }

        if (isset($query->order)) {
            $sql .= $query->order;
        }

        if (isset($query->limit)) {
            $sql .= $query->limit;
        }

        $sql .= ';';

        return $sql;
    }
}
