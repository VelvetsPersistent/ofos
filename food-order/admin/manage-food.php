<?php include ('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE FOOD</h1>

        <br /><br />
        <br /><br />


        <!-- Button to add Food -->

        <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

        <br /><br />

        <?php 
            if(isset($_SESSION['add'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['add'];    //Displaying Session Message
              unset($_SESSION['add']); //Removing Session Message
                
            }
            if(isset($_SESSION['delete'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['delete'];    //Displaying Session Message
              unset($_SESSION['delete']); //Removing Session Message
                
            }
            if(isset($_SESSION['remove'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['remove'];    //Displaying Session Message
              unset($_SESSION['remove']); //Removing Session Message
                
            }
            if(isset($_SESSION['unauthorize'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['unauthorize'];    //Displaying Session Message
              unset($_SESSION['unauthorize']); //Removing Session Message
                
            }
            if(isset($_SESSION['upload'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['upload'];    //Displaying Session Message
              unset($_SESSION['upload']); //Removing Session Message
                
            }
            if(isset($_SESSION['remove-failed'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['remove-failed'];    //Displaying Session Message
              unset($_SESSION['remove-failed']); //Removing Session Message
                
            }
            if(isset($_SESSION['update'])) // Checking Whether the Session is Set or Not
            {
              echo $_SESSION['update'];    //Displaying Session Message
              unset($_SESSION['update']); //Removing Session Message
                
            }
            
        ?>

        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Title</th>
                <th>Price</th>
                <th>Image</th>
                <th>Featured</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>

            <?php 

                //Query to get all food from database
                $sql = "SELECT * FROM tbl_food";

                //execute query
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //create serial number variable and assign value as 1
                $sn=1;

                //check whether we have data in database or not, food check
                if($count>0)
                {
                    //we have Food in database
                    //get the food from database and display
                    while($row=mysqli_fetch_assoc($res))
                    {   
                        // get values for individual column
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $title; ?></td>
                <td><?php echo $price; ?></td>
                <td>
                    <?php 
                    // echo $image_name; 
                    //check whether image name is available or not
                    if($image_name!="")
                    {
                        //Display the image
                        ?>

                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">

                    <?php
                    }
                    else
                    {
                        //Display the Message
                        echo "<div class='error'>Image not Added.</div>";
                    }
                    
                    ?>
                </td>

                <td><?php echo $featured; ?></td>
                <td><?php echo $active; ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>"
                        class="btn-secondary">Update Food</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>"
                        class="btn-danger">Delete Food</a>
                </td>

            </tr>
            <?php




                    }
                }
                else
                {
                    //we do not have food
                    //we will display the message inside table
            ?>
            <tr>
                <td colspan="7">
                    <div class="error">Food Not Added Yet.</div>
                </td>
            </tr>


            <?php
            
                


            
                }
            
        ?>




        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>