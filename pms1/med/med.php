<?php 

$servername = "localhost";
$username = "root";
$password ="";
$db = "pharmacy";

$insert = false;
$update = false;
$delete = false;

$conn =mysqli_connect($servername, $username, $password, $db);
if (!$conn){
    die("Connection error". mysqli_connect_error());
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM `medicine` WHERE `medicine`.`id` = $id ";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
        die("Delete Error". mysqli_error());
    }
    else{
        header("location:/pms1/med/med.php");
        $delete = true;
    }
} 


if(isset($_POST['idEdit'])){
    
    $id = $_POST['idEdit'];
    //echo $id;
    $med_name = $_POST['med_nameEdit'];
    //echo $med_name;
    $mtype_id = $_POST['mtype_idEdit'];
    //echo $type;
    $com_id =$_POST['com_idEdit'];
    //echo $com_id;
    $manu_date =$_POST['manu_dateEdit'];
    //echo $manu_date;
    $exp_date =$_POST['exp_dateEdit'];
    //echo $exp_date;
    $count =$_POST['countEdit'];
    //echo $count;
    $price =$_POST['priceEdit'];
    //echo $price;
    
    $sql = " UPDATE `medicine` SET `med_name` = '$med_name', `mtype_id`= '$mtype_id', `com_id` = '$com_id', `manu_date` = '$manu_date', `exp_date` = '$exp_date', `price` = '$price', `total_count` = '$count' WHERE `medicine`.`id` = $id "; 
    
    echo $sql;
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
        die("Update error" . mysqli_error() );
    } 
    else{
       $update = true;
    }  
}
//insertion query
else{ 

if($_SERVER['REQUEST_METHOD']=="POST"){
    
        $med_name = $_POST['med_name'];
        $mtype_id = $_POST['mtype_id'];
        $com_id = $_POST['com_id'];
        $manu_date = $_POST['manu_date'];
        $exp_date = $_POST['exp_date'];
        $price = $_POST['price'];
        $count =$_POST['count'];
        $sql = "INSERT INTO `medicine` (`id`, `med_name`, `mtype_id`, `com_id`, `manu_date`, `exp_date`, `price`, `total_count`) VALUES (NULL, '$med_name', '$mtype_id', '$com_id', '$manu_date', '$exp_date', '$count', '$price')";
        
        $result = mysqli_query($conn, $sql);
    
        if(!$result){
            die("insert error". mysqli_error());
        }else{
           $insert = true;
       }    
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
      
        <!-- Data table CSS -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    
        <!-- this is Jquery CDN.  First define CDN and then start the table-->
        <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-    QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        <title>Medicines</title>
  </head>
    
  <body>
<!--      Edit modal-->
      
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this medicine</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        
      <form action = "/pms1/med/med.php" method="post" >
         <div class="modal-body">
             <input type = "hidden" name = "idEdit" id ="idEdit">
            <div class="form-group my-3">
                <label for="med_nameEdit" class="form-label">Medcine name</label>
                <input type="text" class="form-control" name = "med_nameEdit" id="med_nameEdit" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group my-3">
                <label for="mtype_idEdit" class="form-label">Type</label> 
                <?php 
                    $sql = "Select * FROM med_type";
                    $result = mysqli_query($conn, $sql); 
                    if(!$result){
                        die("result query". mysqli_error());
                    }
                ?>
                <select class="form-select" aria-label="Default select example" name = "mtype_idEdit" id="mtype_idEdit">
<!--                    <option selected>Open this select menu</option>-->
                    <?php 
                       while($row = mysqli_fetch_assoc($result)){ 
                            $mtype_id = $row['id'];
                            $type = $row['type'];
                            echo "<option value='$mtype_id'>$type</option>";
                        }
                    ?>        
                </select>
            </div> 
             
            <div class="form-group my-3">
                <label for="com_idEdit" class="form-label">Company name</label>
                <?php 
                  $sql = "Select * FROM company";
                    $result = mysqli_query($conn, $sql); 
                    if(!$result){
                        die("result query". mysqli_query());
                    }
                ?>
                <select class="form-select" aria-label="Default select example" name = "com_idEdit" id="com_idEdit">
                    <!-- <option selected>Open this select menu</option>-->
                    <?php            
                            while($row = mysqli_fetch_assoc($result)){ 
                            $com_id = $row['id'];
                            $com_name = $row['com_name'];
                            echo "<option value='$com_id'>$com_name</option>";
                        }
                    ?>        
                </select>
           </div>
           <div class="form-group my-3">
                <label for="manu_dateEdit" class="form-label">Manufacture Date</label>
                <input type="date" class="form-control" name = "manu_dateEdit" id="manu_dateEdit" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group my-3">
                <label for="exp_dateEdit" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" name = "exp_dateEdit" id="exp_dateEdit" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group my-3">
                <label for="countEdit" class="form-label">Count</label>
                <input type="text" class="form-control" name = "countEdit" id="countEdit" aria-describedby="emailHelp" required>
            </div>
            <div class="form-group my-3">
                <label for="priceEdit" class="form-label">Total Price</label>
                <input type="text" class="form-control" name = "priceEdit" id="priceEdit" aria-describedby="emailHelp" required>
            </div>
         </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> 
        </form>
    </div>    
  </div>
</div> 
 
            
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Pharmacy management system</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>   
        <li class="nav-item">
          <a class="nav-link" href="#">Contact Us</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
      
       
      <?php 
      if($insert){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> New Medicine has been added!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      }  
      
      if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Medicine has been updated
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
          header("location:/pms1/med/med.php");
      }
      
      if($delete){
            header("location:/pms1/med/med.php");
            
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Done!</strong> This medicine has been deleteted
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
          
      }
      
      ?>
      
      
      
      
      
      
<div class= "container my-4" >
    <h1>Add medicines</h1>
    <form action = "/pms1/med/med.php" method="post" >
        <div class="form-group my-3">
            <label for="med_name" class="form-label">Name</label>
            <input type="text" class="form-control" name = "med_name" id="med_name" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="mtype_id" class="form-label">Type</label>
            <?php 
            $sql = "Select * FROM med_type";
            $result = mysqli_query($conn, $sql); 
            if(!$result){
                die("result query". mysqli_error());
            }
            ?>
            <select class="form-select" aria-label="Default select example" name = "mtype_id" id="mtype_id">
                <option selected>Select the type</option>
                <?php
                    while($row = mysqli_fetch_assoc($result)){ 
                        $mtype_id = $row['id'];
                        $type = $row['type'];
                        echo "<option value='$mtype_id'>$type</option>";
                    }
                ?>        
            </select>
        </div>
        <div class="form-group my-3">
            <label for="com_id" class="form-label">Company name</label>
            <?php 
                $sql = "Select * FROM company";
                $result = mysqli_query($conn, $sql); 
                if(!$result){
                    die("result query". mysqli_error());
                }
            ?>
            <select class="form-select" aria-label="Default select example" name = "com_id" id="com_id">
            <option selected>Select the company</option>
            <?php
                
                while($row = mysqli_fetch_assoc($result)){ 
                    $com_id = $row['id'];
                    $com_name = $row['com_name'];
                    echo "<option value='$com_id'>$com_name</option>";
                }
            ?>        
            </select>
        </div>
        <div class="form-group my-3">
            <label for="manu_date" class="form-label">Manufacture Date</label>
            <input type="date" class="form-control" name = "manu_date" id="manu_date" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="exp_date" class="form-label">Expiry Date</label>
            <input type="date" class="form-control" name = "exp_date" id="exp_date" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="count" class="form-label">Count</label>
            <input type="text" class="form-control" name = "count" id="count" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="price" class="form-label">Total Price</label>
            <input type="text" class="form-control" name = "price" id="price" aria-describedby="emailHelp" required>
        </div>
        <button type="submit" class="btn btn-primary">Add medicine</button>
    </form>
</div>
      
      
      
<div class="container my-5">
    <table class="table" id ="myTable">
        <thead>
            <tr>
                <th scope="col">Sl No</th>
                <th scope="col">Name</th>
                <th scope="col">Type</th>
                <th scope="col">Company Name</th>
               <th scope="col">Manufacture Date</th>
                <th scope="col">Expiry Date</th>
                <th scope="col">Count</th>
                <th scope="col">Price</th>
                <th scope="col">Actions</th>   
            </tr>
        </thead>
        <tbody>
    
       <?php
          $sql ="SELECT md.id, md.med_name, md.mtype_id, mt.type, md.com_id, cm.com_name, md.manu_date, md.exp_date, md.total_count,md.price FROM medicine md, med_type mt, company cm WHERE md.mtype_id = mt.id and md.com_id = cm.id";
            //med_type -- type specified in medicine table /number 
            //type -- name specified in med_type table

            $result = mysqli_query($conn, $sql);

            $slno =0;
            while ($row = mysqli_fetch_assoc($result)){
                $slno = $slno +1;
                echo " <tr> 
                        <th scope='row'>" . $slno. "</th>
                        <td>" . $row['med_name']. "</td>
                        <td>" . $row['type']. "</td> 
                        <td>" . $row['com_name']. "</td>
                        <td>" . $row['manu_date']. "</td>
                        <td>" . $row['exp_date']. "</td>
                        <td>" . $row['total_count']. "</td>
                        <td>" . $row['price']. "</td>
                        <td> 
                        <button class='edit btn btn-sm btn-primary' id =".$row['id']."e".$row['com_id']."e".$row['mtype_id'].">Edit</button> 
                        <button class='delete btn btn-sm btn-danger' id =d".$row['id']." >Delete</button>     
                        </td>
                        </tr>";
            }
            ?>
        </tbody>
   </table>
</div>
      
      
      

            
             <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script> 
    -->
      <!--   Data table Js   -->
      <script src="//cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
      
      <script>
      $(document).ready( function () {
        $('#myTable').DataTable();
      } );
      </script>
          
        <script>
          edits = document.getElementsByClassName('edit');
          Array.from(edits).forEach((element) =>{
              element.addEventListener("click",(e)=>{
                  console.log("Edit");
                  
                  tr = e.target.parentNode.parentNode;
                  med_name = tr.getElementsByTagName("td")[0].innerText;
                  type = tr.getElementsByTagName("td")[1].innerText;
                  com_name= tr.getElementsByTagName("td")[2].innerText; 
                  manu_date= tr.getElementsByTagName("td")[3].innerText;
                  exp_date = tr.getElementsByTagName("td")[4].innerText;
                  count = tr.getElementsByTagName("td")[5].innerText;
                  price = tr.getElementsByTagName("td")[6].innerText;
                  
                  console.log(med_name, type, com_name, manu_date, exp_date, count, price);
                  
                  med_nameEdit.value = med_name;
                  manu_dateEdit.value = manu_date;
                  exp_dateEdit.value = exp_date;
                  countEdit.value = count;
                  priceEdit.value = price;
                  
                    var ar = [];
                  console.log(e.target.id);
                  for (var i =0; i<e.target.id.length;i++){
                      if(e.target.id[i] == 'e'){
                          ar.push(i);
                      }
                  }
                  
                  
                  //here substr doesnot work. It returns string from starting index to the no of elements defined in the second parameter.
                  idEdit.value = e.target.id.slice(0, ar[0]);
                  com_idEdit.value = e.target.id.slice(ar[0]+1, ar[1]);
                  mtype_idEdit.value = e.target.id.slice(ar[1]+1, e.target.id.length);
                  
                 
                  console.log(idEdit.value)
                  console.log(com_idEdit.value);
                  console.log(mtype_idEdit.value);
                  $('#editModal').modal('toggle');
              })
          })
          
            deletes = document.getElementsByClassName('delete');
          Array.from(deletes).forEach((element) =>{
              element.addEventListener("click",(e)=>{
                  console.log("Delete", );
                  id = e.target.id.substr(1,);
                  
                  if(confirm("Are you sure you want to delete this notes? ")){
                      console.log("yes");
                      window.location = `/pms1/med/med.php?delete=${id}`;
                  }
                  else{
                      console.log("no");
                  }
              })
          })
      </script>
      
    </body>
</html>



