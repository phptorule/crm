<?php

namespace App\Services;

use Goutte\Client;
use App\Currency;
use Illuminate\Support\Facades\Storage;

class CoursesService
{
    protected static $currency_list = [];
    protected static $course = 1;

    public static function convert($amount, $currency_id, $course = FALSE)
    {
        if ( ! self::isMainCurrency($currency_id))
        {
            $client = new Client();
            $crawler = $client->request('GET', 'http://rulya-bank.com.ua/');
            $crawler->filter('#ltbl')->filter('tr > td font')->each(function($node, $i) use ($currency_id, $course) {
                if (self::currencyName($currency_id) == strtoupper($node->text()))
                {
                    $node->parents()->each(function($node, $i) use ($course) {
                        if ($node->nodeName() == 'tr')
                        {
                            $node->filter('td.tbl')->each(function($node, $i) use ($course) {
                                if ($i == 0)
                                {
                                    self::setCourse(trim($node->text()));
                                }
                            });
                        }
                    });
                }
            });

            $amount = round($amount * self::getCourse($course), 2);
        }

        return $amount;
    }

    public static function getCourse($course = FALSE)
    {
        return empty($course) ? self::$course : $course;
    }

    public static function setCourse($course)
    {
        self::$course = $course;
    }

    protected static function currency()
    {
        if (empty(self::$currency_list))
        {
            self::$currency_list = Currency::all();
        }
        return self::$currency_list;
    }

    protected static function currencyName($currency_id)
    {
        foreach (self::currency() as $row)
        {
            if ($currency_id == $row->currency_id)
            {
                return strtoupper($row->currency_name);
            }
        }

        return '';
    }

    protected static function isMainCurrency($currency_id)
    {
        foreach (self::currency() as $row)
        {
            if ($currency_id == $row->currency_id)
            {
                return $row->currency_main == 1;
            }
        }

        return FALSE;
    }
}
