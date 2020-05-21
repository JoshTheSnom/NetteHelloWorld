<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI;
use Tracy\Debugger;

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

	public function registrationFormSucceeded(UI\Form $form, \stdClass $values): void
	{
		Debugger::barDump($values);
		$this->flashMessage('Byl jste uspesne registrovan.');
		$this->redirect('Text:');
		$values->name;
		
		
	}
	
	protected function createComponentLoginForm(): UI\Form
	{
		$form = new UI\Form;
		$form->addText('name', 'Jmeno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('login', 'Login');
		$form->onSuccess[] = [$this, 'loginFormSucceeded'];
		return $form;
	}

	public function loginFormSucceeded(UI\Form $form, \stdClass $values): void
	{
		Debugger::barDump($values);
		
		$this->flashMessage('Byl jste uspesne prihlasen.');
		$this->redirect('Text:');
		$values->name;
		
		
	}
}
