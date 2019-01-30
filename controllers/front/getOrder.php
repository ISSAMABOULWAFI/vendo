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
 
class VendoGetOrderModuleFrontController extends ModuleFrontController
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

            // Get order status by Id
            if (Tools::getValue('orderId')) {
                if(intval(Tools::getValue('orderId')) >= 0){
                     $response['orderId'] = Tools::getValue('orderId');
                     $order = new Order(Tools::getValue('orderId'));

                    if (isset($order->date_add)) {
                         $orderState = new OrderState($order->getCurrentState());
                         $response['updateDate'] = $order->date_upd;
                         $response['orderDate'] = $order->date_add;
                         $products = OrderDetail::getList(Tools::getValue('orderId'));
                         $prods = array();
                         $total = 0;
                        foreach ($products as $product) {
                             $data = array(
                                'ref'=> $product["product_id"],
                                'qte'=> (float)($product["product_quantity"]),
                                'price'=> (float)($product["unit_price_tax_incl"])
                            );
                            $total += $product["total_price_tax_incl"];
                            array_push($prods, $data);
                        }
                         $response['total'] = $total;
                         $status = new stdClass();
                         $status->paid = (string)$orderState->paid;
                         
                         $status->shipped = (string)$orderState->shipped;
                         $status->canceled = '0';
                         $status->standby = '0';
                         $response['orderStatus'] = $status;
                         $response['lastStatusName'] = $orderState->name["1"];
                         $response['items'] = $prods;
                         $response['status'] = 'success';
                    }
                }else{
                    $response['status'] = 'No Order';
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
