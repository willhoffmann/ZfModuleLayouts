<?php
namespace ZfModuleLayouts;

class Module
{
    public function onBootstrap($event)
    {
        $event->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractController', 'dispatch', function($event) {
            $controller      = $event->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));

            $serviceManager  = $event->getApplication()->getServiceManager();
            $config          = $serviceManager->get('config');

            if (isset($config['module_view_manager'][$moduleNamespace]['layout'])) {
                $controller->layout($config['module_view_manager'][$moduleNamespace]['layout']);
            }
        }, 100);
    }
}