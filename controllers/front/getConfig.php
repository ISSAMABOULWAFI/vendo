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
 
class VendoGetConfigModuleFrontController extends ModuleFrontController
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
            $ViewPageState = filter_var(Configuration::get("Vendo-ViewPage"), FILTER_VALIDATE_BOOLEAN);
            $LeadState = filter_var(Configuration::get("Vendo-Lead"), FILTER_VALIDATE_BOOLEAN);
            $RegistrationState = filter_var(Configuration::get("Vendo-Registration"), FILTER_VALIDATE_BOOLEAN);
            $AddToCartState = filter_var(Configuration::get("Vendo-AddToCart"), FILTER_VALIDATE_BOOLEAN);
            $OrderState = filter_var(Configuration::get("Vendo-Order"), FILTER_VALIDATE_BOOLEAN);
            $CpsState = filter_var(Configuration::get("Vendo-CpsEnabled"), FILTER_VALIDATE_BOOLEAN);
            $DevMode = filter_var(Configuration::get("Vendo-DevMode"), FILTER_VALIDATE_BOOLEAN);


            $response = array(
                'status'  => "success",
                'version' => Configuration::get("Vendo-version"),
                'PS_VERSION' => _PS_VERSION_,
                'config' => array(
                    'ViewPage' => $ViewPageState,
                    'Lead' => $LeadState,
                    'Registration' => $RegistrationState,
                    'AddToCart' => $AddToCartState,
                    'Order' => $OrderState,
                    'CpsEnabled' => $CpsState,
                    'DevMode' => $DevMode,
                    'TrackingUrl' => Configuration::get("Vendo-TrackingUrl"),
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
