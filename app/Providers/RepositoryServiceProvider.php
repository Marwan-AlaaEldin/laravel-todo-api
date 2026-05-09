<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //  TaskRepositoryInterface ديله TaskRepository لما حد طلب 
        $this->app->bind(
            TaskRepositoryInterface::class,
            TaskRepository::class
        );

        // CategoryRepositoryInterface ديله CategoryRepository ما حد طلب 
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
    }
}