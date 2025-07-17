<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

abstract class Controller
{
    public array $shareData = [];

    protected function getShareData(): array
    {
        $data = $this->shareData;
        $traits = class_uses_recursive(static::class);

        foreach ($traits as $trait) {
            $base = class_basename($trait);
            $method = strtolower($base) . 'Data';

            if (method_exists($this, $method)) {
                $data = array_merge($data, $this->$method());
            }
        }

        return $data;
    }

    protected function view($data = [], $mergeData = [])
    {
        $action = Route::currentRouteAction();

        if (!$action) {
            abort(500, 'Cannot determine the current controller action.');
        }

        [$controller, $method] = explode('@', $action);

        $viewPath = str_replace('App\\Http\\Controllers\\', '', $controller);
        $viewPath = str_replace('Controller', '', $viewPath);
        $viewPath = str_replace('\\', '.', $viewPath);

        $viewName = 'pages.' . strtolower($viewPath . '.' . $method);

        if (!view()->exists($viewName)) {
            abort(500, "View [{$viewName}] not found.");
        }

        $data = array_merge($this->getShareData(), $data);

        return view($viewName, $data, $mergeData);
    }

    protected function share($key, $value)
    {
        $this->shareData = array_merge($this->shareData, [$key, $value]);
    }
}
