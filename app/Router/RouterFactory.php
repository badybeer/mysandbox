<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	use Nette\StaticClass;

	public static function createRouter(): Nette\Application\Routers\SimpleRouter /*RouteList*/
	{
		$router = new Nette\Application\Routers\SimpleRouter('Homepage:default');

		//$router = new RouteList;
		//$router->addRoute('<presenter>/<action>', 'Homepage:default');
		return $router;
	}
}
