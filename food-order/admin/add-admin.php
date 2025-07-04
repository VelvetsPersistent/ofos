<?php include ('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        </br>

        <?php 
            if(isset($_SESSION['add'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['add'];    //Displaying Session Message
              unset($_SESSION['add']); //Removing Session Message
                
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td>
                        <input type="text" name="username" placeholder="Your Username">
                    </td>
                </tr>

                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" name="password" placeholder="Your Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
    </div>
</div>



<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>

<?php 
    //Process the value from Form and Save it in database
    
    //Check whether the button is clicked or not

    if(isset($_POST['submit']))
    {
        //Button clicked 
       // echo "button clicked";

       // 1. Get the data from form
       $full_name = $_POST['full_name'];
       $username = $_POST['username'];
       $password = md5($_POST['password']); //Password Encryption with MD5 

       // 2. sql Query to save the data into database
       $sql = "INSERT INTO tbl_admin SET
            full_name= '$full_name',
            username= '$username',
            password='$password'
        ";




            // 3. Executing query and saving data into database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($con));
        
        // 4. check whether the "query is executed or not" data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //DATA inserted
           // echo "Data inserted";
           //Create a Session Variable to Display Message
           $_SESSION['add'] = "<div class='success'>Admin Added Successfully. </div>";
           //Redirect Page To Manage Admin
           header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to insert data
           // echo "failed to insert data";
           //Create a Session Variable to Display Message
           $_SESSION['add'] = "<div class='error'>Failed to Add Admin. </div>";
           //Redirect Page To Add Admin
           header("location:".SITEURL.'admin/add-admin.php');
        }  
    }

    
?>