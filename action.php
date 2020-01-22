<?php
//Database connection by using PHP PDO
$username = 'root';
$password = '';
$connection = new PDO( 'mysql:host=localhost;dbname=crud', $username, $password ); // Create Object of PDO class by connecting to Mysql database

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //載入所有聯絡人資料
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM customers ORDER BY id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   <table class="table table-striped table-bordered table-hover">
    <tr>
     <th width="15%">姓名</th>
     <th width="15%">電話</th>
     <th width="25%">電子信箱</th>
     <th width="40%">地址</th>
     <th width="10%">操作</th>
     <th width="10%">動作</th>
    </tr>
  ';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
    $output .= '
    <tr>
     <td>'.$row["name"].'</td>
     <td>'.$row["phone"].'</td>
     <td>'.$row["email"].'</td>
     <td>'.$row["city"].' - '.$row["address"].'</td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn update" style="border-Radius: 0px;"
     >編輯</button></td>
     <td><button type="button" id="'.$row["id"].'" class="btn btn-danger btn delete" style="border-Radius: 0px;"
     >刪除</button></td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">Data not Found</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

 //新增聯絡人資料的code
 if($_POST["action"] == "新增")
 {
  $statement = $connection->prepare("
   INSERT INTO customers (name, ename, phone, email, sex, city, township, postcode, address, notes) 
   VALUES (:name, :ename, :phone, :email, :sex, :city, :township, :postcode, :address, :notes)
  ");
  $result = $statement->execute(
   array(
    ':name' => $_POST["name"],
    ':ename' => $_POST["ename"],
    ':phone' => $_POST["phone"],
    ':email' => $_POST["email"],
    ':sex' => $_POST["sex"],
    ':city' => $_POST["city"],
    ':township' => $_POST["township"],
    ':postcode' => $_POST["postcode"],
    ':address' => $_POST["address"],
    ':notes' => $_POST["notes"]
   )
  );
  // if(!empty($result))
  // {
  //  echo 'Data Inserted';
  // }
 }

 //選取單獨一個聯絡人資料的code
 if($_POST["action"] == "Select")
 {
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM customers 
   WHERE id = '".$_POST["id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["name"] = $row["name"];
   $output["ename"] = $row["ename"];
   $output["phone"] = $row["phone"];
   $output["email"] = $row["email"];
   $output["sex"] = $row["sex"];
   $output["city"] = $row["city"];
   $output["township"] = $row["township"];
   $output["postcode"] = $row["postcode"];
   $output["address"] = $row["address"];
   $output["notes"] = $row["notes"];
  }
  echo json_encode($output);
 }

 //編輯聯絡人資料的code
 if($_POST["action"] == "編輯")
 {
  $statement = $connection->prepare(
   "UPDATE customers 
   SET name = :name, ename = :ename, phone = :phone, email = :email, sex = :sex, city = :city, township = :township, postcode = :postcode, address = :address, notes = :notes
   WHERE id = :id
   "
  );
  $result = $statement->execute(
   array(
    ':name' => $_POST["name"],
    ':ename' => $_POST["ename"],
    ':phone' => $_POST["phone"],
    ':email' => $_POST["email"],
    ':sex' => $_POST["sex"],
    ':city' => $_POST["city"],
    ':township' => $_POST["township"],
    ':postcode' => $_POST["postcode"],
    ':address' => $_POST["address"],
    ':notes' => $_POST["notes"],
    ':id'   => $_POST["id"]
   )
  );
  // if(!empty($result))
  // {
  //  echo 'Data Updated';
  // }
 }

 //刪除聯絡人資料的code
 if($_POST["action"] == "Delete")
 {
  $statement = $connection->prepare(
   "DELETE FROM customers WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
   )
  );
  // if(!empty($result))
  // {
  //  echo 'Data Deleted';
  // }
 }

}

?>
 