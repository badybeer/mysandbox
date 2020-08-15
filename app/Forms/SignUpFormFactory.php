<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model;
use Nette;
use Nette\Application\UI\Form;
use Contributte\FormsBootstrap\BootstrapForm;
use Nette\Security\Passwords;


/**
 * @method getParameter(string $string)
 * @method flashMessage(string $string, string $string1)
 * @method redirect(string $string)
 */
final class SignUpFormFactory
{
	use Nette\SmartObject;

	private const PASSWORD_MIN_LENGTH = 7;

	private Model\UserManager $userManager;

    public function __construct(Model\UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

	public function createComponentSignUpForm(): Form
	{
		$form = new BootstrapForm;

		$form->addText('email', 'Email:')
			->setRequired('Zadajte svoj email.');

		$form->addText('first_name', 'Meno:')
			->setRequired('Zadajte svoje meno.');

		$form->addText('last_name', 'Priezvisko:')
			->setRequired('Zadajte svoje priezvisko.');

		$form->addText('phone', 'Phone:')
			->setRequired('Zadajte svoje čislo.');

		$form->addPassword('password', 'Heslo')
			->setRequired('Zadajte svoje heslo.');
		
		$form->onSuccess[] = [$this, 'SignUpFormSucceeded'];
		$form->addSubmit('SignUpForm', 'Registrácia');


		return $form;


	}

	Public function SignUpFormSucceeded($form, $values)
    {
        try {
            $this->userManager->add(
                $values->first_name . $values->last_name,
                $values->email,
                $values->password
            );
        } catch (Model\DuplicateNameException $e) {
            $form->addError('Uživateľ už existuje');
        }
    }
}
