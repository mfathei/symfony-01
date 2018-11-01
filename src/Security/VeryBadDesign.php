<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/1/18
 * Time: 11:27 AM
 */

namespace App\Security;


use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class VeryBadDesign implements ContainerAwareInterface
{

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $container->get('app.greeting');
    }
}