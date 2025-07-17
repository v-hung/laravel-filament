<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

abstract class Controller
{

    public array $shareData = [];

    protected function getShareData(): array
    {
        $data = $shareData;
        // $traits = class_uses_recursive(static::class);

        // foreach ($traits as $trait) {
        //     $method = 'shareData' . class_basename($trait);

        //     if (method_exists($this, $method)) {
        //         $shared = array_merge($shared, $this->$method());
        //     }
        // }

        return $data;
    }

    protected function view($data = [], $mergeData = [])
    {
        $action = Route::currentRouteAction();

        if (!$action) {
            abort(500, 'Cannot determine the current controller action.');
        }

        // App\Http\Controllers\Site\HomeController@index
        [$controller, $method] = explode('@', $action);

        // Xử lý path controller → view name
        $viewPath = str_replace('App\\Http\\Controllers\\', '', $controller);
        $viewPath = str_replace('Controller', '', $viewPath);
        $viewPath = str_replace('\\', '.', $viewPath); // Site\Home → site.home

        // Đảm bảo prefix 'pages.' và lowercase toàn bộ
        $viewName = 'pages.' . strtolower($viewPath . '.' . $method);

        if (!view()->exists($viewName)) {
            abort(500, "View [{$viewName}] not found.");
        }

        $data = array_merge($this->getShareData(), $data);

        return view($viewName, $data, $mergeData);
    }

    protected function share($)
}
