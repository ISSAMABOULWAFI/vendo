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
 
class VendoSetConfigModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->display_column_left =     false;
        $this->display_column_right = false;
        $this->display_header = false;
        $this->display_footer = false;
    }

    public function initContent()
    {
        parent::initContent();
        if (Tools::getValue('vToken') == Configuration::get("Vendo-TOKEN")) {
            $configName = Tools::getValue('configName');
            $configValue = filter_var(Tools::getValue('configValue'), FILTER_VALIDATE_BOOLEAN);
            
            if ($configName == "Vendo-DevMode") {
                if ($configValue == true) {
                    Configuration::updateValue('Vendo-TrackingUrl', '//dev-tracking.vendo.ma');
                } else {
                    Configuration::updateValue('Vendo-TrackingUrl', '//tracking.vendo.ma');
                }
            }

            //Set Config Value
            Configuration::updateValue($configName, $configValue);

            $response = array(
                'status'  => "success",
                'version' => Configuration::get("version"),
                'config' => array(
                    $configName => Configuration::get($configName),
                )
            );
            header('Content-Type: application/json');
            header('HTTP/1.1 201 Created');
            echo Tools::jsonEncode($response);
        } else {
            $response = "403 Forbidden";
            header('Content-Type: application/json');
            header('HTTP/1.1 403 Forbidden');
            echo Tools::jsonEncode($response);
        }
    }
}
