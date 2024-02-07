<?php include ('partials/menu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        </br>

        <?php 
            if(isset($_SESSION['upload'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['upload'];    //Displaying Session Message
              unset($_SESSION['upload']); //Removing Session Message
                
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title:</td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>


                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"
                            placeholder="Description of the Food"> </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">

                            <?php
                                    //Create PHP code to display categories from Database
                                    //1. Create SQL to get all active categories from database
                                    $sql = "SELECT *FROM tbl_category WHERE active='Yes'";

                                    //Executing the Query
                                    $res = mysqli_query($conn, $sql);

                                    //Count Rows to check whether we have categories on not
                                    $count = mysqli_num_rows($res);

                                    //If count id greater than zero, we have categories else we dont have categories
                                    if($count>0)
                                    {
                                        //we have categories
                                        while($row=mysqli_fetch_assoc($res))
                                        {
                                            //GEt the details of categories
                                            $id = $row['id'];
                                            $title = $row['title'];
                                            ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                            <?php
                                        }

                                    }
                                    else
                                    {
                                        // we Dont have categories
                                        ?>
                            <option value="0">No Category Found</option>


                            <?php
                                    }
                                    //2. Display on DropDown
                            ?>


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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>

        <?php
             if(isset($_POST['submit']))
             {
                 //Add the Food in Database
                // echo "button clicked";

                // 1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
                
                //Check whether radio button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; // setting default value
                }
                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; // setting default value
                }


                //2. upload the image if selected
                //check whether the select image is clicked or not and upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get the details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether the image is selected or not and upload image only if selected
                    if($image_name != "")
                    {
                        //imgae is selected
                        //A. Rename the image
                        //get the extension of our image(jpg, png, gif,etc) e.g. "food1.jpg"
                        // $ext = end(explode('.' ,$image_name));  
                    //The problem is, that end requires a reference, because it modifies the internal representation of the array (i.e. it makes the current element pointer point to the last element)
                    //The result of explode('.', $file_name) cannot be turned into a reference. This is a restriction in the PHP language, that probably exists for simplicity reasons.
                    
                        
                        $tmp = explode('.',$image_name);
                        $ext = end($tmp);


                        //Create new name for image
                            $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;  //e.g. Food-Name-231.jpg

                        //B. Upload the image
                            //get the src path and destination path

                            //source path is the current location of the image

                            $src = $_FILES['image']['tmp_name'];

                            // Destination path for the image to be uploaded

                            $dst = "../images/food/".$image_name;

                            //Finally upload the food image
                            $upload = move_uploaded_file($src, $dst);
                            if($upload==false)
                                {
                                    //Set message
                                    $_SESSION['upload'] = "<div class='error'>Failed to Upload Imgae.</div>";
                                    //Redirect to Add Food Page
                                    header('location:'.SITEURL.'admin/add-food.php');
                                    //Stop the Process
                                    die();
                                }
                    

                    }
                    

                    
                }
                else
                {
                    $image_name = ""; //setting default value is blank
                }

                //3. Insert into database

                // Create SQL Query to insert Category into Database
                    $sql2 = "INSERT INTO tbl_food SET
                    title='$title',
                    description='$description',
                    -- //'' is for string value, not integer
                    price=$price, 
                    image_name='$image_name',
                    category_id='$category',
                    featured='$featured',
                    active='$active'
                    ";

                    // Execute the Query and save in Database
                            $res2 = mysqli_query($conn, $sql2);

                        // Check whether the query executed or not and data added or not
                            if($res2=TRUE)
                            {
                                //DAta inserted successfully
                                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                                //Redirect to manage food page
                                header('location:'.SITEURL.'admin/manage-food.php');

                            }
                            else
                            {
                                //Failed to add food
                                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                                //Redirect to manage food page
                                header('location:'.SITEURL.'admin/manage-food.php');
                            }

                

             }

        ?>




    </div>
</div>



<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>