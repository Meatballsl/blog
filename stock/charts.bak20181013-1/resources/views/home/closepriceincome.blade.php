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
<div><a href="{{url('stockincate?category_id='.$categoryid)}}"> 返回股票列表</a></div>
<div class="">
    <div class="">
        <div  >
            <form  method="post" action="{{url('add')}}" >
                {{csrf_field()}}
            <table border="1" >
                <tr>
                    <th>日期</th>
                    <th>收盘价</th>
                    <th>日资金净流入</th>
                </tr>
                <tr>
                    <td><textarea name="date" rows="3" cols="20"></textarea></td>
                    <td><textarea name="close" rows="3" cols="20"></textarea></td>
                    <td><textarea name="income" rows="3" cols="20"></textarea></td>
                    <input type="hidden" name="stock_number" value="{{$stocknumber}}">
                    <input type="hidden" name="category_id" value="{{$categoryid}}">
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
                    <th>日资金净流入</th>
                    <th>累计资金净流入</th>
                    <th>操作</th>  　
                </tr>

                @foreach($data as $value)
                    <tr>

                        <td>{{$value['date']}}</td>
                        <td>{{$value['close']}}</td>
                        <td>{{$value['income']}}</td>
                        <td>{{$value['income_all']}}</td>
                        {{--<td><a href="{{url('delete?stock_number='.$value->stock_number.'&id='.$value->id)}}">删除</a></td>--}}
                        <td>删除</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="">
        <div id="container" style="width: 1000px;height:400px;"></div>
        <div id="container2" style="width: 1000px;height:400px;"></div>

    </div>

</div>

<input id="input-date" type="hidden" value="{{$date}}">
<input id="input-finance" type="hidden" value="{{$finance}}">
<input id="input-dayincomemount" type="hidden" value="{{$dayincomemount}}">
<!-- 引入 highcharts.js -->
<script src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>

<script>

    var input_date = document.getElementById('input-date').value
    var date = input_date.split(',')

    var input_finance = document.getElementById('input-finance').value
    var finance = input_finance.split(',')

    var input_dayincomemount = document.getElementById('input-dayincomemount').value
    var dayincomemount = input_dayincomemount.split(',')

    var new_finance = finance.map(toInt)
    var new_dayincomemount = dayincomemount.map(toInt)

    function toInt(value) {
        return parseFloat(value)
    }

    // 图表配置
    var options = {
        chart: {
            type: 'line'                          //指定图表的类型，默认是折线图（line）
        },
        title: {
            text: '收盘价'                 // 标题
        },
        xAxis: {
            categories: date
        },
        yAxis: {
            title: {
                text: '收盘价'                // y 轴标题
            }
        },
        series: [{                              // 数据列
            name: '收盘价',                        // 数据列名
            data: new_finance
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
            text: '累计资金净流入'                 // 标题
        },
        xAxis: {
            categories: date   // x 轴分类
        },
        yAxis: {
            title: {
                text: '累计资金净流入'                // y 轴标题
            }
        },
        series: [{                              // 数据列
            name: '累计资金净流入',                        // 数据列名
            data: new_dayincomemount                 // 数据
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
