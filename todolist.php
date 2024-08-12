<?php

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'todo_master';

$conn = mysqli_connect($server,$username,$password,$database);

// var_dump($conn->connect_error);


if($conn->connect_error)
{
    die('Connection to Mysql Failed : '.$conn->connection_error);
}
 
// creating  a todo item

if(isset($_POST['add']))
{
    $item = $_POST['item'];
    
// var_dump($item);

    if(!empty($item))
        {
           $query = "INSERT INTO TODO (name) VALUES ('$item')";
        
           if(mysqli_query($conn,$query))
           {
              echo '<center>
                    <div class = "alert alert-success" role = "alert">
                     Item Added Successfully!
                    </div>
                    </center>';
           }else
            {
             echo mysqli_error($conn);
            }                       
        } 
}

  //checking if action parameter is present
 
  if(isset($_GET['action']))
  {
    $itemid = $_GET['item'];
   // var_dump($item);
    if($_GET['action'] == 'done')
    {
        $query = "UPDATE TODO SET status = 1 WHERE id  = '$itemid'";
        
           if(mysqli_query($conn,$query))
           {
              echo '<center>
                    <div class = "alert alert-info" role = "alert">
                 Item Marked As Done!
                    </div>
                    </center>';
       }else
       {
         echo mysqli_error($conn);
       }                       
     }elseif($_GET['action']=='delete'){
        $query = "DELETE FROM TODO WHERE id = '$itemid'";
        if(mysqli_query($conn,$query)){
            echo '<center>
                  <div class = "alert alert-danger" role = "alert">
                  Item Deleted Successfully! 
                  </div>
                  </center>';
     }else
     {
       echo mysqli_error($conn);
     }       
     } 
  }





?>


<!DOCTYPE html>
<html>
      <head>
        <title>Todo List Application</title>
        <!-- css -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <style>
        p {
            color : navy;
            text-indent : 500px;
            margin-top: 1em;
            text-transform: uppercase;
        }

        .done{
            text-decoration : line-through;
        }
        </style>
      </head>

      <body>
      <main>
        <!-- <center>
            <div class = "alert alert-success" role = "alert">
                 Item Added Successfully!
            </div>
            <div class = "alert alert-info" role = "alert">
                 Item Marked As Done!
            </div>
            <div class = "alert alert-danger" role = "alert">
                 Item Deleted Successfully! 
            </div>
        </center> -->

            <div class = "container pt-5">
                <div class = "row">
                    <div class = "col-sm-20 col-md-8"></div>
                        <div class = "col-sm-20 col-md-8">
                            <div class = "card">
                                <div class = "card header">
                                    <p>Todo List</p>
                                    </div>
                                          <div class = "card-body" >
                        <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
                                              <div class = "mb-3">
                           <input type = "text" class = "form-control" name = "item" placeholder = "Add a Todo Item" >
                                                  </div>
                             <input type = "submit" class = "btn btn-dark" name = "add" value = "Add Item">
                        </form>
                                                        <div class = "mt-5 mb-5">
                        <!-- <center>
                            
                        <img src = "folder icon image.jpg" width = "100px"  alt = "Empty list" ><br><span>Your List Is Empty</span>

                        </center> -->

                        <?php
                           $query = "SELECT * FROM TODO";
                           $result = mysqli_query($conn,$query);
                           if($result->num_rows > 0)
                           {
                              $i = 1;
                              // var_dump($result->fetch_assoc());
                              while($row = $result->fetch_assoc())
                              {
                                     $done = $row['status'] == 1 ? "done" : "";
                                     echo '
                                     <div class = "row mt-4">
                                     <div class = "col-sm-24 col-md-1"><h5>'.$i.'</h5></div>
                                     <div class = "col-sm-24 col-md-5"><h5 class="'.$done.'">'.$row['name'].'</h5></div>
                                     <div class = "col-sm-12 col-md-6">
                                     <a href = "?action=done&item='.$row['id'].'" class = "btn btn-outline-dark">Mark As Done</a>
                                     <a href = "?action=delete&item='.$row['id'].'" class = "btn btn-outline-danger">Delete</a>
                                     </div>
                                     </div>'; 
                                     $i++;
                              }
                           }else
                            { 
                             echo 
                                 '<center>
                            
                                  <img src = "folder icon image.jpg" width = "100px"  alt = "Empty list" ><br><span>Your List Is Empty</span>

                                  </center>';
                            }
                           
                           
                          
                        
                        ?>

                         <!-- <div class = "row">
                            <div class = "col-sm-24 col-md-1"><h5>1.</h5></div>
                            <div class = "col-sm-24 col-md-5"><h5>Some Item</h5></div>
                            <div class = "col-sm-12 col-md-6">
                             <a href = "#" class = "btn btn-outline-dark">Mark As Done</a>
                             <a href = "#" class = "btn btn-outline-danger">Delete</a>
                            </div>
                         </div> -->

                                  </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
      </main>


      <!-- jQuery CDN -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <!-- javascript -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      <script>
        $(document).ready(function(){
            $(".alert").fadeTo(5000,500).slideUp(500,function(){
               $('.alert').slideUp(500);
            })
        })
      </script>
    </body>
</html>
