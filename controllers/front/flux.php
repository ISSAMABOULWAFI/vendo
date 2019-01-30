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
 
error_reporting(0);

class VendoFluxModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->display_column_left = false;
        $this->display_column_right = false;
        $this->display_header = false;
        $this->display_footer = false;
    }

    public function initContent()
    {
        parent::initContent();
        if (Tools::getValue('vToken') == Configuration::get("Vendo-TOKEN")) {
            if (Tools::getValue('params')) {
                if (Tools::getValue('page') && Tools::getValue('size')) {
                    $start = ( Tools::getValue(page) -1) * Tools::getValue(size);
                    $size  = Tools::getValue(size);
                } else {
                    $start = 0;
                    $size = 0;
                }
                header('Content-Type: application/json');
                header('HTTP/1.1 201 Created');
                
                $products_partial1 = Product::getProducts($this->context->language->id, 0, 0, 'id_product', 'desc', false, true);
                $totalProducts = count(Product::getProductsProperties($this->context->language->id, $products_partial1));
                
                $products_partial  = Product::getProducts($this->context->language->id, $start, $size, 'id_product', 'desc', false, true);
                
                $products = Product::getProductsProperties($this->context->language->id, $products_partial);


                $result = array();
                $link = new Link();
                if (Tools::getValue('params') == "all") {
                    foreach ($products as $key => $product) {
                        $result[$key] = $product;
                        $new_product = new ProductCore($product['id_product']);
                        $images = $new_product->getImages($this->context->language->id);
                        $result[$key]['images']  = array();
                        foreach ($images as $img) {
                            array_push($result[$key]['images'], Tools::getShopProtocol() .  $link->getImageLink($product["link_rewrite"], $img['id_image']));
                        }
                        $image = Image::getCover($product['id_product']);
                        $imagePath = $link->getImageLink($product["link_rewrite"], $image['id_image']);
                        $result[$key]['product_image'] = Tools::getShopProtocol() . $imagePath;
                    }
                    $resp = array();
                    $resp['products'] = $result;
                    $resp['itemsCount'] = count($products);
                    if (Tools::getValue("size")) {
                        if ($totalProducts > count($products)) {
                            $resp['pages'] = ceil($totalProducts / $size);
                        } else {
                            $resp['pages'] = 1;
                        }
                    }
                    print_r(Tools::jsonEncode($resp));
                } else {
                    $params = explode(',', Tools::getValue('params'));
                    foreach ($products as $key => $product) {
                        $new_product = new ProductCore($product['id_product']);
                        $images = $new_product->getImages($this->context->language->id);
                        $result[$key]['images']  = array();
                        foreach ($images as $img) {
                            array_push($result[$key]['images'], Tools::getShopProtocol() .  $link->getImageLink($product["link_rewrite"], $img['id_image']));
                        }
                        $image = Image::getCover($product['id_product']);
                        $imagePath = $link->getImageLink($product["link_rewrite"], $image['id_image']);
                        foreach ($params as $param) {
                            $result[$key][$param] = $product[$param];
                        }
                        $result[$key]['product_image'] = Tools::getShopProtocol() . $imagePath;
                    }

                    $resp['products'] = $result;
                    $resp['itemsCount'] = count($products);
                    if (Tools::getValue("size")) {
                        if ($totalProducts > count($products)) {
                            $resp['pages'] = ceil($totalProducts / $size);
                        } else {
                            $resp['pages'] = 1;
                        }
                    }
                    print_r(Tools::jsonEncode($resp));
                }
            } else {
                header('HTTP/1.1 404 Not Found');
                echo '404 Not Found';
            }
        } else {
            header('HTTP/1.1 403 Forbidden');
            echo '403 Forbidden';
        }
    }
}
