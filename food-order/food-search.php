<?php include('partials-front/menu.php'); ?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

    <?php 

        //get the search keyword
        $search = $_POST['search'];

    ?>

        <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php 

            

            //SQL Query to get foods based on search keyword
            $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

            //Execute the Query
            $res = mysqli_query($conn, $sql);

            //count rows
            $count = mysqli_num_rows($res);

            //check food available or not
            if($count>0)
            {
              //Food Available
              while($row=mysqli_fetch_assoc($res))
              {
                //Get the values like id, title, image_name
                  $id = $row['id'];
                  $title = $row['title'];
                  $price = $row['price'];
                  $description = $row['description'];
                  $image_name = $row['image_name'];
                      
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
    
                                          <a href="order.php" class="btn btn-primary">Order Now</a>
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