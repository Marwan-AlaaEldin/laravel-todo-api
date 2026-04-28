<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Artisan;

class InitController extends Controller
{
   
private $models=[

"Category",
"Task",

];

public function migrations(){
$tables=[
'categories',
'tasks',
];
foreach($tables as $table){
  Artisan::call('make:migration', [
                'name' => "create_$table",
            ]);
            sleep(1);

}}
public function models()
    {
        foreach ($this->models as $model) {
            Artisan::call('make:model', [
                'name' => $model,
            ]);
        
        }}

     
    



public function controllers()
    {
        foreach ($this->models as $model) {
            Artisan::call('make:controller', [
                'name' => $model . 'Controller',
                '--api' => true,
            ]);
        }

      
    }
public function factories()
{
    foreach ($this->models as $model) {
        Artisan::call('make:factory', [
            'name' => $model . 'Factory',
            '--model' => $model,
        ]);
    }

    return response()->json(['message' => 'Factories created!']);
}

public function seeders()
{
    foreach ($this->models as $model) {
        Artisan::call('make:seeder', [
            'name' => $model . 'Seeder',
        ]);
    }

    return response()->json(['message' => 'Seeders created!']);
}




}
