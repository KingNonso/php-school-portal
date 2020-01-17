<?php

class Controller {

    function __construct() {
        //echo 'Main Controller <br/>';
        $this->view = new View();
        $this->deviceType = View::getInstance();
    }

    public function loadModel($name){
        $path = 'models/'.$name.'_model.php';
        $modelName = $name.'_Model';

        if(class_exists($modelName)){
            $this->model = new $modelName();
        }else{
            if(file_exists($path)){
                require $path;

                $this->model = new $modelName();
            }else{
                require 'controllers/error.php';
                $controller = new Error();
                return false;
            }

        }

    }
    public function reMapRouteToModel($name){

        $path = 'models/'.$name.'_model.php';
        $modelName = $name.'_Model';

        if(class_exists($modelName)){
            $this->$name = new $modelName();
            //$this->reMappedRoute = new $modelName();

        }else{
            if(file_exists($path)){
                require $path;
                //$this->reMappedRoute = new $modelName();
                $this->$name = new $modelName();
            }else{
                require 'controllers/error.php';
                $controller = new Error();
                return false;
            }

        }

    }

}

