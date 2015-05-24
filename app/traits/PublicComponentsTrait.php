<?php

namespace App\Traits;

use App\Components;
use Kdyby;

/**
 * !!! POZOR !!!
 *
 * Tuto traitu je možné použivat jen pro komponenty, které jsou veřejně přístupné pro kohokoliv!
 *
 * !!! POZOR !!!
 */
trait PublicComponentsTrait
{

	use Kdyby\Autowired\AutowireComponentFactories;

	protected function createComponentHeader(Components\Header\IHeaderFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentError404(Components\Error404\IError404Factory $factory)
	{
		return $factory->create();
	}

	protected function createComponentMainMenu(Components\MainMenu\IMainMenuFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentContactForm(Components\ContactForm\IContactFormFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentCss(Components\Css\ICssFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentJs(Components\Js\IJsFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentDoctype(Components\Doctype\IDoctypeFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentSignInForm(Components\SignInForm\ISignInFormFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentFooter(Components\Footer\IFooterFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentFavicon(Components\Favicon\IFaviconFactory $factory)
	{
		return $factory->create();
	}

	protected function createComponentMeta(Components\Meta\IMetaFactory $factory)
	{
		return $factory->create();
	}

}
