<?php
namespace Omeka\Service;

use Omeka\Service\Mailer;
use Zend\Mail\Transport\Factory as TransportFactory;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MailerFactory implements FactoryInterface
{
    /**
     * Create the mailer service.
     * 
     * @param ServiceLocatorInterface $serviceLocator
     * @return Mialer
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        if (!isset($config['mail']['transport'])) {
            throw new Exception\ConfigException('Missing mail transport configuration');
        }
        $transport = TransportFactory::create($config['mail']['transport']);
        $defaultOptions = array();
        if (isset($config['mail']['default_message_options'])) {
            $defaultOptions = $config['mail']['default_message_options'];
        }
        return new Mailer($transport, $defaultOptions);
    }
}
