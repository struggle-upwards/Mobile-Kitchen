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
  <style>
    .btn-display{
        display: block;
        margin: 0 auto;
        width: 150px;
        height: 30px;
        line-height: 30px;
        background-color: #f0f0f0;
        color: black;
        border: 1px solid #ccc
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        font-size: 16px;
        margin-top: 20px;
    }
    .c{
        background-color: #fff;
    }

  </style>
</head>

    

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>订单详细信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    
    <h1></h1>
    <div class="layui-panel">
        <div style="padding: 32px;">


        <table class="layui-table">
        <tr>
            <th>ID</th>
            <th>订单编号</th>
            <th>菜品编号</th>
            <th>购买数量</th>
            <th>客户备注</th>
            <th>订单状态</th>
        </tr>

        <?php foreach ($orderDetail as $detail): ?>
            <tr>
                <td><?php echo $detail->id; ?></td>
                <td><?php echo $detail->order_id; ?></td>
                <td><?php echo $detail->food_id; ?></td>
                <td><?php echo $detail->number; ?></td>
                <td><?php echo $detail->remark; ?></td>
                <td><?php echo $detail->status; ?></td>
            </tr>
        <?php endforeach; ?>
        
    </table>
    <a class="btn btn-display" href="<?php echo $this->createUrl('food/card', array('orderId'=>$orderDetail[0]->order_id));?>">查看菜单详细信息</a>
        </div>
    </div>
    

    </div>
</div>