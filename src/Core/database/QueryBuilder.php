<?php


namespace Core\database;


class QueryBuilder
{
    /* The query types. */
    const SELECT = 0;
    const DELETE = 1;
    const UPDATE = 2;

    private $type;

    private $alias;

    private $query;

    /**
     * The index of the first result to retrieve.
     *
     * @var integer
     */
    private $firstResult = null;

    /**
     * The maximum number of results to retrieve.
     *
     * @var integer|null
     */
    private $maxResults = null;

    /**
     * The array of DQL parts collected.
     *
     * @var array
     */
    private $queryParts = [
        'distinct' => false,
        'select'  => [],
        'from'    => [],
        'join'    => [],
        'set'     => [],
        'where'   => null,
        'groupBy' => [],
        'having'  => null,
        'orderBy' => []
    ];

    public function __construct(string $alias = null)
    {
        if ($alias !== null) {
            $this->alias = $alias;
        }
    }

    public function getQuery()
    {
        switch ($this->type) {
            case self::DELETE:
                $query = $this->getSqlForDelete();
                break;

            case self::UPDATE:
                $query = $this->getSqlForUpdate();
                break;

            case self::SELECT:
            default:
                $query = $this->getSqlForSelect();
                break;
        }

        $this->query = $query;

        return $query;
    }

    private function getSqlForSelect()
    {
        $selectParts = $this->queryParts['select'];
        $fromParts = $this->queryParts['from'];
        $whereParts = $this->queryParts['where'];

        $sql = 'SELECT '
             . ($this->queryParts['distinct'] ? 'DISTINCT ' : '')
             . (is_array($selectParts) && sizeof($selectParts) > 0 ? implode(', ', $selectParts) : '*');

        if (!empty($fromParts)) {
            $sql .= ' FROM '
                 . (implode(', ', $fromParts));
        }

        if ($whereParts !== null && !empty($whereParts)) {
            $sql .= ' WHERE ';

            if (array_key_exists('and', $whereParts) && is_array($whereParts['and'])) {
                $sql .= (implode(' AND ', $whereParts['and']));
            }

            if (array_key_exists('or', $whereParts) && is_array($whereParts['or'])) {
                $sql .= ' OR ' . (implode(' OR ', $whereParts['or']));
            }
        }

        return $sql;
    }

    private function getSqlForDelete()
    {
        $sql = 'DELETE';

        return $sql;
    }

    private function getSqlForUpdate()
    {
        $sql = 'UPDATE';

        return $sql;
    }

    public function execute()
    {
        $query = $this->getQuery();
    }

    public function select(string $field)
    {
        $this->type = self::SELECT;

        if (empty($field)) {
            return $this;
        }

        $this->queryParts['select'][] = $field;

        return $this;
    }

    public function delete(bool $delete = false)
    {
        $this->type = self::DELETE;

        if (!$delete) {
            return $this;
        }

        return $this;
    }

    public function update(bool $update = false)
    {
        $this->type = self::UPDATE;

        if (!$update) {
            return $this;
        }

        return $this;
    }

    public function from(string $table)
    {
        $this->queryParts['from'][] = $table;

        return $this;
    }

    public function where(string $condition)
    {
        $this->queryParts['where']['and'] = [$condition];

        return $this;
    }

    public function andWhere(string $condition)
    {
        $this->queryParts['where']['and'][] = $condition;

        return $this;
    }

    public function orWhere(string $condition)
    {
        $this->queryParts['where']['or'][] = $condition;

        return $this;
    }

    public function distinct(bool $distinct)
    {
        $this->queryParts['distinct'] = $distinct;

        return $this;
    }

    public function having()
    {
        return $this;
    }

    public function andHaving()
    {
        return $this;
    }

    public function orHaving()
    {
        return $this;
    }

    public function groupBy()
    {
        return $this;
    }

    public function orderBy()
    {
        return $this;
    }

    public function limit()
    {
        return $this;
    }

    public function leftJoin()
    {
        return $this;
    }

    public function rightJoin()
    {
        return $this;
    }

    public function innerJoin()
    {
        return $this;
    }

    public function join()
    {
        return $this;
    }
}