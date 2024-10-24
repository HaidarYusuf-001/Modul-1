<?php

namespace Controller;

class Controller {
  var $controllerName;
  var $controllerMethod;

  public function getControllerAttribute() {
    return [
      "ContollerName" => $this->controllerName,
      "Method" => $this->controllerMethod,
    ];
  }
}

?>