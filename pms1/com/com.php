<?php 

//Connect to the database 
//insert query:
//INSERT INTO `notes` (`id`, `title`, `description`, `tstamp`) VALUES (NULL, 'complete cns notes', 'deadline is 26th \r\n', current_timestamp());

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

//delete query
if(isset($_GET['delete'])){
    $id= $_GET['delete'];
    $sql = "DELETE FROM `company` WHERE `company`.`id` = $id";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
        die("Delete Error". mysqli_error());
    }
    else{
        $delete = true;
    }
}

//update query
//use the values from edit modal
if(isset($_POST['idEdit'])){
    
    $id = $_POST['idEdit'];
    $com_name = $_POST['com_nameEdit'];
    $com_desc =$_POST['com_descEdit'];
    
    $sql = " UPDATE `company` SET `com_name` = '$com_name', `com_description` = '$com_desc' WHERE `company`.`id`=$id " ;
    
    $result = mysqli_query($conn, $sql);
    
    if(!$result){
        die("Update error" . mysqli_error());
    } 
    else{
       $update = true;
    }  
}
//insertion query
else{

    if($_SERVER['REQUEST_METHOD']=="POST"){
        $com_name = $_POST['com_name'];
        $com_description = $_POST['com_desc'];
        $sql = "INSERT INTO `company` (`id`, `com_name`, `com_description`, `date`) VALUES (NULL, '$com_name','$com_description', current_timestamp())";
        
        $result = mysqli_query($conn, $sql);
    
        if(!$result){
            die("insert error". mysqli_error());
        }else{
           $insert = true;
       }    
    }
}   
?>


<!--Html file starts here-->
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

        <title>PHP crud</title>
  </head>
    
  <body>
    
      <!--  Edit modal -->
      <!--     
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
        Edit Modal
        </button>
        -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this Company</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        
        <form action = "/pms1/com/com.php" method="post" >
            <div class="modal-body">
                <input type = "hidden" name = "idEdit" id ="idEdit">
                <div class="form-group my-3">
                    <label for="com_nameEdit" class="form-label">Company Name</label>
                    <input type="text" class="form-control" name = "com_nameEdit" id="com_nameEdit" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group my-3">
                    <label for="com_descEdit" class="form-label">Note Description</label>
                    <textarea class="form-control" name ="com_descEdit" id="com_descEdit" rows="3"></textarea>
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
    <a class="navbar-brand" href="#">PHP CRUD</a>
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
            <strong>Success!</strong> This medicine have been inserted successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      }
      
      if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> This medicine have been updated successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      }
      
      if($delete){
            
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> This medicine have been deleted successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
            header("location:/pms1/com/com.php");

      }
      
      
      ?>
      

<div class= "container my-4" >
    <h1>Add Company</h1>
    <form action = "/pms1/com/com.php" method="post" >
        <div class="form-group my-3">
            <label for="com_name" class="form-label">Company Name</label>
            <input type="text" class="form-control" name = "com_name" id="com_name" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="com_desc" class="form-label">Company Description</label>
            <textarea class="form-control" name ="com_desc" id="com_desc" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Company</button>
    </form>
</div>




<div class="container my-5">
    <table class="table" id ="myTable">
        <thead>
            <tr>
              <th scope="col">Sl No</th>
              <th scope="col">Name</th>
              <th scope="col">Description</th>
               <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
<!--Viewing query -->
        <?php
            $sql ="SELECT * FROM `company`";
            $result = mysqli_query($conn, $sql);
            $slno =0;
            while ($row = mysqli_fetch_assoc($result)){
                $slno = $slno +1;
                echo " <tr> 
                        <th scope='row'>" . $slno. "</th>
                        <td>" . $row['com_name']. "</td>
                        <td>" . $row['com_description']. "</td>
                        <td> 
                        <button class='edit btn btn-sm btn-primary' id =".$row['id']." >Edit</button> 
                                <button class='delete btn btn-sm btn-danger' id =d".$row['id']." >Delete</button> 
                         
                        </td>
                        </tr>";
            }    
        ?>  
        </tbody>
   </table>
</div>
<hr>

    <!-- Optional JavaScript; choose one of the two! 

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
                  console.log("Edit", );
                  tr = e.target.parentNode.parentNode;
                  com_name = tr.getElementsByTagName("td")[0].innerText;
                  com_desc = tr.getElementsByTagName("td")[1].innerText;
                  console.log(com_name, com_desc);
                  
                  com_nameEdit.value = com_name;
                  com_descEdit.value = com_desc;
                  idEdit.value = e.target.id;
                  
                  console.log(idEdit);
                  $('#editModal').modal('toggle');
              })
          })
          
          
          deletes = document.getElementsByClassName('delete');
          Array.from(deletes).forEach((element) =>{
              element.addEventListener("click",(e)=>{
                  console.log("Delete", );
                  id = e.target.id.substr(1,);
                  console.log(id);
                  
                  if(confirm("Are you sure you want to delete this company? ")){
                      console.log("yes");
                      window.location = `/pms1/com/com.php?delete=${id}`;
                  }
                  else{
                      console.log("no");
                  }
              })
          })
      </script>
    
  </body>
</html>
