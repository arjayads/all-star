<?php

namespace App\Providers;

use App\FileUploader\FileUploaderPublisher;
use Illuminate\Support\ServiceProvider;

class FileUploadServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerFileUploader();
    }

    private function registerFileUploader()
    {
        $this->app->bindShared('FileUploader\FileUploaderPublisher', function(){
            return new FileUploaderPublisher();
        });
    }

}
