<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Demo</title>
  <!-- 请勿在项目正式环境中引用该 layui.css 地址 -->
  <link href="//unpkg.com/layui@2.9.7/dist/css/layui.css" rel="stylesheet">
  <!-- <link rel="stylesheet" type="text/css" href="/sports/layui/css/layui.css" /> -->
</head>
<body>
<!-- <div class="layui-carousel" id="ID-carousel-demo-1" >
  <div carousel-item>
  <?php foreach ($arclist as $index => $arc) {
  ?>
   <div>
     <div style="display: flex;height: 500px;width: 300px;align-items: center;justify-content: center;">
    <img src="<?php echo $arc->imgURL?>" style="height: 80%;">
     </div>
   </div>
   <?php }?>
  </div>
</div> 
 <div class="tips">效果参考预览如上</div> -->


 <button type="button" class="layui-btn layui-btn-sm layui-btn-normal" onclick="chooseAndUploadFile()">
    <i class="layui-icon layui-icon-addition"></i> 新增图片
 </button>
 <table class="layui-table" id="imageTable">
  <thead>
    <tr>
      <th lay-data="{field:'id', width:80}" style="text-align:center;">图片</th>
      <th lay-data="{field:'id', width:80}" style="text-align:center;">排序</th>
      <th lay-data="{field:'sex', width:80}" style="text-align:center;">操作</th>
    </tr>
  </thead>
<!--   <?php foreach ($arclist as $index => $arc) {
      // code...?>
     <tr>
        <td style="height:200px; width:1000px;"><img style="height:180px;max-width:100%;width:300px" src="<?php echo $arc->imgURL?>"></td>

      <td ><?php echo $arc->sortNumber ?></td>
      <td style="width: 400px;" >  
   <button type="button" class="layui-btn" onclick="del(<?php echo $arc->id?>)">
    <i class="layui-icon layui-icon-delete" ></i> 删除
   </button>
   <button type="button" class="layui-btn" onclick="update(<?php echo $arc->id?>)">
    <i class="layui-icon layui-icon-edit"></i> 修改
   </button>
   <button type="button" class="layui-btn layui-btn-normal layui-btn-radius">
   上移
   </button>
   <button type="button" class="layui-btn layui-btn-normal layui-btn-radius">
   	下移
   </button>
      </td>
    </tr>
   <?php }?> -->
</table>
<style type="text/css">
    .imgTd{
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .swiperItem{
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: red;
    }
    .tips{
        margin-top: 5px;
        margin-bottom: 5px;
        color: #a2a29b;
    }
</style>
  
<!-- 请勿在项目正式环境中引用该 layui.js 地址 -->
<!-- <script src="/sports/layui/layui.js"></script>  -->
<script>
layui.use(function(){
  var carousel = layui.carousel;
  // 渲染 - 常规轮播
  carousel.render({
    elem: '#ID-carousel-demo-1',
    width: 'auto',
    indicator:"none",
    // arrow:"none",
  });
 
});
</script>
<script type="text/javascript">
var allimage;
function getAllImage(){
    $.ajax({
                url: '<?php echo $this->createUrl("swiperimage/GetImage"); ?>',
                type: 'POST',
                success: function(response) {

                   allimage=JSON.parse(response);
                   allimage.sort(function(a, b) {return a.sortNumber - b.sortNumber;});
                   var tableObj=document.getElementById('imageTable');
                   var str="";
                   //var str1="";
                   for(var i=0;i<allimage.length;i++){
                    var sortnum = allimage[i].sortNumber;
                      str+="<tr><td style='height:200px; width:1000px;' class='imgTd'><img style='height:180px;max-width:100%;width:300px' src="+allimage[i].imgURL+"></td>";
                      //str1+="<div><img src="+allimage[i].imgURL+"></div>";
                      str+="<td>"+sortnum+"</td>";
                      str+="<td style='width: 400px;' >";
                      str+='<button type="button" class="layui-btn" onclick="del('+allimage[i].id+')"><i class="layui-icon layui-icon-delete" ></i> 删除</button><button type="button" class="layui-btn"  onclick="update('+allimage[i].id+')"><i class="layui-icon layui-icon-edit"></i> 修改</button>'
                      if(allimage.length!=1){
                      if(i==0){
                      str+='<button type="button" class="layui-btn layui-btn-normal layui-btn-radius" onclick="changePosition('+allimage[i].id+','+allimage[i+1].id+')">下移</button></td></tr>';
                      }else if(i==allimage.length-1){
                        str+='<button type="button" class="layui-btn layui-btn-normal layui-btn-radius" onclick="changePosition('+allimage[i].id+','+allimage[i-1].id+')">上移</button>';
                      }else{
                        str+='<button type="button" class="layui-btn layui-btn-normal layui-btn-radius" onclick="changePosition('+allimage[i].id+','+allimage[i-1].id+')">上移</button><button type="button" class="layui-btn layui-btn-normal layui-btn-radius" onclick="changePosition('+allimage[i].id+','+allimage[i+1].id+')">下移</button></td></tr>';
                      }

                      }
                   }
                   tableObj.innerHTML+=str;
                   // console.log(str1);
                   // var swiperObj=document.getElementById('swiper');
                   // swiperObj.innerHTML="123"
                   // swiperObj.innerHTML=str1;

                },
                error: function(xhr, status, error) {
                }
    });
}
function changePosition(curId,changeId){
    console.log('当前id: ',curId);
    console.log('需要被移动的id: ',changeId);
     $.ajax({
        url:'<?php echo $this->createUrl("swiperimage/changePosition"); ?>',
        // url: '/sports/index.php?r=swiperimage/changePosition',
        type: 'POST',
        data: { firId: curId, changeId: changeId },
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            alert('交换失败：' + error);
        }
    });
}
function update(id){
    var fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    fileInput.onchange = function() {
        var file = fileInput.files[0];
        if (file) {
            var formData = new FormData();
            formData.append('file', file);
            formData.append('id',id);
            $.ajax({
                url: '<?php echo $this->createUrl("swiperimage/Update"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('修改成功！');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('修改失败：' + error);
                }
            });
        } else {
            alert('请选择文件！');
        }
        document.body.removeChild(fileInput);
    };
        
    fileInput.click();
}
function del(id) {
    var result = confirm("你确定删除该图像？");

    if (result) {
        $.ajax({
            url: '<?php echo $this->createUrl("swiperimage/Delete"); ?>',
            type: 'POST',
            data: { id: id }, // 将 id 参数包含在 data 对象中
            success: function(response) {
                alert('删除成功！');
                location.reload();
            },
            error: function(xhr, status, error) {
                alert('删除失败！');
            }
        });
    } else {
    }
}
function chooseAndUploadFile() {
    var fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    fileInput.style.display = 'none';
    document.body.appendChild(fileInput);

    fileInput.onchange = function() {
        var file = fileInput.files[0];
        if (file) {
            var formData = new FormData();
            formData.append('file', file);

            $.ajax({
                url: '<?php echo $this->createUrl("swiperimage/add"); ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('文件上传成功！');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('上传失败：' + error);
                }
            });
        } else {
            alert('请选择文件！');
        }
        document.body.removeChild(fileInput);
    };
        
    fileInput.click();
}

getAllImage();
</script>
</body>
</html>