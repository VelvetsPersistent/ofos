<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        </br>

        <?php 
                //Check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //Get the id and all other details
                    // echo "getting the data";
                    $id = $_GET['id'];
                    //Create SQL Query to get all other details
                    $sql = "SELECT * FROM tbl_category WHERE id=$id";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    //count the rows to chech whether the id is valid or not
                    $count = mysqli_num_rows($res);

                    if($count==1)
                    {
                        //get all the data
                        $row = mysqli_fetch_assoc($res);
                        $title=$row['title'];
                        $current_image=$row['image_name']; //from database column name, current image is image_name
                        $featured=$row['featured'];
                        $active=$row['active'];
                        
                    }
                    else
                    {
                        //redirect to manage category with session message
                        $_SESSION['no-category-found'] = "<div class='error'>Category not Found</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }

                }
                else
                {
                    //redirect to manage category
                    header('location:'.SITEURL.'admin/manage-category.php');
                    
                }
        
        ?>





        <!-- Update Category Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image !="")
                            {
                                //Display the Image
                             ?>
                        <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                        <?php
                            }
                            else
                            {
                                //display message
                                echo "<div class='error'>Image Not Added.</div>";

                            }



                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">

                    </td>
                </tr>


                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured"
                            value="Yes">Yes
                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active:</td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>
                <tr>

                    <td colspan="2">
                        <!-- //delete colspan="2" in need -->
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
            </table>

        </form>
        <!-- Update Category Form End -->

        <!-- Update funtion work -->
        <?php 

            //Check whether the submit Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                // echo "clicked";

                // 1. Get the value from form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];
                
                //2. Updating New Image if selected

                    //CHECK whether the image is selected or not

                    if(isset($_FILES['image']['name']))
                    {
                        //Get the image details
                        $image_name = $_FILES['image']['name'];
                        //cHECK whether the image is available or not
                        if($image_name != "")
                        {
                            //image available

                    //A. Upload the new image
                        //Auto Rename our image
                    //get the extension of our image(jpg, png, gif,ect) e.g. "food1.jpg"
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
                        header('location:'.SITEURL.'admin/manage_category.php');
                        //Stop the Process
                        die();
                    }

                            //B. Remove the current image if availabe
                            if($current_image !="")
                            {
                                $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);

                            //check Whether the image is removed or not
                            //if failed to remove then display message and stop the process
                            if($remove==false)
                            {
                                //Failed to remove image
                                $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die(); //stop the process

                            }
                            }
                        }
                        else
                        {
                            $image_name = $current_image;
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }

                //3. Update the Database
                $sql2 = "UPDATE tbl_category SET
                title='$title',
                image_name='$image_name',
                featured='$featured',
                active='$active'
                WHERE id=$id
              ";
                        //Execute the Query
                        $res2 = mysqli_query($conn, $sql2);
                
                //4. Redirect to Manage Category with Message

                    //Check whether executed or not

                    if($res2==true)
                    {
                        //Category Updated
                        $_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                    else
                    {
                        //Failed to update
                        $_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
            

                
                


            }
        
        
        ?>

    </div>
</div>





<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>