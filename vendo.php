<?php
/**
 * Vendo Shopping Engine
 *
 * @author    Vendo.ma S.A.R.L
 * @copyright Vendo.ma - All Rights reserved
 * @license   LICENSE.txt
 * @version 1.0.7
 *
 */

if (!defined('_PS_VERSION_')) {
    exit;
}
class Vendo extends Module
{
    public function __construct()
    {
        $this->name = 'vendo';
        $this->tab = 'advertising_marketing';
        $this->version = '1.0.7';
        $this->author = 'Vendo.ma S.A.R.L';
        $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.7');
        Configuration::updateValue('Vendo-version', $this->version);

        parent::__construct();

        $this->displayName = $this->l('Vendo Shopping Engine');
        $this->description = $this->l('Link your shop with the shopping search engine Vendo.ma.');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
        $this->module_key = 'b9af08ee111ae0c002d7f1791246ebd7';
    }
    public function install()
    {
        if (!parent::install()) {
            return false;
        } else {
            //Code pour generer le token
            $urlString = Tools::getHttpHost(true).__PS_BASE_URI__;
            $time = time();
            $milliseconds = round(microtime(true) * 1000);
            $final = $urlString + $milliseconds + $time;
            $hash = "";
            
            if (Configuration::get('Vendo-TOKEN')) {
                $hash = Configuration::get('Vendo-TOKEN');
            } else {
                $hash = md5($final);
            }
            if (Configuration::hasKey('Vendo-DevMode')) {
                $devMode = Configuration::get('Vendo-DevMode');
                $trackUrl = Configuration::get('Vendo-TrackingUrl');
            } else {
                $devMode = true;
                $trackUrl = '//dev-tracking.vendo.ma';
            }
            return true &&
            $this->registerHook('OrderConfirmation') &&
            $this->registerHook('header') &&
            $this->registerHook('displayCustomerAccount')&&
            $this->registerHook('actionCustomerAccountAdd')&&
            $this->registerHook('registrationHook')&&
            $this->registerHook('displayBackOfficeHeader') &&
            $this->registerHook('displayShoppingCart') &&
            $this->registerHook('actionOrderStatusPostUpdate') &&
            $this->registerHook('actionObjectCartUpdateAfter') &&
            $this->registerHook('displayAddToCart') &&
            Configuration::updateValue('Vendo-TOKEN', $hash) &&
            Configuration::updateValue('Vendo-ViewPage', false) &&
            Configuration::updateValue('Vendo-TrackingUrl', $trackUrl) &&
            Configuration::updateValue('Vendo-DevMode', $devMode);
        }
    }
    public function uninstall()
    {
        if (!parent::uninstall()) {
            return false;
        } else {
            return true;
        }
    }
    
    
    public function getContent()
    {
        $output = null;
        //Save Settings -- Update ViewPage & Order values (true/false)
        if (Tools::isSubmit('submit'.$this->name)) {
            $values = array('Vendo-ViewPage','Lead','Registration','AddToCart');
            foreach ($values as $val) {
                Configuration::updateValue($val, Tools::getValue($val));
            }
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }
        $this->context->smarty->assign('folder', $this->_path);
        return $this->display(__FILE__, 'landingPage.tpl');
    }
    public function hookDisplayOrderConfirmation($order)
    {
        //Hook qui execute le script d'order tracking
        $ps_version = _PS_VERSION_;
        if (Tools::substr($ps_version, 0, 3) == '1.7') {
            if (isset($order["order"]) && gettype($order["order"]) == 'object') {
                $orderId = $order["order"]->id;
            }else{
                $orderId = -1;
            }
        } elseif (Tools::substr($ps_version, 0, 3) == '1.6' || Tools::substr($ps_version, 0, 3) == '1.5') {
            if (isset($order["objOrder"]) && gettype($order["objOrder"]) == 'object') {
                $orderId = $order["objOrder"]->id;
            }else{
                $orderId = -2;
            }
        }else{
            $orderId = -3;
        }
            
        $this->context->smarty->assign('order_id', $orderId);

        return $this->display(__FILE__, 'order.tpl');
        
    }
    public function hookDisplayHeader()
    {
        //hook qui execute le script viewPage
        return $this->display(__FILE__, 'html.tpl');
    }
    public function hookDisplayShoppingCart()
    {
        //hook qui execute le script viewPage
        return $this->display(__FILE__, 'addToCart.tpl');
    }
    public function hookDisplayBackOfficeHeader()
    {
            //hook pour ajouter notre css
         $this->context->controller->addCss($this->_path.'views/css/style.css');
    }
    public function hookActionOrderStatusPostUpdate($params)
    {

        $url = 'https:' . Configuration::get('Vendo-TrackingUrl') . '/notifyOrderUpdate';
        $data = array(
            'jwt' => Configuration::get('Vendo-jwt'),
            'orderId' => $params['id_order']
            );
        $options = array(
                   'http' => array(
                   'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                   'method'  => 'POST',
                   'content' => http_build_query($data)
                   )
                 );
         $context  = stream_context_create($options);
         $result =  Tools::file_get_contents($url, false, $context);
        if ($result) {
        }
    }
    public function hookDisplayAddToCart($params)
    {
        return $this->display(__FILE__, 'addToCart.tpl');
    }
}
