<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ExtensionTime extends AbstractExtension
{
    const CONFIGURATION = [
        'format' => 'Y-m-d H:i:s',
    ];
    public function getFilters()
    {
        return [
            new TwigFilter('time', [$this,'timeFormatting']),
        ];
    }

    public function timeFormatting(\DateTime $date, array $configuration = []): string{
        $config = array_merge(self::CONFIGURATION, $configuration);
        $currentDate = new \DateTime();
        $formattedDate = 'Created at '.$currentDate->format($config['format']);
        $diffDatesInSeconds = $currentDate->getTimestamp() - $date->getTimestamp();
        if($diffDatesInSeconds < 60){
            $formattedDate = 'Created '.$diffDatesInSeconds.' seconds ago';
        }elseif($diffDatesInSeconds < 3600){
            $minutes = $diffDatesInSeconds / 60;
            $formattedDate = 'Created '.(int)$minutes.' minutes ago';
        }elseif($diffDatesInSeconds < 86400){
            $hours = $diffDatesInSeconds / 3600;
            $formattedDate = 'Created '.(int)$hours.' hours ago';
        }
        return $formattedDate;
    }
}