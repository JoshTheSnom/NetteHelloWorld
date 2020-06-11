<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class TextPresenter extends Nette\Application\UI\Presenter
{
    public function actionDefault() {
        if($this->getUser()->isLoggedIn() != true) {
			$this->redirect('User:login');
		}
    }


}
