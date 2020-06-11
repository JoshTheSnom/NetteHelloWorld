<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI;
use Tracy\Debugger;
use Nette\Security\User;
use App\UserStuff;

final class UserPresenter extends Nette\Application\UI\Presenter
{
	
	protected function createComponentRegistrationForm(): UI\Form
	{
		$form = new UI\Form;
		$form->addText('name', 'Jmeno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('login', 'Registrovat');
		$form->onSuccess[] = [$this, 'registrationFormSucceeded'];
		return $form;
	}

	/** @var UserStuff @inject */
	public $userStuff;

	public function registrationFormSucceeded(UI\Form $form, \stdClass $values): void
	{
		Debugger::barDump($values);
		
		$this->userStuff->saveUser($values->name,$values->password);
		$this->flashMessage('Byl jste uspesne registrovan.');
		$this->redirect('Text:');
		
	}
	
	protected function createComponentLoginForm(): UI\Form
	{
		$form = new UI\Form;
		$form->addText('name', 'Jmeno:')
			->setRequired('Prosim vyplnte sve uzivatelske jmeno.');
		$form->addPassword('password', 'Heslo:')
			->setRequired('Prosim vyplnte sve heslo.');
		$form->addSubmit('login', 'Login');
		$form->onSuccess[] = [$this, 'loginFormSucceeded'];
		return $form;
	}

	public function loginFormSucceeded(UI\Form $form, \stdClass $values): void
	{
		Debugger::barDump($values);
		try {
			$this->getUser()->login($values->name, $values->password);
			
			$this->flashMessage('Byl jste uspesne prihlasen.');
			//$this->flashMessage($values->name);
			$this->redirect('Text:');
			$values->name;
		} catch (Nette\Security\AuthenticationException $e) {
			$this->flashMessage('Spatny username nebo heslo');
		}
	}

	public function actionLogout() {
		$this->getUser()->logout();
		$this->redirect('login');
	}

	public function actionLogin() {
		if($this->getUser()->isLoggedIn()) {
			$this->redirect('Text:');
		}
	}
	
	public function actionRegister() {
		if($this->getUser()->isLoggedIn()) {
			$this->redirect('Text:');
		}
	}
}