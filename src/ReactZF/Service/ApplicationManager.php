<?php
/**
 * @author     Evgeny Shpilevsky <evgeny@shpilevsky.com>
 * @license    MIT
 * @date       5/7/13 14:53
 */
namespace ReactZF\Service;

use ReactZF\Mvc\Application;
use Zend\Console\Console;
use Zend\Console\Request;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

class ApplicationManager
{

    /**
     * @var ApplicationManagerOptions
     */
    protected $options;

    /**
     * @var array
     */
    protected $configuration;

    /**
     * @param ApplicationManagerOptions $options
     * @param array                     $configuration
     */
    public function __construct(ApplicationManagerOptions $options, array $configuration)
    {
        $this->options = $options;
        $this->configuration = $configuration;
    }

    /**s
     *
     * @param string $name
     *
     * @return \ReactZF\Mvc\Application
     */
    public function createServer($name = 'default')
    {
        Console::overrideIsConsole(false);

        $configuration = $this->configuration;

        $smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();

        $serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));
        $serviceManager->setService('ApplicationConfig', $configuration);
        $serviceManager->get('ModuleManager')->loadModules();

        $application = new Application($configuration, $serviceManager);
        $application->setServerOptions($this->options->getServer($name));

        $allow = $serviceManager->getAllowOverride();

        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('application', $application);
        $serviceManager->setAllowOverride($allow);

        return $application->bootstrap();
    }

    /**
     * Execute all servers
     *
     * @param Request $request
     */
    public function runAll(Request $request)
    {
        foreach ($this->options->getServers() as $name => $server) {
            $command = [];

            $command[] = 'php';
            $command[] = '-f';
            $command[] = escapeshellarg($request->getScriptName());
            $command[] = 'react';
            $command[] = 'start';
            $command[] = escapeshellarg($name);
            $command[] = '>/dev/null 2>/dev/null &';

            system(implode(" ", $command));
        }
    }

}
