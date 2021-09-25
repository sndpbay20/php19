<?php

namespace app\controllers;
use app\models\product;

use app\Router;

class ProductController
{
    public function index(Router $router)
    {

        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);
     $router->renderView('products/index',[
         'products' => $products,    
         'search' => $search
        ]);
    }

    public function create(Router $router)
    {
        $errors = [];
        $productData = [
            'title'=> '',
            'description' => '',
            'image' => '',
            'price' => '',
        ];
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = (float)$_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
           if(empty($errors)){
            header('Location: /products');
            exit;
        }
        }

        $router->renderView('products/create',[
            'Product' => $productData,    
            'errors' => $errors
           ]);
    }
    
    public function update()
    {
        echo "Update page";
    }

    public function delete()
    {
        echo "Delete page";
    }
}
   