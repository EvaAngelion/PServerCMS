<?php
/**
 * Created by PhpStorm.
 * User: †KôKšPfLâÑzè®
 * Date: 02.12.2014
 * Time: 21:17
 */

namespace PServerCMS\Entity\Repository;

use Doctrine\ORM\EntityRepository;


class SecretAnswer extends EntityRepository {

	/**
	 * @return \PServerCMS\Entity\SecretAnswer|null
	 */
	public function getAnswer4UserId( $userId ){
		$oQuery = $this->createQueryBuilder('p')
			->select('p')
			->where('p.user = :user')
			->setParameter('user', $userId)
			->getQuery();
		return $oQuery->getOneOrNullResult();
	}
} 