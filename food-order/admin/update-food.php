<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        </br>

        <?php 
                //Check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //Get the id and all other details
                    // echo "getting the data";
                    $id = $_GET['id'];
                    //Create SQL Query to get all other details
                    $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //get the value based on query executed
                    $row2 = mysqli_fetch_assoc($res2);

                        //get all the data of selected food
                        
                        $title=$row2['title'];
                        $description=$row2['description'];
                        $price=$row2['price'];
                        $current_image=$row2['image_name']; //from database column name, current image is image_name
                        $current_category=$row2['category_id'];
                        $featured=$row2['featured'];
                        $active=$row2['active'];
                        
                    

                }
                else
                {
                    //redirect to manage category
                    header('location:'.SITEURL.'admin/manage-category.php');
                    
                }
        
        ?>





        <!-- Update Food Form Start -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?> </textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price ?>">
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
                        <img src=" <?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                        <?php
                            }
                            else
                            {
                                //Image not available
                                echo "<div class='error'>Image Not Available.</div>";

                            }



                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image:</td>
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
                                            $category_id = $row['id'];
                                            $category_title = $row['title'];
                                            ?>
                            <option <?php if($current_category==$category_id){echo "selected";} ?>
                                value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>

                            <?php
                                        }

                                    }
                                    else
                         {
                                        // we Dont have categories
                                        ?>
                            <option value="0">Category Not Available.</option>


                            <?php
                         }
                                    
                    ?>
                        </select>


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
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>




            </table>

        </form>
        <!-- Update Food Form End -->

        <!-- Update funtion work -->
        <?php 

//Check whether the submit Button is Clicked or Not
if(isset($_POST['submit']))
{
    // echo "clicked";

    // 1. Get the value from form
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];
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

                //A. 
                    //Auto Rename our image
                    //get the extension of our image(jpg, png, gif,ect) e.g. "food1.jpg"
                    // $ext = end(explode('.' ,$image_name));  
                    //The problem is, that end requires a reference, because it modifies the internal representation of the array (i.e. it makes the current element pointer point to the last element)
                    //The result of explode('.', $file_name) cannot be turned into a reference. This is a restriction in the PHP language, that probably exists for simplicity reasons.
                    
                        
                    $tmp = explode('.',$image_name);
                    $ext = end($tmp);
                    $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext;  //e.g. Food-Name-2313.jpg

                    //get the source path and destination path
                            $src_path = $_FILES['image']['tmp_name'];
                            $dst_path = "../images/food/".$image_name;

                            //Finally upload the food image
                            $upload = move_uploaded_file($src_path, $dst_path);
                            if($upload==false)
                                {
                                    //Failed to Upload 
                                    $_SESSION['upload'] = "<div class='error'>Failed to Upload New Image.</div>";
                                    //Redirect to Manage Food Page
                                    header('location:'.SITEURL.'admin/manage-food.php');
                                    //Stop the Process
                                    die();
                                }

                //B. Remove the current image if availabe
                        if($current_image !="")
                        {
                            //current image is available then remove
                            $remove_path = "../images/food/".$current_image;

                        $remove = unlink($remove_path);

                        //check Whether the image is removed or not
                        //if failed to remove then display message and stop the process
                        if($remove==false)
                        {
                            //Failed to remove image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php'); //redirect to manage food
                            die(); //stop the process

                        }
                        }
         }
                    else
                    {
                        $image_name = $current_image; //default image when image is not selected
                    }
                   
                }
                else
                {
                    $image_name = $current_image; //default image when button is not clicked
                }

    //3. Update the Database
                $sql3 = "UPDATE tbl_food SET
                title='$title',
                description='$description',
                price=$price,
                image_name='$image_name',
                category_id='$category',
                featured='$featured',
                active='$active'
                WHERE id=$id
                    ";
            //Execute the Query
            $res3 = mysqli_query($conn, $sql3);
    
    //4. Redirect to Manage Category with Message

        //Check whether executed or not

        if($res3==true)
        {
            //Food Updated
            $_SESSION['update'] = "<div class='success'>Food Updated Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Failed to update food
            $_SESSION['update'] = "<div class='error'>Failed to Update Food.</div>";
            header('location:'.SITEURL.'admin/manage-Food.php');
        }


    
    


}


?>

    </div>
</div>





<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>