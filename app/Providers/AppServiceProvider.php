<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Ramsey\Uuid\Uuid;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {   
        $models = $this->getModels();
	    if (sizeof($models) > 0) {
            foreach ($models as $model) {
                $path = str_replace('/', '\\',$model['path']);
                $path::creating(function ($m) {
                    $m->uuid = Uuid::uuid4();
                    $m->created_at = date("Y-m-d H:i:s");
                    $m->updated_at = date("Y-m-d H:i:s");
                });
            }
        }
    }

    protected function getModels($path = "")
    {
        if ($path == "") {
            $path = app_path() . "/Models";
        }
        
        $results = scandir($path);
        $models = [];
        
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') {
                continue;
            }
            
            $filename = $path . '/' . $result;
            $extension = '.php';
            if (!is_dir($filename) && strpos($result, $extension) !== false) {
                $absolute_path = app_path();
    
                $model_path = str_replace($absolute_path, "App", $filename);
		        $model_path = str_replace($extension, '', $model_path);
                $name = str_replace($extension, '', $result);
                $models[] = [
                    'name' => $name,
                    'path' => $model_path,
                ];
            } else {
                $models = array_merge($models, $this->getModels($filename));
            }
        }

        return $models;
    }
}
