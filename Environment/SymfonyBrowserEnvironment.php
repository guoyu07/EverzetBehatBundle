<?php

namespace Bundle\Everzet\BehatBundle\Environment;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Framework\Client;

use Everzet\Behat\Environment\WorldEnvironment;

/*
 * This file is part of the EverzetBehatBundle.
 * (c) 2010 Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Symfony Browser Environment for Behat.
 *
 * @author      Konstantin Kudryashov <ever.zet@gmail.com>
 */
class SymfonyBrowserEnvironment extends WorldEnvironment
{
    public $client;
    protected $kernel;

    /**
     * Initialize Browser Environment.
     * 
     * @param   Container   $container          container interface
     * @param   array       $kernelOptions      kernel creation options
     * @param   array       $serverParameters   server parameters
     */
    public function __construct($container, array $kernelOptions = array(), array $serverParameters = array())
    {
        $this->client = $this->createClient(
            get_class($container->getKernelService())
          , $kernelOptions
          , $serverParameters
        );

        $this->pathTo = function($page) {
            switch ($page) {
                case 'homepage':    return '/';
                default:            return $page;
            }
        };
    }

    /**
     * Create a Client. 
     * 
     * @param   string      $kernelClass        kernel class name
     * @param   array       $kernelOptions      kernel creation options
     * @param   array       $serverParameters   server parameters
     *
     * @return  Client                          A Client instance
     */
    public function createClient($kernelClass, array $kernelOptions = array(), array $serverParameters = array())
    {
        $this->kernel = $this->createKernel($kernelClass, $kernelOptions);
        $this->kernel->boot();

        $client = $this->kernel->getContainer()->getTest_ClientService();
        $client->setServerParameters($serverParameters);
        $client->followRedirects(false);

        return $client;
    }

    /**
     * Create a Kernel. 
     * 
     * @param   string      $class              kernel class
     * @param   array       $options            an array of options
     *
     * @return  HttpKernelInterface a HttpKernelInterface instance
     */
    protected function createKernel($class, array $options = array())
    {
        return new $class(
            isset($options['environment'])  ? $options['environment']   : 'test'
          , isset($options['debug'])        ? $optoins['debug']         : true
        );
    }
}
