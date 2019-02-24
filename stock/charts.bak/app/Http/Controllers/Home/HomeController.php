<?php

namespace App\Http\Controllers\Home;


use App\Models\Detail;

use App\Models\Stock;
use Illuminate\Http\Request;

class HomeController
{
    //获取所有股票数据
    public function stock()
    {

        $data = $this->getStockData();

        return view("home.stock")

            ->with('data',$data);

    }

    //获取每只股票的具体详情
    public function detail(Request $request)
    {

        $stockNumber = $request->input("stock_number");

        $data = $this->getData($stockNumber);
        $date = [];
        $closing = [];
        $all = [];
        foreach ($data as $key => $value) {

            $date[] = $value->date;
            $all[] = $value->all_money;
            $closing[] = round($value->closing_price,2);
        }



        return view("home.detail")
            ->with('date', implode(',', $date))
            ->with('all', implode(',', $all))
            ->with('closing', implode(',', $closing))
            ->with('data',$data)
            ->with('stocknumber',$stockNumber);
    }

    //获取每一只股票的数据
    public function getData($number)
    {

        $data = Detail::where('stock_number',$number)->get();
        return $data;


    }

    //获取所有股票数据
    public function getStockData()
    {

        $data = Stock::get();
        return $data;

    }

    //新增每只股票的数据
    public function add(Request $request)
    {
        $stocknumber = $request->input('stock_number');
        $date = $request->input('date');
        $close= $request->input('close');
        $open= $request->input('open');
        $height= $request->input('height');
        $low= $request->input('low');
        $num= $request->input('number');


        if ($date) {

            $lastData = Detail::where('stock_number',$stocknumber)->orderby('date','desc')->first();
            $lastAllMoney = $lastData->all_money;
            $money = ($close-$open)/($height-$low)*$num;
            Detail::insert([
                'closing_price'=>$close,
                'opening_price'=>$open,
                'highest_price'=>$height,
                'lowest_price'=>$low,
                'number'=>$num,
                'money'=>$money,
                'all_money'=>$lastAllMoney+$money,
                'date'=>$date,
                'stock_number'=>$stocknumber,
            ]);

        }


       return $this->detail($request);
    }

    public function newstock(Request $request)
    {


        $name = $request->input('name');
        if ($name) {
            Stock::insert([
                'name'=>$name
            ]);

        }

        return $this->stock();
    }

    //删除最后一条
    public function delete(Request $request)
    {
        $id = $request->input('id');
        Detail::destroy($id);
        return $this->detail($request);

    }
}