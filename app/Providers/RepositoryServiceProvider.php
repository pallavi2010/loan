<?php
 
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\LoanRepositoryInterface;
use App\Repositories\LoanRepository;
use App\Interfaces\LoanPaymentRepositoryInterface;
use App\Repositories\LoanPaymentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoanRepositoryInterface::class, LoanRepository::class);
        $this->app->bind(LoanPaymentRepositoryInterface::class, LoanPaymentRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
