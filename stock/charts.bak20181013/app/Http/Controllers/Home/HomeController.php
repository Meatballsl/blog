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
            ->with('data', $data);

    }
   
    public function category()
    {
        $data = $this->getCategoryData();
        return view("home.category")->with('data',$data);
    }

    //获取每只股票的具体详情
    public function detail(Request $request)
    {

        $stockNumber = $request->input("stock_number");

        $data = $this->getData($stockNumber);
        $date = [];
        $closing = [];
        $all = [];
        $financing = [];
        $all_hkincome = [];
        foreach ($data as $key => $value) {

            $date[] = $value->date;
            $all[] = $value->all_money;
            $closing[] = round($value->closing_price, 2);
            $financing[] = $value->financing;
            $all_hkincome[] = $value->all_hkincome;
        }
//dd($all_hkincome);

        return view("home.detail")
            ->with('date', implode(',', $date))
            ->with('all', implode(',', $all))
            ->with('closing', implode(',', $closing))
            ->with('data', $data)
            ->with('stocknumber', $stockNumber)
            ->with('financing',implode(',', $financing))
            ->with('all_hkincome',implode(',', $all_hkincome));
    }

    //获取每一只股票的数据
    public function getData($number)
    {

        $data = Detail::where('stock_number', $number)->get();
        return $data;


    }

    //获取所有股票数据
    public function getStockData()
    {

        $data = Stock::get();
        return $data;

    }
    
   public function getCategoryData()
   {
       $data = Category::get();
       return $data;
   }

    //新增每只股票的数据
    public function add(Request $request)
    {
        $stocknumber = $request->input('stock_number');
        $date = $request->input('date');
        $close = $request->input('close');
        $open = $request->input('open');
        $height = $request->input('height');
        $low = $request->input('low');
        $num = $request->input('number');
        $money = ($close - $open) / ($height - $low) * $num;
        $financing = $request->input('financing');
        $hkincome = $request->input('hkincome');


        if ($date) {

            $lastData = Detail::where('stock_number', $stocknumber)->orderby('date', 'desc')->first();
            if (!$lastData) {//不存在上一条记录
                $lastAllMoney = $money;
                $allMoney = $lastAllMoney;

                //港股流入总计（all_hkincomg）为本条记录的(hkincome)
                $allHkincome = $hkincome;
            } else {//存在上一条记录
                $lastAllMoney = $lastData->all_money;
                $allMoney = $lastAllMoney + $money;

                //如果上一条记录的all_hkincome 为false,则为本条记录的(hkincome)
                if (!$lastData['all_hkincome']) {
                    $allHkincome = $hkincome;
                } else {//上一条有值，则叠加
                    $allHkincome = $hkincome+$lastData['all_hkincome'];
                }
            }


            Detail::insert([
                'closing_price' => $close,
                'opening_price' => $open,
                'highest_price' => $height,
                'lowest_price' => $low,
                'number' => $num,
                'money' => $money,
                'all_money' => $allMoney,
                'date' => $date,
                'stock_number' => $stocknumber,
                'financing' => $financing,
                'hkincome' => $hkincome,
                'all_hkincome' => $allHkincome
            ]);

        }


        return $this->detail($request);
    }

    public function newstock(Request $request)
    {


        $name = $request->input('name');
        if ($name) {
            Stock::insert([
                'name' => $name
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
