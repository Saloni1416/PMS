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
    $sql = "DELETE FROM `users` WHERE `users`.`id` = $id";
    
    $result = mysqli_query($conn, $sql);
    if(!$result){
        die("Delete Error". mysqli_error());
    }
    else{
        $delete = true;
        header("location:/pms1/emp/emp.php");
    }
}

//update query
//use the values from edit modal
if(isset($_POST['idEdit'])){
    
    $id = $_POST['idEdit'];
    $first_name = $_POST['first_nameEdit'];
    $last_nmae = $_POST['last_nameEdit'];
    $gender = $_POST['genderEdit'];
    $email = $_POST['emailEdit'];
    $phone = $_POST['phoneEdit'];
    $dob = $_POST['dobEdit'];
    $address = $_POST['addressEdit'];
    $salary = $_POST['salaryEdit'];
    
    $sql = " UPDATE `users` SET `first_name` = '$first_name', `last_name` = '$last_nmae', `gender` = '$gender', `dob` = '$dob', `email` = '$email', `phone` ='$phone', `address` = '$address', `salary`= '$salary' WHERE `users`.`id`=$id " ;
    
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
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $dob= $_POST['dob'];
        $salary = $_POST['salary'];
        $sql = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `dob`, `email`, `phone`, `address`, `password`, `roles_id`, `salary`, `time`) VALUES (NULL, '$first_name', '$last_name', '$gender', '$dob', '$email', '$phone', '$address', '12345', '3', '$salary', current_timestamp());";
        
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
        
        <form action = "/pms1/emp/emp.php" method="post" >
            <div class="modal-body">
                <input type = "hidden" name = "idEdit" id ="idEdit">
                
                <div class="form-group my-3">
                    <label for="first_nameEdit" class="form-label">First Name</label>
                    <input type="text" class="form-control" name = "first_nameEdit" id="first_nameEdit" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group my-3">
                    <label for="last_nameEdit" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name = "last_nameEdit" id="last_nameEdit" aria-describedby="emailHelp" >
                </div>
                <div class="form-group my-3">
                    <label for="genderEdit" class="form-label"> Gender</label>
                    <input type="text" class="form-control" name = "genderEdit" id="genderEdit" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group my-3">
                    <label for="dobEdit" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name = "dobEdit" id="dobEdit" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group my-3">
                    <label for="emailEdit" class="form-label">Email</label>
                    <input type="text" class="form-control" name = "emailEdit" id="emailEdit" aria-describedby="emailHelp" >
                </div>
                <div class="form-group my-3">
                    <label for="phoneEdit" class="form-label">Phone No</label>
                    <input type="text" class="form-control" name = "phoneEdit" id="phoneEdit" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group my-3">
                    <label for="addressEdit" class="form-label">Address</label>
                    <input type="text" class="form-control" name = "addressEdit" id="addressEdit" aria-describedby="emailHelp" required>
                </div>
                <div class="form-group my-3">
                    <label for="salaryEdit" class="form-label">Salary</label>
                    <input type="text" class="form-control" name = "salaryEdit" id="salaryEdit" aria-describedby="emailHelp" required>
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
    <a class="navbar-brand" href="#">Employee Details</a>
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
            <strong>Success!</strong>yNew employee have been added successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      }
      
      if($update){
      echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> Employee details have been updated successfully!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
      }
      
      if($delete){
          
             header("location:/pms1/emp/emp.php");
            
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            <strong>Success!</strong> This employee has been removed!
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
          

      }
      
      
      ?>
      

<div class= "container my-4" >
    <h1>Add New Employee.</h1>
    <form action = "/pms1/emp/emp.php" method="post" >
        <div class="form-group my-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" name = "first_name" id="first_name" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" name = "last_name" id="last_name" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="gender" class="form-label"> Gender</label>
            <input type="text" class="form-control" name = "gender" id="gender" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" name = "dob" id="dob" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" name = "email" id="email" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="phone" class="form-label">Phone No</label>
            <input type="text" class="form-control" name = "phone" id="phone" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name = "address" id="address" aria-describedby="emailHelp" required>
        </div>
        <div class="form-group my-3">
            <label for="salary" class="form-label">Salary</label>
            <input type="text" class="form-control" name = "salary" id="salary" aria-describedby="emailHelp" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Employee</button>
    </form>
</div>




<div class="container my-5">
    <table class="table" id ="myTable">
        <thead>
            <tr>
              <th scope="col">Sl No</th>
              <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Gender</th>
                <th scope="col">Date of Birth</th>
                <th scope="col">Email Id</th>
                <th scope="col">Phone</th>
                <th scope="col">Address</th>
              <th scope="col">Salary</th>
               <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
<!--Viewing query -->
        <?php
            $sql ="SELECT * FROM `users` WHERE users.roles_id=3";
            $result = mysqli_query($conn, $sql);
            $slno =0;
            while ($row = mysqli_fetch_assoc($result)){
                $slno = $slno +1;
                echo " <tr> 
                        <th scope='row'>" . $slno. "</th>
                        <td>" . $row['first_name']. "</td>
                        <td>" . $row['last_name']. "</td>
                        <td>" . $row['gender']. "</td>
                        <td>" . $row['dob']. "</td>
                        <td>" . $row['email']. "</td>
                        <td>" . $row['phone']. "</td>
                        <td>" . $row['address']. "</td>
                        <td>" . $row['salary']. "</td>
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
                  
                  first_name = tr.getElementsByTagName("td")[0].innerText;
                  last_name = tr.getElementsByTagName("td")[1].innerText;
                  gender = tr.getElementsByTagName("td")[2].innerText;
                  dob = tr.getElementsByTagName("td")[3].innerText;
                  email = tr.getElementsByTagName("td")[4].innerText;
                  phone = tr.getElementsByTagName("td")[5].innerText;
                  address = tr.getElementsByTagName("td")[6].innerText;
                  salary = tr.getElementsByTagName("td")[7].innerText;
                  
                  console.log(first_name, last_name, gender, dob, email,phone, address, salary);
                  
                  first_nameEdit.value = first_name;
                  last_nameEdit.value = last_name;
                  genderEdit.value = gender;
                  dobEdit.value = dob;
                  emailEdit.value = email;
                  phoneEdit.value = phone;
                  addressEdit.value = address;
                  salaryEdit.value = salary;
                  
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
                  
                  if(confirm("Are you sure you want to delete this company? ")){
                      console.log("yes");
                      window.location = `/pms1/emp/emp.php?delete=${id}`;
                      
                  }
                  else{
                      console.log("no");
                  }
              })
          })
      </script>
    
  </body>
</html>
