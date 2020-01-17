<?php

class Bootstrap {

	function __construct() {

		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
		$url = explode('/', $url);

		//if no path is set

		if (empty($url[0])) {
			require 'controllers/index.php';
			$controller = new Index();
            $controller->loadModel('index');
			$controller->index();
			return false;
		}

		$file = 'controllers/' . $url[0] . '.php';
		if (file_exists($file)) {
			require $file;
		} else {
            //this means we are not calling any classes from our controller
            //hence we are free to load a class without any one knowing
            if(require 'controllers/church.php' ){
                $controller = new Church();
                $controller->loadModel('church');
                //breakdown of url, 0=year, 1=month, 2=day, 3=title
                $url[0] = (isset($url[0]))? $url[0] : null;
                $controller->location($url[0]);
                return false;
            }else{
                //if we are unable to do the above
                //die(print_r($data));

                $this->error();
                return false;
            }
		}
		
		$controller = new $url[0];
		$controller->loadModel($url[0]);

        // calling methods
        if(isset($url[4])){
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2],$url[3],$url[4]);
            } else {
                $this->error();
            }
        }else{
            if(isset($url[3])){
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2],$url[3]);
                } else {
                    $this->error();
                }
            }else{
            if (isset($url[2])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{$url[1]}($url[2]);
                } else {
                    $this->error();
                }
            } else {
                if (isset($url[1])) {
                    if (method_exists($controller, $url[1])) {
                        $controller->{$url[1]}();
                    } else {
                        $this->error();
                    }
                } else {
                    $controller->index();
                }
            }

        }
        }

		
	}
	
        public function error() {
		require 'controllers/errata.php';
		$controller = new Errata();
		$controller->index();
		return false;
	}

}