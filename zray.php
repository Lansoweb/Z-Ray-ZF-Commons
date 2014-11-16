<?php
namespace ZfCommons;

use Zend\Mvc\MvcEvent;

class ZfCommons
{
    public function storeApplicationExit($context, &$storage) {
        $application = $context['this'];

        $serviceLocator = $application->getServiceManager();
        
        // ZfcUser identity
        if ($serviceLocator->has('zfcuser_auth_service')) {
            $auth = $serviceLocator->get('zfcuser_auth_service');
            if ($auth->hasIdentity()) {
                $storage['zfc-user'][] = ['identity' => $auth->getIdentity()];
            }
            else {
                $storage['zfc-user'][] = ['identity' => 'No identity'];
            }
        }
        
        // ZfcRbac
        if (interface_exists('ZendDeveloperTools\Collector\CollectorInterface') && class_exists('ZfcRbac\Collector\RbacCollector')) {
            $mvcEvent = $application->getMvcEvent();

            if ($mvcEvent instanceof MvcEvent) {

                $collector = new \ZfcRbac\Collector\RbacCollector();
                $collector->collect($mvcEvent);
                $collector->unserialize($collector->serialize());
                $collection = $collector->getCollection();
    
                $storage['zfc-rbac']['settings'] = [
                    'Guest role' => $collection['options']['guest_role'],
                    'Guard protection policy' => $collection['options']['protection_policy']
                ];
                if (count($collection['guards']) > 0) {
                    foreach ($collection['guards'] as $type => $rules) {
                        $storage['zfc-rbac']['guards'] = [$type => $rules];
                    }
                }
                if (count($collection['roles']) > 0) {
                    foreach ($collection['roles'] as $type => $roles) {
                        $storage['zfc-rbac']['roles'] = [$type => $roles];
                    }
                }
                foreach ($collection['permissions'] as $roleName => $permissions) {
                    $storage['zfc-rbac']['permissions'] = [$roleName => $permissions];
                }
            }
        }
    }  
}

$zfcStorage = new ZfCommons();

$zre = new \ZRayExtension("zf-commons");

$zre->setMetadata(array(
    'logo' => __DIR__ . DIRECTORY_SEPARATOR . 'logo.png',
));
$zre->setEnabledAfter('Zend\Mvc\Application::init');

$zre->traceFunction("Zend\Mvc\Application::run",  function(){}, array($zfcStorage, 'storeApplicationExit'));