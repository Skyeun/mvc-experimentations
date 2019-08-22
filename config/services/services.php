<?php

use Core\Database\QueryBuilder;
use Psr\Container\ContainerInterface;

return [
	'QueryBuilder' => function (ContainerInterface $c) {
		return new QueryBuilder();
	},
];