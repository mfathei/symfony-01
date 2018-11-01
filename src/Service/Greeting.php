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
    private $message;

    public function __construct(LoggerInterface $logger, string $message)
    {
        $this->logger = $logger;
        $this->message = $message;
    }
    public function greet(string $name): string
    {
        $this->logger->info("Greeted $name.");
        return "{$this->message} $name";
    }
}