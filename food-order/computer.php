<?php include('partials-front/menu.php'); ?>


<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required />
            <input type="submit" name="submit" value="Search" class="btn btn-primary" />
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        
        //Create SQL Query to Display Food from Database
        $sql = "SELECT * FROM tbl_food WHERE active='Yes' ";
        //Execute the Query
        $res = mysqli_query($conn, $sql);
        //Count rows to check whether the category is available or not
        $count = mysqli_num_rows($res);

        if($count>0)
        {
          //categories Available
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

                                      <a href="<?php echo SITEURL;?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                  </div>
                                  </div>
                        


                      <?php

          }
          }
          else
          {
            //categories not available
            echo "<div class='error'>Food not Available.</div>";
          }
      
      
      ?>

        

       

        <div class="clearfix"></div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>