<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加导航定位</title>
    <script src="https://map.qq.com/api/js?v=2.exp&key=SZCBZ-IZA66-JBSSK-EMLRW-SH6BH-ROB6D"></script>
    <style>
    .button-style {
    display: inline-block;
    width: 10%;
    padding: 5px; /* 按钮内边距 */
    margin-left: 2%;
    background-color: #007BFF; /* 按钮背景颜色 */
    color: white; /* 文字颜色 */
    text-align: center; /* 文字居中 */
    text-decoration: none; /* 去除下划线 */
    font-size: 12.5px; /* 字体大小 */
    border-radius: 5px; /* 圆角边框 */
    transition: background-color 0.3s, transform 0.3s; /* 过渡效果 */
    border: none; /* 去除边框 */
    cursor: pointer; /* 鼠标悬停时的指针形状 */
  }

  .button-style:hover, .button-style:focus {
    background-color: #0056b3; /* 鼠标悬停或聚焦时的背景颜色 */
    transform: scale(1.05); /* 鼠标悬停或聚焦时稍微放大 */
    outline: none; /* 去除聚焦时的轮廓 */
  }
    </style>
    <style>
    .mapInfo1 {
    float: left;
    height: 65px;
    width: 45%;
    margin-top: 1%; 
    margin-left: 1%;
    padding-top: 1%;
    padding-bottom: 1%;
    padding-left: 1%;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 5px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    font-size: 14px;
}
    .kuang1 {
    width: 90%;
}
    .mapInfo2 {
    float: right;
    height: 25px;
    width: 50%;
    margin-top: 1%; 
    margin-right: 1%;
    padding-top: 1%;
    padding-bottom: 1%;
    padding-left: 1%;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 5px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    font-size: 14px;
}
    .kuang2 {
    width: 80%;
    height: 20px;
    font-size: 12.5px;
}
    </style>
</head>
<body>
    <div id="map" style="width: 100%; height: 80vh;"></div>
    <div>
    <div id="info" class="mapInfo1">
<?php if(empty($city)||empty($district)){?>
<input id='citydis' class="kuang1" disabled type="text" placeholder="市、区">
<?php } else{?>
<input id='citydis' class="kuang1" disabled type="text" value="<?php echo $city.",".$district;?>" placeholder="市、区">
<?php }?>
<input id='address' class="kuang1" disabled type="text" value="<?php echo $address;?>" placeholder="场馆地址">
<?php if(empty($city)||empty($district)){?>
<input id='lnglat' class="kuang1" disabled type="text" placeholder="场馆经纬度">
<?php } else{?>
<input id='lnglat' class="kuang1" disabled type="text" value="<?php echo "[".$lng.",".$lat."]";?>" placeholder="场馆经纬度">
<?php }?>
    </div>
    <div class="mapInfo2">
<input id='chaxun' class="kuang2" type="text" placeholder="请输入您要查询的地点（如：广州市天河区华南师范大学）">
<a class="button-style" onclick="codeAddress()">查询</a>
    </div>
    </div>
    <script>
<?php if(empty($lng)||empty($lat)){?>
    var center = new qq.maps.LatLng(23.1291,113.2644); // 默认中心点为广州
    var map = new qq.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 10
    });
<?php } else{?>
    var center = new qq.maps.LatLng(<?php echo $lat?>,<?php echo $lng?>);
    var map = new qq.maps.Map(document.getElementById('map'), {
        center: center,
        zoom: 18
    });
<?php }?>

<?php if(empty($lng)||empty($lat)){?>
    // 初始化一个用于后续操作的Marker，此时不将其显示在地图上
    var marker = new qq.maps.Marker({
        map: null,
        position: center
    });
<?php } else{?>
    var marker = new qq.maps.Marker({
        map: map,
        position: center
    });
<?php }?>

    // 地图点击事件
    qq.maps.event.addListener(map, 'click', function(event) {
        var lat = event.latLng.getLat();
        var lng = event.latLng.getLng();

        // 更新地图中心点
        map.panTo(event.latLng);

        // 更新Marker位置并显示
        marker.setPosition(event.latLng);
        marker.setMap(map);

        // 获取点击位置的地址信息
        var geocoder = new qq.maps.Geocoder({
            complete: function(result) {
                document.getElementById('address').value = result.detail.address;
                document.getElementById('lnglat').value = lng+","+lat;
                var addressComponents = result.detail.addressComponents;
                document.getElementById('citydis').value = addressComponents.city+","+addressComponents.district;
            }
        });
        geocoder.getAddress(event.latLng);
    });
    </script>
    <script>
    var geocoder2 = new qq.maps.Geocoder({
    complete: function(result) { //地址解析完成后的回调函数
        var addressComponent = result.detail.addressComponents;
        document.getElementById('citydis').value = addressComponent.city+","+addressComponent.district;
    }
});

    //查询地点
    var searchService = new qq.maps.SearchService({
    complete: function(results) { //搜索完成后的回调函数
        var pois = results.detail.pois;
        if(pois && pois.length > 0) {
        //console.log(pois[0]); //打印搜索结果

        map.panTo(pois[0].latLng); //更新地图中心点
        marker.setPosition(pois[0].latLng); //更新Marker位置并显示
        marker.setMap(map);

        document.getElementById('address').value = pois[0].address;
        document.getElementById('lnglat').value = pois[0].latLng.lng+","+pois[0].latLng.lat;

        geocoder2.getAddress(pois[0].latLng);
        } else {
            alert("未找到相关结果");
        }
    }
});

    function codeAddress() {
    var s1 = document.getElementById("chaxun").value;
    searchService.search(s1);
    }
    </script>
    <script>
    $(function(){
    api = $.dialog.open.api;
    api.button(
        {
            name: '确认',
            callback: function () {
                $.dialog.data('sign', 'queren');
                $.dialog.data('address', $('#address').val());
                $.dialog.data('lnglat', $('#lnglat').val());
                $.dialog.data('citydis', $('#citydis').val());
            },
            focus: true
        },
        {
            name: '取消',
            callback: function () {
                $.dialog.data('sign', 'quxiao');
            }
        }
    );
});
    </script>
</body>
</html>