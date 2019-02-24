<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>股票图表</title>
</head>
<body>
<style>
    .left,
    .right {
        padding: 10px;
        display: table-cell;
        border: 0px solid #f40;
    }
</style>
<!-- 图表容器 DOM -->
<div><a href="{{url('stock')}}"> 返回股票列表 </a></div>
<div class="">
    <div class="">
        <div  >
            <form  method="post" action="{{url('add')}}" >
                {{csrf_field()}}
            <table border="1" >
                <tr>
                    <th>日期</th>
                    <th>收盘价</th>
                    <th>开盘价</th>
                    <th>最高价</th>
                    <th>最低价</th>
                    <th>总成交量</th>

                </tr>
                <tr>
                    <td><input type="text" name="date"></td>
                    <td><input type="text" name="close"></td>
                    <td><input type="text" name="open"></td>
                    <td><input type="text" name="height"></td>
                    <td><input type="text" name="low"></td>
                    <td><input type="text" name="number"></td>
                    <input type="hidden" name="stock_number" value="{{$stocknumber}}">
                </tr>
            </table>
                <button type="submit">增加</button>
                <hr>
            </form>
        </div>
        <div>
            <table border="1">
                <tr>
                    <th>日期</th>
                    <th>收盘价</th>
                    <th>开盘价</th>
                    <th>最高价</th>
                    <th>最低价</th>
                    <th>总成交量</th>
                    <th>日资金净流入</th>
                    <th>累计资金净流入</th>
                    <th>操作</th>
                </tr>
                @foreach($data as $value)
                    <tr>

                        <td>{{$value->date}}</td>
                        <td>{{$value->closing_price}}</td>
                        <td>{{$value->opening_price}}</td>
                        <td>{{$value->highest_price}}</td>
                        <td>{{$value->lowest_price}}</td>
                        <td>{{$value->number}}</td>
                        <td>{{$value->money}}</td>
                        <td>{{$value->all_money}}</td>
                        <td><a href="{{url('delete?stock_number='.$value->stock_number.'&id='.$value->id)}}">删除</a></td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="">
        <div id="container2" style="width: 1000px;height:400px;"></div>
        <div id="container" style="width: 1000px;height:400px;"></div>
    </div>

</div>

<input id="input-date" type="hidden" value="{{$date}}">
<input id="input-all" type="hidden" value="{{$all}}">
<input id="input-closing" type="hidden" value="{{$closing}}">
<!-- 引入 highcharts.js -->
<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>

<script>

    var input_date = document.getElementById('input-date').value
    var date = input_date.split(',')
    var input_all = document.getElementById('input-all').value
    var all = input_all.split(',')
    var input_closing = document.getElementById('input-closing').value
    var closing = input_closing.split(',')
    var new_arr = all.map(toInt)
    var new_close = closing.map(toInt)

    function toInt(value) {
        return parseFloat(value)
    }

    // 图表配置
    var options = {
        chart: {
            type: 'line'                          //指定图表的类型，默认是折线图（line）
        },
        title: {
            text: '每日累计资金净流入'                 // 标题
        },
        xAxis: {
            categories: date
        },
        yAxis: {
            title: {
                text: '累计资金净流入'                // y 轴标题
            }
        },
        series: [{                              // 数据列
            name: '累计资金净流入',                        // 数据列名
            data: new_arr
        }],
       // plotOptions: {
       //     line: {
       //         dataLabels: {
        //            // 开启数据标签
         //           enabled: true
          //      },
                // 关闭鼠标跟踪，对应的提示框、点击事件会失效
            //    enableMouseTracking: false
          //  }
       // }
    };
    var options2 = {
        chart: {
            type: 'line'                          //指定图表的类型，默认是折线图（line）
        },
        title: {
            text: '日收盘价'                 // 标题
        },
        xAxis: {
            categories: date   // x 轴分类
        },
        yAxis: {
            title: {
                text: '收盘价'                // y 轴标题
            }
        },
        series: [{                              // 数据列
            name: '收盘价',                        // 数据列名
            data: new_close                 // 数据
        }],
        //plotOptions: {
          //  line: {
            //    dataLabels: {
                    // 开启数据标签
              //      enabled: true
              //  },
                // 关闭鼠标跟踪，对应的提示框、点击事件会失效
               // enableMouseTracking: false
           // }
       // }
    };
    // 图表初始化函数
    var chart = Highcharts.chart('container', options);
    var chart2 = Highcharts.chart('container2', options2);
</script>
</body>
</html>
