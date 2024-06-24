<!DOCTYPE html>
<html>
<head>
    <title>Order Card</title>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo</title>
  <link href="//unpkg.com/layui@2.9.9/dist/css/layui.css" rel="stylesheet">
</head>

    

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>下单菜品信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-food">
    
    <h1></h1>
    <div class="layui-panel">
        <div style="padding: 32px;">


        <table class="layui-table">
        <tr>
            <th>菜品名称</th>
            <th>菜品单价</th>
            <th>菜品状态</th>
        </tr>

        <?php foreach ($foods as $food): ?>
            <tr>
                <td><?php echo $food->food_name; ?></td>
                <td><?php echo $food->price; ?></td>
                <td><?php echo $food->status?'新鲜':'不新鲜'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
        </div>
    </div>
    

    </div>
</div>