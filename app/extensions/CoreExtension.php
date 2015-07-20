<?php

namespace App\Extensions;

use App\Components\Meta\IMetaFactory;
use App\Components\Meta\Providers\IMetasProvider;
use Nette;

class CoreExtension extends Nette\DI\CompilerExtension
{

	private $defaultConfiguration = [
		'https' => TRUE,
	];

	/** @var bool */
	private $debugMode;

	public function __construct($debugMode = FALSE)
	{
		$this->debugMode = $debugMode;
	}

	public function beforeCompile()
	{
		$cb = $this->getContainerBuilder();

		/** @var IMetasProvider $extension */
		foreach ($this->compiler->getExtensions(IMetasProvider::class) as $extension) {
			$definition = $cb->getDefinition($cb->getByType(IMetaFactory::class));
			$definition->addSetup('setMetas', [$extension->getMetas()]);
		}
	}

	public function afterCompile(Nette\PhpGenerator\ClassType $generatedContainer)
	{
		$initialize = $generatedContainer->getMethod('initialize');
		$config = $this->getConfig($this->defaultConfiguration);
		if ($config['https']) {
			$initialize->addBody('Nette\Application\Routers\Route::$defaultFlags = Nette\Application\Routers\Route::SECURED;');
		}
	}

}
