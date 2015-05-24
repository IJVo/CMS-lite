<?php

use Test\PresenterTester;

$container = require __DIR__ . '/../../bootstrap.php';

/**
 * @testCase
 */
class DashboardPresenter extends Tester\TestCase
{

	private $tester;

	public function __construct(Nette\DI\Container $container)
	{
		$this->tester = new PresenterTester($container, 'Admin:Dashboard');
	}

	public function setUp()
	{
		$this->tester->logIn();
	}

	public function testRenderDefault()
	{
		$this->tester->testAction('default');
	}

}

(new DashboardPresenter($container))->run();