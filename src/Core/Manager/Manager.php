<?php


namespace Core\Manager;


use Core\Database\QueryBuilder;

class Manager
{
	private $_entityName;

	private $_class;

	private $_alias;

	private $_queryBuilder;

	protected function __construct(string $model)
	{
		$this->_class = $model;
		$this->_entityName = $this->generateEntityName();

		$this->_queryBuilder = new QueryBuilder();
	}

	protected function createQueryBuilder(?string $alias = null): QueryBuilder
	{
		$this->_alias = $alias;

		return $this->_queryBuilder->from($this->_entityName, $alias);
	}

	protected function find(int $id): object
	{
		return $this->_queryBuilder
			->from($this->_entityName, $this->_alias)
			->where('id = :id')
			->parameters(['id' => $id])
			->execute();
	}

	protected function findBy(array $criteria): array
	{
		$builder = $this->_queryBuilder->from($this->_entityName, $this->_alias);

		foreach ($criteria as $key => $value) {
			$builder->where("$key = :$key");
		}

		return $builder->parameters($criteria)->execute();
	}

	protected function findOneBy(array $criteria): object
	{
		$builder = $this->_queryBuilder->from($this->_entityName, $this->_alias)->limit(1);

		foreach ($criteria as $key => $value) {
			$builder->where("$key = :$key");
		}

		return $builder->parameters($criteria)->execute();
	}

	protected function findAll(): array
	{
		return $this->findBy([]);
	}

	protected function count(array $criteria): int
	{
		return sizeof($this->findBy($criteria));
	}

	private function generateEntityName(): string
	{
		$parts = explode('\\', $this->_class);
		$name = end($parts);

		return strtolower($name);
	}
}