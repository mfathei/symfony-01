<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/1/18
 * Time: 4:04 PM
 */

namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter('price', [$this, 'priceFilter'])];
    }

    public function priceFilter($number)
    {
        return '$'. number_format($number, 2, '.', ',');
    }
}