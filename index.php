<html>
    <head>
        <title>通訊錄 || PHP - AJAX</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://bootswatch.com/3/darkly/bootstrap.css">

        <!-- 使用sweetalert -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>

    <style>
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
            }
            .topnav {
            overflow: hidden;
            }
            label.xrequired:after {
            content: '*(此欄位為必填) ';
            color: red;
            }
            .topnav-right {
            float: right;
            }
            .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="topnav">
                <a class="active" href="#home">通訊錄</a>
                    <div class="topnav-right">
                        <a href="#about">PHP</a>
                    </div>
            </div>
        </nav>

        <div class="container box">
            <div align="right">
                <button type="button" id="modal_button" class="btn btn-default" style="border-Radius: 0px;">新增聯絡人</button>
                <!-- It will show Modal for Create new Records !-->
            </div>
            <br />
            <div id="result" class="table-responsive"> <!-- Data will load under this tag!-->
        </div>

        <!-- 這一個Modal是共用的，JS的判斷式會判斷點擊的按鈕來判斷該彈出的為新增使用者或編輯使用者的Modal!-->
        <div id="customerModal" class="modal fade" >
            <div class="modal-dialog"  style="width:800px"  >
                <div class="modal-content" style="border-Radius: 0px;">
                    <div class="modal-header" >
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h3 class="modal-title">新增聯絡人</h3>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-6">
                                <label class="text-light">中文姓名</label>
                                <input type="text" name="name" id="name" class="form-control" style="border-Radius: 0px;" required />
                            </div>
                            <div class="col-xs-6">
                                <label class="text-light">英文姓名</label>
                                <input type="text" name="ename" id="ename" class="form-control" style="border-Radius: 0px;" required />
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-4">
                                <label class="text-light">電話</label>
                                <input type="text" name="phone" id="phone" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                            <div class="col-xs-4">
                                <label class="text-light">電子信箱</label>
                                <input type="text" name="email" id="email" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                            <div class="col-xs-4">
                                <label class="text-light">性別</label>
                                <input type="text" name="sex" id="sex" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-4">
                                <label class="text-light">居住城市</label>
                                <input type="text" name="city" id="city" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                            <div class="col-xs-4">
                                <label class="text-light">鄉鎮市區</label>
                                <input type="text" name="township" id="township" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                            <div class="col-xs-4">
                                <label class="text-light">郵遞區號</label>
                                <input type="text" name="postcode" id="postcode" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="text-light">詳細地址</label>
                                <input type="text" name="address" id="address" class="form-control" style="border-Radius: 0px;"/>
                            </div>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="text-light">備註</label>
                                <textarea  type="textarea" name="notes" id="notes" class="form-control" style="border-Radius: 0px;"></textarea>
                            </div>
                            </div>
                        </div>
                        <br />
                        <div class="modal-footer">
                            <input type="hidden" name="customer_id" id="customer_id" />
                            <input type="submit" name="action" id="action" class="btn btn-primary" style="border-Radius: 0px;"/>
                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal" style="border-Radius: 0px;">關閉</button> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script>
    $(document).ready(function(){
    fetchUser(); //T頁面載入時，此功能將加載網頁上的所有數據
    function fetchUser() // 此功能將從表中獲取數據並顯示在 <div id="result"> 標籤
    {
    var action = "Load";
    $.ajax({
        url : "action.php", //請求發送到 "action.php"頁面
        method:"POST", //使用Post方法發送數據
        data:{action:action}, //action variable data has been send to server
        success:function(data){
        $('#result').html(data); //它將在div標籤下顯示帶有id結果的數據資料
    }
    });
    }

    //當點"新增"按鈕時，此JQuery的code將重置且清空Modal裡面的值
    $('#modal_button').click(function(){
    $('#customerModal').modal('show'); //It will load modal on web page
    $('#name').val(''); //欄位被清空重置
    $('#ename').val(''); //欄位被清空重置
    $('#phone').val(''); //欄位被清空重置
    $('#email').val(''); //欄位被清空重置
    $('#sex').val(''); //欄位被清空重置
    $('#city').val(''); //欄位被清空重置
    $('#township').val(''); //欄位被清空重置
    $('#postcode').val(''); //欄位被清空重置
    $('#address').val(''); //欄位被清空重置
    $('#notes').val(''); //欄位被清空重置
    $('.modal-title').text("新增聯絡人"); //Modal視窗的標題會判斷改為"新增聯絡人"
    $('#action').val("新增"); //Modal視窗按鈕會判斷改為"新增"按鈕
    });

    //此JQuery的code用於點擊“Modal”操作按鈕以創建新記錄或更新現有記錄。 此code是用於Modal新增和編輯資料為主
    $('#action').click(function(){
    var name = $('#name').val(); //設定欄位變數值
    var ename = $('#ename').val(); //設定欄位變數值
    var phone = $('#phone').val(); //設定欄位變數值
    var email = $('#email').val(); //設定欄位變數值
    var sex = $('#sex').val(); //設定欄位變數值
    var city = $('#city').val(); //設定欄位變數值
    var township = $('#township').val(); //設定欄位變數值
    var postcode = $('#postcode').val(); //設定欄位變數值
    var address = $('#address').val(); //設定欄位變數值
    var notes = $('#notes').val(); //設定欄位變數值
    var id = $('#customer_id').val();  //設定欄位變數值
    var action = $('#action').val();  //獲取“點擊動作”按鈕的值並存儲到動作變數中



    if(name != '') //判斷姓名欄位的值
    {
    $.ajax({
        url : "action.php",    //請求發送到 "action.php"頁面
        method:"POST",     
        data:{name:name, ename:ename, phone:phone, email:email, sex:sex, city:city, township:township, postcode:postcode, address:address, notes:notes, id:id, action:action}, //Send data to server
        success:function(data){
        //alert(data);    //It will pop up which data it was received from server side
        $('#customerModal').modal('hide'); //將Modal隱藏起來
        fetchUser();    // 呼叫並使用，它將以id結果顯示在<div id="result"> 標籤下
        }
    });
    }
    else
    {
    alert("Both Fields are Required"); //姓名欄位若沒輸入會彈出此視窗警告
    }
    });

    //此JQuery的code用於編輯資料。 點擊了編輯按鈕，則將執行此code
    $(document).on('click', '.update', function(){
    var id = $(this).attr("id"); //藉助JQuery的attr()方法從屬性ID中獲取所有聯絡人ID。
    var action = "Select";   //定義一個 action變數為"select"
    $.ajax({
    url:"action.php",   
    method:"POST",    
    data:{id:id, action:action},
    dataType:"json",   //定義資料類行為json格式類型，並將以json格式發送資料
    success:function(data){
        $('#customerModal').modal('show');   //顯示於網頁上
        $('.modal-title').text("編輯聯絡人"); //Modal的標題會判斷，並改為"編輯聯絡人"標題
        $('#action').val("編輯");     //Modal因為判斷執行的動作，所以會將按鈕改為"編輯"
        $('#customer_id').val(id);     //It will define value of id variable to this customer id hidden field
        $('#name').val(data.name);  //撈到資料庫此欄位的值
        $('#ename').val(data.ename);  //撈到資料庫此欄位的值
        $('#phone').val(data.phone);  //撈到資料庫此欄位的值
        $('#email').val(data.email);  //撈到資料庫此欄位的值
        $('#sex').val(data.sex);  //撈到資料庫此欄位的值
        $('#city').val(data.city);  //撈到資料庫此欄位的值
        $('#township').val(data.township);  //撈到資料庫此欄位的值
        $('#postcode').val(data.postcode);  //撈到資料庫此欄位的值
        $('#address').val(data.address);  //撈到資料庫此欄位的值
        $('#notes').val(data.notes);  //撈到資料庫此欄位的值
        }
        });
    });

    

    //此JQuery的code主要是用於刪除， 如果點擊了"刪除”按鈕，則此code將執行
    $(document).on('click', '.delete', function(){
    var id = $(this).attr("id"); //藉助JQuery的attr()方法從屬性ID中獲取所有聯絡人ID。
    //if(confirm("Are you sure you want to remove this data?")) //Confim Box if OK then
    //{
    var action = "Delete"; //定義動作變數為"刪除"
    $.ajax({
        url:"action.php",    
        method:"POST",     
        data:{id:id, action:action},  
        success:function(data)
        {
        fetchUser();    // 呼叫並使用，它將以id結果顯示在<div id="result"> 標籤下
        //alert(data);    //It will pop up which data it was received from server side
        }
    })
    //}
    //   else  //Confim Box if cancel then 
    //   {
    //    return false; //No action will perform
    //   }
    });
    });
    </script>
</html>