<?php include('partials-front/menu.php'); ?>

<?php 
        //check whether id is passed or not
        if(isset($_GET['category_id']))
        {
            //category id is set and get the id
            $category_id = $_GET['category_id'];
            //get the category title based on category id
            $sql = "SELECT title FROM tbl_category WHERE id=$category_id";
            //execute the query
            $res = mysqli_query($conn, $sql);
            //get the value from database
            $row = mysqli_fetch_assoc($res);
            //get the title
            $category_title = $row['title'];

        }
        else
        {
            //category not passed, redirect to home page
            header('location:'.SITEURL);
        }

?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <h2>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 

            //create SQL Query to get foods based on selected category
            $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";

            //execute the query
            $res2 = mysqli_query($conn, $sql2);

            //count rows
            $count2 = mysqli_num_rows($res2);

            //check food available or not
            if($count2>0)
            {
              //Food Available
              while($row2=mysqli_fetch_assoc($res2))
              {
                //Get the values like id, title, image_name
                  $id = $row2['id'];
                  $title = $row2['title'];
                  $price = $row2['price'];
                  $description = $row2['description'];
                  $image_name = $row2['image_name'];
                      
                    //close php   
                          ?>
                              <div class="food-menu-box">
                                      <div class="food-menu-img">
                                          <?php
                                              //check whether image is available or not
                                                  if($image_name=="")
                                                  {
                                                  //Disaply Message
                                                  echo"<div class='error'>Image not Available.</div>";
                                                  }
                                                  else
                                                  {
                                                      //Image Available
                                                    
                                                      ?>
                                                      <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name;?>" alt="Pizza"
                                                          class="img-responsive img-curve" />
                                                      <?php 
                                                  } 
                                          ?>
                                          
                                      </div>
    
                                      <div class="food-menu-desc">
                                          <h4><?php echo $title; ?></h4>
                                          <p class="food-price">रू<?php echo $price; ?></p>
                                          <p class="food-detail">
                                              <?php echo $description; ?>
                                          </p>
                                          <br />
    
                                          <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                      </div>
                                      </div>
                            
    
    
                          <?php
    
              }
            }
            else
              {
                //Food not available
                echo "<div class='error'>Food not Available.</div>";
              }


        ?>

        

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>