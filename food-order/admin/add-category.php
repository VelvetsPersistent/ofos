<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        </br>

        <?php 
            if(isset($_SESSION['add'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['add'];    //Displaying Session Message
              unset($_SESSION['add']); //Removing Session Message
                
            }
            if(isset($_SESSION['upload'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['upload'];    //Displaying Session Message
              unset($_SESSION['upload']); //Removing Session Message
                
            }
        ?>



        <!-- Add Category Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Add Category Form Start -->

        <?php 
        
            //Check whether the submit Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                // echo "clicked";

                // 1. Get the value from form
                $title = $_POST['title'];

                // for radio input, we need to check the buttom is selected or not
                if(isset($_POST['featured']))
                {
                    // Get the value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    // Set tge Default value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }
                // //Check Whether the image is selected or not and set the value for image name accordingly
                // print_r($_FILES['image']);
                
                // die();// break the code here

                if(isset($_FILES['image']['name']))
                {
                    //upload the image

                    //to upload image we need image name and source path and destination path
                    $image_name = $_FILES['image']['name'];

                    // Upload image only if image is selected
                    if($image_name != "")
                    {

                    

                    //Auto Rename our image
                    //get the extension of our image(jpg, png, gif,ect) e.g. "food1.jpg"

                    // previous code
                    // $ext = end(explode('.' ,$image_name));  
                    //The problem is, that end requires a reference, because it modifies the internal representation of the array (i.e. it makes the current element pointer point to the last element)
                    //The result of explode('.', $file_name) cannot be turned into a reference. This is a restriction in the PHP language, that probably exists for simplicity reasons.
                    
                    $tmp = explode('.',$image_name);
                    $ext = end($tmp);

                    //Rename the image
                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext;  //e.g. Food_Category_231.jpg

                    $source_path = $_FILES['image']['tmp_name'];

                    $destination_path = "../images/category/".$image_name;

                    //finally upload the image
                    $upload = move_uploaded_file($source_path, $destination_path);

                    //check whether the image is uploaded or not
                    //And if the image is not uploaded the we will stop the process and redirect with error message
                    if($upload==false)
                    {
                        //Set message
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        //Redirect to Add Category Page
                        header('location:'.SITEURL.'admin/add-category.php');
                        //Stop the Process
                        die();
                    }
                }
                    
                }
                else
                {
                    //Don't upload image and set the image_name value as 'blank'
                    $image_name="";
                }

                // 2. Create SQL Query to insert Category into Database
                $sql = "INSERT INTO tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                
                ";


                // 3. Execute the Query and save in Database
                $res = mysqli_query($conn, $sql);

                // 4. Check whether the query executed or not and data added or not
                if($res=TRUE)
                {
                    //Query executed and category added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');

                }
                else
                {
                    //Failed to add category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    //Redirect to manage category page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }


            }
        
        
        ?>

    </div>
</div>





<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>