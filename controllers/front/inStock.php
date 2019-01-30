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
 
class VendoinStockModuleFrontController extends ModuleFrontController
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
            $response = array();
            $prodQuantity= Product::getQuantity((Tools::getValue('productId')));
            $prod = new Product((Tools::getValue('productId')));
            
            if (isset($prod->active)) {
                $visibility = $prod->visibility;
                $active = $prod->active;
                $indexed = $prod->indexed;
                $available = $prod->available_for_order;
                if ($prodQuantity > 0 && $visibility != 'none' && $active == 1 && $indexed == 1 && $available == 1) {
                    $response['available'] = true;
                } else {
                    $response['available'] = false;
                }
            }
                
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
