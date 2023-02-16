<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\zad_1_produkty;
use App\Models\zad_1_ceny;
use Illuminate\Support\Str;
use PDF;


class WelcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // Zadanie 1
        $task_1 = DB::table('zad_1_produkty')
        ->leftJoin('zad_1_ceny as c1', function ($join) {
            $join->on('zad_1_produkty.id', '=', 'c1.product_id')
                 ->where('c1.type', '=', 1);
        })
        ->leftJoin('zad_1_ceny as c2', function ($join) {
            $join->on('zad_1_produkty.id', '=', 'c2.product_id')
                 ->where('c2.type', '=', 0);
        })
        ->select('zad_1_produkty.id', 'zad_1_produkty.name', DB::raw('IFNULL(c1.value, c2.value) as value'))
        ->orderBy('value')
        ->get();

        $schedule = [
            "1" => [
                "data_start" => strtotime("2020-09-12"),
                "data_stop" => strtotime("2020-09-14"),
            ],
            "2" => [
                "data_start" => strtotime("2020-09-13"),
                "data_stop" => strtotime("2020-09-20"),
            ],
            "3" => [
                "data_start" => strtotime("2020-09-13"),
                "data_stop" => strtotime("2020-09-05"),
            ],
            "4" => [
                "data_start" => strtotime("2020-10-02"),
                "data_stop" =>strtotime("2020-10-09"),
            ],
        ];

        // Zadanie 2.
        foreach($schedule as $key => $date) {
            $freeDate[$key] = DB::table('zad_2_wynajem')->where(function ($query) use ($date) {
                    $query->where(function ($query) use ($date) {
                        $query->where('data_start', '>', date('Y-m-d', $date['data_start']))
                              ->where('data_start', '<', date('Y-m-d', $date['data_stop']));
                    })
                    ->orWhere(function ($query) use ($date) {
                        $query->where('data_stop', '>', date('Y-m-d', $date['data_start']))
                              ->where('data_stop', '<', date('Y-m-d', $date['data_stop']));
                    })
                    ->orWhere(function ($query) use ($date) {
                        $query->where('data_start', '<', date('Y-m-d', $date['data_start']))
                              ->where('data_stop', '>', date('Y-m-d', $date['data_stop']));
                    });
                })
                ->get();

            if (count($freeDate[$key]) > 0) {
                $freeDate[$key]['zejety'] = "Termin " . $key . " jest zajety\n";
                $freeDate[$key]['date_start'] = date('Y-m-d', $date['data_start']);
                $freeDate[$key]['date_stop'] = date('Y-m-d', $date['data_start']);
            } else {
                $freeDate[$key]['wolny'] = "Termin " . $key . " jest wolny\n";
                $freeDate[$key]['date_start'] = date('Y-m-d', $date['data_start']);
                $freeDate[$key]['date_stop'] = date('Y-m-d', $date['data_start']);
            }
        }


        return view('welcome', [
            'task_1' => $task_1,
            'task_2' => $freeDate,
        ]);
    }


    /**
     * Add x random products base on number provided in request.
     */
    public function task3(string $liczba)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $product_ids = [];
        for($i = 0; $i < $liczba; $i++){
            $new = new zad_1_produkty;
            $new->name = str::random(5);
            $new->save();

            $product_ids[] = $id = $new->id;

            $new2 = new zad_1_ceny;
            $new2->product_id = $id;
            $new2->value = rand(11,70);
            $new2->type = 0;
            $new2->save();
        }

        $count = count($product_ids);
        $limit = ceil(0.15 * $count);
        $products_to_update = zad_1_produkty::orderBy('created_at', 'desc')->limit($limit)->get();


        foreach ($products_to_update as $product) {
            $price = zad_1_ceny::where('product_id', $product->id)->first();
            $base_price = $price->value;

            $new3 = new zad_1_ceny;
            $new3->value = $base_price - rand(1,10);
            $new3->product_id = $product->id;
            $new3->type = 1;
            $new3->save();

        }
    }

    /**
     * Return table with result for task 4.
     */
    public function task4(String $fraza) {

        $task_4 = zad_1_produkty::where('name', 'LIKE', "%{$fraza}%")->get();

        $sortedProducts = $task_4->sortBy(function ($product) {
            return $product->getPrices()->first()->value;
        });

        return view('task4', [
        'task_4' => $sortedProducts,
        ]);
    }

    /**
     * Generate pdf.
     */
    public function task5() {
        $data = [
            'author' => 'Tomasz Adamski',
            'date' => date('m/d/Y')
        ];

        $pdf = PDF::loadView('pdf', $data);


        return $pdf->download('zad5.pdf');
    }

        /**
     * Generate pdf.
     */
    public function task6() {
        $tabela_start = [
            ['name'=>'Wydarzenia 1','data'=>'13-09-2021'],
            ['name'=>'Wydarzenia 2','data'=>'16-09-2021'],
            ['name'=>'Wydarzenia 3','data'=>'29-09-2021'],
            ['name'=>'Wydarzenia 4','data'=>'13-09-2021'],
            ['name'=>'Wydarzenia 5','data'=>'02-09-2021'],
            ['name'=>'Wydarzenia 6','data'=>'30-09-2021'],
            ['name'=>'Wydarzenia 7','data'=>'15-09-2021'],
            ['name'=>'Wydarzenia 8','data'=>'02-09-2021'],
            ['name'=>'Wydarzenia 9','data'=>'13-09-2021'],
            ['name'=>'Wydarzenia 10','data'=>'06-09-2021'],
            ['name'=>'Wydarzenia 11','data'=>'18-09-2021'],
            ['name'=>'Wydarzenia 12','data'=>'28-09-2021'],
            ['name'=>'Wydarzenia 13','data'=>'29-09-2021'],
            ['name'=>'Wydarzenia 14','data'=>'18-09-2021'],
            ['name'=>'Wydarzenia 15','data'=>'14-09-2021'],
            ['name'=>'Wydarzenia 16','data'=>'27-09-2021'],
            ['name'=>'Wydarzenia 17','data'=>'26-09-2021'],
            ['name'=>'Wydarzenia 18','data'=>'12-09-2021'],
            ['name'=>'Wydarzenia 19','data'=>'13-09-2021'],
            ['name'=>'Wydarzenia 20','data'=>'29-09-2021']
        ];


        $tabela_koniec = [];

        foreach($tabela_start as $key => $row)
        {
            $date = date('Ymd', strtotime($row['data']));
            $tabela_koniec[$date][] = $row['name'];
        }

        ksort($tabela_koniec);

        dd($tabela_koniec);

    }

}
