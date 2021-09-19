<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer('sample', 'App\Http\View\Composers\ProfileComposer');

        // Register directive for blade.
        $this->extendBladeJsData();
        $this->extendBladeValue();
    }

    /**
     * Register directive for blade.
     */
    protected function extendBladeJsData()
    {
        // JS data.
        Blade::directive('jsData', function ($expression) {
            /**
             * @lang text
             */
            return "<script> var global = <?php echo json_encode({$expression}); ?>; </script>";
        });
    }

    /**
     * Register directive for blade.
     * @uses @value($name, &$set, $default = null)
     */
    protected function extendBladeValue()
    {
        // Val directive.
        Blade::directive('value', function ($expression) {
            $params = array_map('trim', explode(',', $expression));
            list($name, $set, $default) = $params;

            /**
             * @lang text
             */
            return "<?php echo old({$name}, isset({$set}) ? {$set} : {$default}); ?>";
        });
    }
}
