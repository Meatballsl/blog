<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>详情</title>
</head>

<body>
<div>
    <form method="post" action="{{url('newstock')}}">
        {{csrf_field()}}

        <label>股票名称：</label>
        <input type="text" name="name">

        <button type="submit">添加新股票</button>

    </form>
</div>
<div>
    <ol>
        @foreach($data as $value)
            <li>

                <a href="{{url('detail?stock_number='.$value->id)}}">{{$value->name}}</a>

            </li>

        @endforeach
    </ol>
</div>

</body>
</html>
