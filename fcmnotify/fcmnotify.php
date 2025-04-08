<?php

if (!defined('_PS_VERSION_')) {
    exit;
}

use GuzzleHttp\Client;

class FcmNotify extends Module
{
    public function __construct()
    {
        $this->name = 'fcmnotify';
        $this->version = '1.0.0';
        $this->author = 'Samuel Calderón';
        $this->need_instance = 0;
        parent::__construct();

        $this->displayName = $this->l('Firebase Notification');
        $this->description = $this->l('Send FCM push notifications on order status update.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('actionOrderStatusPostUpdate');
    }

    public function hookDisplayHeader()
    {
        return $this->context->smarty->fetch($this->local_path . 'views/templates/hook/displayHeader.tpl');
    }

    public function hookActionOrderStatusPostUpdate($params)
    {
        $token = 'TOKEN_DISPOSITIVO';

        $client = new Client();
        $res = $client->post('https://fcm.googleapis.com/fcm/send', [
            'headers' => [
                'Authorization' => 'key=TU_SERVER_KEY',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $token,
                'notification' => [
                    'title' => 'Pedido actualizado',
                    'body' => 'Tu pedido ha cambiado de estado.',
                    'icon' => '/img/logo.png',
                ]
            ]
        ]);

        return true;
    }
}