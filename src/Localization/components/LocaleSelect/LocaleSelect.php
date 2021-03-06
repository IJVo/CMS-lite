<?php

namespace Localization;

use App\Components\AControl;
use Kdyby\Doctrine\EntityManager;
use Nette\Application\UI;
use Nette\Utils\ArrayHash;

class LocaleSelect extends AControl
{

	/** @var EntityManager */
	private $em;

	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}

	public function render(array $parameters = NULL)
	{
		$this->template->render(__DIR__ . '/LocaleSelect.latte');
	}

	protected function createComponentLocaleSelect()
	{
        $locales = $this->em->getRepository(Locale::class)->findPairs('code');
        $locale  = $this->presenter->locale;

		$form = new UI\Form;
		$form->addSelect('locales', NULL,
			array_map(function ($locale) {
				return mb_strtoupper($locale);
			}, $locales)
		)->setDefaultValue(($locale !== FALSE) ? array_search($this->presenter->locale, $locales) : NULL);

        $form->onSuccess[] = function (UI\Form $form, ArrayHash $values) use ($locales) {
			$this->presenter->locale = $locales[$values->locales];
			$this->redirect('this');
		};
		return $form;
	}

}

interface ILocaleSelectFactory
{
	/** @return LocaleSelect */
	function create();
}
