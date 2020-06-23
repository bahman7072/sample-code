<?php
/**
 * Created by PhpStorm.
 * User: Bahman
 * Date: 19/04/2020
 * Time: 08:20 PM
 */

namespace App\Notifications\Chanels;


use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Notifications\Notification;

class GhasedakChanel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toGhasedakSms')){
            throw new \Exception('toGhasedakSms not Found');
        }

        $data = $notification->toGhasedakSms($notifiable);

        $message = $data['text'];
        $receptor = $data['phone'];
        $apiKey = config('services.ghasedak.key');
        try
        {
            $lineNumber = "10008566";
            $api = new \Ghasedak\GhasedakApi($apiKey);
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(ApiException $e){
            throw $e;
        }
        catch(HttpException $e){
            throw $e;
        }
    }
}