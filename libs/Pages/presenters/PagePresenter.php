<?php

namespace Pages\Presenters;

use App\FrontModule\Presenters\BasePresenter;
use Kdyby\Doctrine\EntityManager;
use Latte;
use Nette;
use Nette\Application\UI;
use Nette\Application\UI\ITemplateFactory;
use Pages\Page;
use Pages\Query\PagesQuery;
use Pages\Query\PagesQueryAdmin;

class PagePresenter extends BasePresenter
{

	/** @var EntityManager */
	private $em;

	/** @var ITemplateFactory */
	private $templateFactory;

	public function __construct(EntityManager $em, ITemplateFactory $templateFactory)
	{
		$this->em = $em;
		$this->templateFactory = $templateFactory;
	}

	public function actionDefault($id)
	{
		$pageQuery = (new PagesQuery)->byId($id);
		$page = $this->em->getRepository(Page::class)->fetchOne($pageQuery);
		if ($page === NULL) {
			$this->error('Page not found.');
		}

		if ($page->protected) {
			$this->forward('protected', $page->getId());
		} else {
			$this['meta']->setRobots([
				$page->index, $page->follow,
			]);
			$this->setTitle($page->individualTitle ?: $page->title);
			$this->setMeta('description', $page->description);

//		    $latte = $this->getTemplate()->getLatte(); //Latte\Engine
//		    $latte->setLoader(new Latte\Loaders\StringLoader);
//		    $rendered = $latte->renderToString($page->getBody(), $this->getTemplate()->getParameters());
//		    $this->template->body = Nette\Utils\Html::el()->setHtml($rendered);

			$this->template->page = $page;
		}
	}

	public function actionProtected($id)
	{
		dump($id);
	}

	public function actionPreview($id)
	{
		if (!$this->user->isLoggedIn()) {
			$this->error('Page not found.');
		}
		$pageQuery = (new PagesQueryAdmin)->preview($id, $this->getUser()->getId());
		$page = $this->em->getRepository(Page::class)->fetchOne($pageQuery);
		if ($page === NULL) {
			$this->error('Page not found.');
		}
		$this->setTitle($page->title);
		$this->setMeta('robots', 'noindex');
		$this->template->page = $page;
		$this->setView('default');
	}

	protected function createComponentProtected()
	{
		$form = new UI\Form;
		$form->addSubmit('check', 'Ověřit heslo');
		$form->onSuccess[] = function () {
			$this->redirect('default', 4); //FIXME
		};
		return $form;
	}

}
