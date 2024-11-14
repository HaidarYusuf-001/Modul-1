<?php 

namespace app\Routes;

include "app/Controller/ProductController.php";

use app\Controller\ProductController;

class ProductRoutes {

    public function handle($method, $path){


        if ($method == 'GET' && $path == '/CodelabMod4/main.php/api/gaming_laptop') {
            $controller = new ProductController();
            echo $controller->index();
        }

        if ($method == 'GET' && strpos($path, '/CodelabMod4/main.php/api/gaming_laptop/') === 0) {
            $pathParts = explode('/', $path);
            $id = $pathParts[count($pathParts) - 1];
            $controller = new ProductController();
            echo $controller->getById($id);
        }

        if ($method == 'POST' && $path == '/CodelabMod4/main.php/api/gaming_laptop') {
            $controller = new ProductController();
            echo $controller->insert();
        }

        if ($method == 'PUT' && strpos($path, '/CodelabMod4/main.php/api/gaming_laptop/') === 0) {
            $pathParts = explode('/', $path);
            $id = $pathParts[count($pathParts) - 1];
            $controller = new ProductController();
            echo $controller->update($id);
        }

        if ($method == 'DELETE' && strpos($path, '/CodelabMod4/main.php/api/gaming_laptop/') === 0) {
            $pathParts = explode('/', $path);
            $id = $pathParts[count($pathParts) - 1];
            $controller = new ProductController();
            echo $controller->delete($id);
        }
    }
}