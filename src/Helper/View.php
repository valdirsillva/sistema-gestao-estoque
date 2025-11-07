<?php

namespace App\Helper;

class View
{
  public static function render(string $view, array $data = []): void
  {

    extract($data);
    require __DIR__ . "/../Views/layout.php";

    // extract($data, EXTR_SKIP);
    // $viewPath = __DIR__ . '/../Views/' . $viewFile . '.php';

    // if (!file_exists($viewPath)) {
    //   throw new \RuntimeException("View não encontrada: $viewPath");
    // }

    // require $viewPath;
  }
}
