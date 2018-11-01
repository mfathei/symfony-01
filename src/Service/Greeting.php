<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/1/18
 * Time: 10:46 AM
 */

namespace App\Service;


use Psr\Log\LoggerInterface;

class Greeting
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    public function greet(string $name): string
    {
        $this->logger->info("Greeted $name.");
        return "Hello $name";
    }
}