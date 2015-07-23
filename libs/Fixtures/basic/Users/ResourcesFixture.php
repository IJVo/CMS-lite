<?php

use Doctrine\Common\Persistence\ObjectManager;

class ResourcesFixture extends \Doctrine\Common\DataFixtures\AbstractFixture
{

	public function load(ObjectManager $manager)
	{
		$manager->persist((new \Users\Resource())->setName('Admin:Dashboard'));
		$manager->persist((new \Users\Resource())->setName('Options:Options'));
		$manager->persist((new \Users\Resource())->setName('Pages:AdminPage'));
		$manager->persist((new \Users\Resource())->setName('Files:AdminFile'));
		$manager->persist((new \Users\Resource())->setName('Users:Users'));
		$manager->persist((new \Users\Resource())->setName('Navigation:Navigation'));
		$manager->flush();
	}

}
