<?php

namespace MazeDEV\NavigationMiddleware\Navigation;

use Knp\Menu\MenuFactory;
use Knp\Menu\Renderer\ListRenderer;
use MazeDEV\SessionAuth\SessionAuthMiddleware;

class Navigation
{
	private $data;

	private $activeRoute;

	private $routeParams;

	private $router;

	private $debug;

	private SessionAuthMiddleware $sessionAuthMiddleware;

	public function __construct($naviStructure, $router, SessionAuthMiddleware $sessionAuthMiddleware = null, $debug = false)
	{
		$this->data = $naviStructure;
		$this->router = $router;
		$this->debug = $debug;
		$this->sessionAuthMiddleware = $sessionAuthMiddleware;
	}

	/**
	 * Setzt die aktive Route.
	 *
	 * @param string $activeRoute
	 */
	public function setRoute(string $activeRoute)
	{
		$this->activeRoute = $activeRoute;
	}

	/**
	 * Setzt die übergebenen Parameter.
	 *
	 * @param array $routeParams
	 */
	public function setParams(array $routeParams)
	{
		$this->routeParams = $routeParams;
	}

	/**
	 * Gibt die momentane Route wieder.
	 *
	 * @return mixed
	 */
	public function getRoute(): string
	{
		return $this->activeRoute;
	}

	/**
	 * Gibt die momentan vorhanden Parameter zurück.
	 *
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->routeParams;
	}

	public function render($menu = null, array $childs = [])
	{

		$entries = $this->data;
		if($menu != null)
		{
			$entries = $childs;
		}
		else
		{
			$factory = new MenuFactory();
			$menu = $factory->createItem('My menu', [
				'childrenAttributes' => [
					'class' => 'nav nav-pills nav-sidebar flex-column'
				]
			]);
		}

		foreach ($entries as $key => $item)
		{
			try
			{
				if(!isset($item['routeArguments']))
				{
					$item['routeArguments'] = [];
				}

				if(isset($item['route']))
				{
					if($this->sessionAuthMiddleware != null && $this->sessionAuthMiddleware::$permissionManager->getFetchedData() && !$this->sessionAuthMiddleware::$permissionManager->userHasPermission($item['route']))
					{
						continue;
					}
					$item['uri'] = $this->router->generateUri($item['route'], $item['routeArguments']);
				}

				if (isset($item['route']) && strpos($this->activeRoute, $item['route']) !== false)
				{
					$menu->addChild($key, $item)->setCurrent(true);
				}
				else
				{
					$menu->addChild($key, $item);
				}
				if(isset($item['linkAttributes']))
				{
					if(isset($item['linkAttributes']['id']))
					{
						$menu[$key]->setLabelAttribute('id', $item['linkAttributes']['id']);
					}
					if(isset($item['linkAttributes']['class']))
					{
						$menu[$key]->setLabelAttribute('id', $item['linkAttributes']['id']);
					}
				}
				if(isset($item['display']))
				{
					$menu[$key]->setExtra('safe_label', true);
					$menu[$key]->setLabel('<i class="' . $item['display'] . '"></i>' .  $key);
				}

				if (isset($item['childs']))
				{
					$this->render($menu, $item['childs']);
				}
			}
			catch (\Exception $e)
			{
				if ($this->debug)
				{
					throw new \Exception($e->getMessage());
				}
			}
		}
		$renderer = new ListRenderer(new \Knp\Menu\Matcher\Matcher());

		return $renderer->render($menu,['allow_safe_labels' => true]);
	}
}
