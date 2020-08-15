<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Forms;
use Nette;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\ComponentModel\IComponent;
use Nette\Security\Passwords;

final class SignPresenter extends BasePresenter
{
    /** @persistent */
    public string $backlink = '';

    /** @inject */
    public Forms\SignInFormFactory $signInFactory;

    /** @inject */
    public Forms\SignUpFormFactory $signUpFactory;

    /** @inject */
    public Nette\Database\Context $database;


    /**
     * Sign-in form factory.
     */
    protected function createComponentSignInForm(): Form
    {
        $form = new BootstrapForm;
        /*$form->renderMode = RenderMode::Vertical;*/
        $form->addText('email', 'Email:')
            ->setRequired('Zadajte svoj email.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('zadajte svoje heslo.');

        $form->addSubmit('send', 'Prihlásiť');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];
        return $form;
    }

    protected function createComponentSignUpForm(): Form
    {
        $form = $this->signUpFactory->createComponentSignUpForm();
        $form->onSuccess[] = function () {
            $this->flashMessage('Boli ste zaregistrovaný', 'success');
            $this->redirect('Homepage:');
        };

        return $form;
    }

    /**
     * Sign-up form factory.
     */
    /**protected function createComponentSignUpForm(): Form
     * {
     * return $this->signUpFactory->create(function (): void {
     * $this->redirect('Homepage:');
     * });
     * }*/


    public function actionOut(): void
    {
        $this->getUser()->logout();
    }
}

