<?php

namespace Articles\Query;

use Doctrine\ORM\NativeQuery;
use Kdyby;
use Users\User;

class ArticlesQuery extends Kdyby\Doctrine\QueryObject
{

	/**
	 * @var array|\Closure[]
	 */
	private $filter = [];

	/**
	 * @var array|\Closure[]
	 */
	private $select = [];

	public function byAuthor(User $user)
	{
		$this->filter[] = function (Kdyby\Doctrine\QueryBuilder $qb) use ($user) {
			$qb->andWhere('authors.id = :user')->setParameter('user', $user->getId());
		};
		return $this;
	}

	public function withAllAuthors()
	{
		$this->select[] = function (Kdyby\Doctrine\QueryBuilder $qb) {
			// leftJoin, because author is optional (innerJoin otherwise)
			$qb->leftJoin('article.authors', 'authors')->addSelect('authors');
		};
		return $this;
	}

	/**
	 * @param \Kdyby\Persistence\Queryable $repository
	 *
	 * @return \Doctrine\ORM\Query|\Doctrine\ORM\QueryBuilder
	 */
	protected function doCreateQuery(Kdyby\Persistence\Queryable $repository)
	{
		$qb = $this->createBasicDql($repository);
		foreach ($this->select as $modifier) {
			$modifier($qb);
		}
		$qb->addOrderBy('article.createdAt', 'DESC');
		return $qb;
	}

	/**
	 * @param Kdyby\Persistence\Queryable $repository
	 *
	 * @return NativeQuery
	 */
	protected function doCreateCountQuery(Kdyby\Persistence\Queryable $repository)
	{
		$qb = $this->createBasicDql($repository)
			->select('COUNT(article.id) AS total_count');
		return $qb;
	}

	/**
	 * @param Kdyby\Persistence\Queryable|Kdyby\Doctrine\EntityDao $repository
	 *
	 * @return Kdyby\Doctrine\NativeQueryBuilder
	 */
	private function createBasicDql(Kdyby\Persistence\Queryable $repository)
	{
		$qb = $repository->createQueryBuilder('article', 'article.id');
		foreach ($this->filter as $modifier) {
			$modifier($qb);
		}
		return $qb;
	}

	/**
	 * @param Kdyby\Persistence\Queryable $repository
	 * @param \Iterator $iterator
	 *
	 * @see https://github.com/Kdyby/Doctrine/blob/master/docs/en/optimizing-query-objects.md
	 */
	public function postFetch(Kdyby\Persistence\Queryable $repository, \Iterator $iterator)
	{
//		$ids = array_keys(iterator_to_array($iterator, TRUE));
	}

}
