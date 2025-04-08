<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class WhatsappNotification extends Module
{
    public function __construct()
    {
        $this->name = 'whatsappnotification';
        $this->version = '1.0.0';
        $this->author = 'TuNombre';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('WhatsApp Notification');
        $this->description = $this->l('Send WhatsApp messages when an order is validated.');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('actionValidateOrder');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    public function hookActionValidateOrder($params)
    {
        $order = $params['order'];
        $customer = new Customer((int) $order->id_customer);
        $phone = $customer->phone_mobile; // Asegúrate de tener este campo en tu tienda

        if (!$phone) return;

        $message = "Hola " . $customer->firstname . ", gracias por tu pedido #" . $order->id . ". ¡Estamos procesándolo!";
        $this->sendWhatsappMessage($phone, $message);
    }

    private function sendWhatsappMessage($phone, $message, $customerName)
    {
        $firebaseUrl = 'https://us-central1-tuapp.cloudfunctions.net/sendWhatsapp';
    
        $payload = [
            'phone' => $phone,
            'message' => $message,
            'customerName' => $customerName,
        ];
    
        $ch = curl_init($firebaseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = curl_exec($ch);
        curl_close($ch);
    
        // Puedes loguear la respuesta si quieres depurar
        PrestaShopLogger::addLog('Respuesta Firebase: ' . $response);
    }
    
}
