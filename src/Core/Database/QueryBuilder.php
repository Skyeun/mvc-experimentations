<?php


namespace Core\Database;


class QueryBuilder
{
    /* The query types. */
    const SELECT = 0;
    const DELETE = 1;
    const UPDATE = 2;

	/**
	 * The instance of database connection.
	 *
	 * @var Connector
	 */
    private $connector;

	/**
	 * The query type
	 *
	 * @var integer
	 */
    private $type;

	/**
	 * The query constructed from provided parameters.
	 *
	 * @var string
	 */
    private $query;

	/**
	 * The array of SQL parts collected.
	 *
	 * @var array
	 */
	private $sqlParts = [
		'select'  		=> [],
		'from'    		=> [],
		'join'    		=> [],
		'set'     		=> [],
		'where'   		=> [],
		'groupBy' 		=> [],
		'orderBy' 		=> [],
		'having'  		=> [],
		'distinct' 		=> false,
		'parameters'	=> null,
	];

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

    private $testMode = false;

	/**
	 * @param bool $testMode - Allow QueryBuilder to be used without being connected to a database.
	 */
	public function __construct(bool $testMode = false)
	{
		$this->testMode = $testMode;

		if (!$testMode) {
			$this->connector = Connector::getInstance();
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

    private function getSqlForSelect(): string
    {
    	$sql = ['SELECT'];

    	if ($this->sqlParts['distinct']) {
    		$sql[] = 'DISTINCT';
		}

    	$sql[] = !empty($this->sqlParts['select']) ? join(', ', $this->sqlParts['select']): '*';

    	$sql[] = 'FROM';
    	$sql[] = $this->buildFrom();

		$sql = array_merge($sql, $this->add('groupBy', 'GROUP BY'));
		$sql = array_merge($sql, $this->add('where', 'WHERE'));
		$sql = array_merge($sql, $this->add('having', 'HAVING'));
		$sql = array_merge($sql, $this->add('orderBy', 'ORDER BY'));

		if ($this->maxResults) {
			$sql[] = 'LIMIT';
			$sql[] = $this->maxResults;
		}

        return join(' ', $sql);
    }

    private function getSqlForDelete(): string
    {
        $sql = 'DELETE';

        return $sql;
    }

    private function getSqlForUpdate(): string
    {
        $sql = 'UPDATE';

        return $sql;
    }

    public function execute()
    {
    	if ($this->testMode) {
    		throw new \RuntimeException("Cannot execute request while being in test mode");
		}

        $query = $this->getQuery();

        if ($this->sqlParts['parameters']) {
			return $this->connector->getQueryResults($query, $this->sqlParts['parameters']);
		} else {
			return $this->connector->getQueryResults($query);
		}
    }

    public function select(string $field): self
    {
        $this->type = self::SELECT;

        if (empty($field)) {
            return $this;
        }

        $this->sqlParts['select'][] = $field;

        return $this;
    }

    public function delete(bool $delete = false): self
    {
        $this->type = self::DELETE;

        if (!$delete) {
            return $this;
        }

        return $this;
    }

    public function update(bool $update = false): self
    {
        $this->type = self::UPDATE;

        if (!$update) {
            return $this;
        }

        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
		if ($alias) {
			$this->sqlParts['from'][$alias] = $table;
		} else {
			$this->sqlParts['from'][] = $table;
		}

		return $this;
    }

    public function where(string ...$condition): self
    {
        $this->sqlParts['where'] = array_merge($this->sqlParts['where'], $condition);

        return $this;
    }

	public function parameters(array $parameters): self
	{
		$this->sqlParts['parameters'] = $parameters;

		return $this;
    }

    public function distinct(bool $distinct): self
    {
        $this->sqlParts['distinct'] = $distinct;

        return $this;
    }

    public function having(string ...$condition): self
    {
    	$this->sqlParts['having'] = array_merge($this->sqlParts['having'], $condition);

        return $this;
    }

    public function groupBy(string ...$groupBy): self
    {
    	$this->sqlParts['groupBy'] = array_merge($this->sqlParts['groupBy'], $groupBy);

        return $this;
    }

    public function orderBy(string ...$orderBy): self
    {
		$this->sqlParts['orderBy'] = array_merge($this->sqlParts['orderBy'], $orderBy);

        return $this;
    }

    public function limit(int $limit): self
    {
    	$this->maxResults = $limit;

        return $this;
    }

    public function leftJoin(): self
    {
        return $this;
    }

    public function rightJoin(): self
    {
        return $this;
    }

    public function innerJoin(): self
    {
        return $this;
    }

    public function join(): self
    {
        return $this;
    }

	private function buildFrom(): string
	{
		$from = [];

		foreach ($this->sqlParts['from'] as $key => $value) {
			if (is_string($key)) {
				$from[] = "$value as $key";
			} else {
				$from[] = $value;
			}
		}

		return join(', ', $from);
    }

	private function add(string $partName, string $query): array
	{
		$sql = [];

		if (!empty($this->sqlParts[$partName])) {
			$sql[] = $query;

			$sql[] = "(" . join(') AND (', $this->sqlParts[$partName]) . ")";
		}

		return $sql;
    }
}