<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->

<section class="food-search text-center">
<div class="banner-txt">
                <h1>Delicious Food</h1>
                <p>Get Yourself Lost in the Large Variety of Quality Goods</p>
                <div class="banner-btn">
                    <a href="<?php echo SITEURL; ?>contact.php"><span></span>Find Out</a>
                    <a href="<?php echo SITEURL; ?>aboutus.php"><span></span>Read More</a>

                </div>
            </div>
    <div class="container ">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search"   name="search" placeholder="Search for Goods..." required />
            <input type="submit" name="submit" value="Search" class="btn btn-primary" />
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php 
    if(isset($_SESSION['order'])) // Checking Whether the Session is Set or Not
    {
      echo $_SESSION['order'];    //Displaying Session Message
      unset($_SESSION['order']); //Removing Session Message
        
    }

?>

<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
        
          //Create SQL Query to Display Categories from Database
          $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
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
                $image_name = $row['image_name'];
                    
                  //close php   
                        ?>

                          <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">

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
                                           <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name?>" alt="Pizza"
                                            class="img-responsive img-curve" />
                                          <?php 
                                    } 
              
                                  ?>
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>

                              </div>
                            </a>


                        <?php

            }
          }
          else
          {
            //categories not available
            echo "<div class='error'>Category not Added.</div>";
          }
        
        
        ?>


        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

      <?php
        
        //Create SQL Query to Display Food from Database
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);
        //Count rows to check whether the Food is available or not
        $count2 = mysqli_num_rows($res2);

        if($count2>0)
        {
          //Food Available
          while($row=mysqli_fetch_assoc($res2))
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

    <p class="text-center">
        <a href="#">See All Foods</a>
    </p>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>