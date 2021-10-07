<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Category;
use App\Paiement;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('phone_number', function($attribute, $value, $parameters)
        {
            return substr($value, 0, 2) == '06';
        });

        View::composer('*', function ($view) {
            $d = date('Y-m-d');
            $from = "$d 00:00:01";
            $to = "$d 23:59:59";
            $categories = Category::all() ;
            $view->with('categories', $categories)
            ->with('revenu', Paiement::whereNotNull('client_id')->whereBetween('created_at', [$from, $to])->sum('montant_paye'));
        });

       /* $d = date('Y-m-d');
        $from = "$d 00:00:01";
        $to = "$d 23:59:59";
        View::share('revenu', Paiement::whereNotNull('demande_id')->whereBetween('created_at', [$from, $to])->sum('montant_paye'));*/



        Validator::extend('greater_than_field', function($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value > $min_value;
          });   
      
          Validator::replacer('greater_than_field', function($message, $attribute, $rule, $parameters) {
            return str_replace(':field', $parameters[0], $message);
          });
    }
}

