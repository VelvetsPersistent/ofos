<?php include('partials-front/menu.php'); ?>

<?php 

    //check whether id is passed or not
    if(isset($_GET['food_id']))
    {
        //Food id is set and get the id
        $food_id = $_GET['food_id'];
        //get the Food details based on food id
        $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
        //execute the query
        $res = mysqli_query($conn, $sql);
        //count the rows
        $count = mysqli_num_rows($res);
        //check whether food available or not
        if($count==1)
        {
            //We have data
            // Get the data from Database
            $row = mysqli_fetch_assoc($res);
            
            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
            

        }
        else
        {
            //food not available
            //Redirect to home page
            header('location:'.SITEURL);
        }

    }
    else
    {
        //category not passed, redirect to home page
        header('location:'.SITEURL);
    }

?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">
            Fill this form to confirm your order.
        </h2>

        <form action="" method="POST" class="order" >
            <fieldset>
                <legend>Selected Food</legend>

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
                    <h3><?php echo $title; ?></h3>   
                    <imput type="hidden" name="food23" value="<?php echo $title; ?>" >

                    <p class="food-price">रू<?php echo $price; ?></p>
                    <imput type="hidden" name="price23" value="<?php echo $price; ?>" >

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required />
                </div>
            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. KP Oli" class="input-responsive" required />

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 98xxxxxxxx" class="input-responsive" required />

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. kpoli@gmail.com" class="input-responsive" required />

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary" />
            </fieldset>
        </form>

        <?php
                //check whether submit button is clicked or not
                        if(isset($_POST['submit']))
                        {
                            //get all the details from the form
                            
                            
                            
                            $qty = $_POST['qty'];
                            $total = $price * $qty; // basic multiply
                            $order_date = date('y-m-d h:i:sa'); ///order date
                            $status = 'ordered'; //order kinds=ordered, on delivery, delivered, cancelled
                            $customer_name = $_POST['full-name'];
                            $customer_contact = $_POST['contact'];
                            $customer_email = $_POST['email'];
                            $customer_address = $_POST['address'];


                            //Save the order in database
                            //Create SQL to save database

                            $sql2 = "INSERT INTO tbl_order SET 
                                    food = '$title',
                                    price = $price,
                                    qty = $qty,
                                    total = $total,
                                    order_date = '$order_date',
                                    status = '$status',
                                    customer_name = '$customer_name',
                                    customer_contact = '$customer_contact',
                                    customer_email = '$customer_email',
                                    customer_address = '$customer_address'

                                ";

                                //  echo $sql2; die();

                                //Execute the query
                                $res2 = mysqli_query($conn, $sql2);
                                //check whether whether query executed or not
                                if($res2==true)
                                {
                                    // Query executed and order saved placed
                                    $_SESSION['order'] = "<div class='success text-center'>Food Order Placed Successfully.</div>";
                                    header('location:'.SITEURL);
                                }
                                else
                                {
                                    //Failed to Place Order
                                    $_SESSION['order'] = "<div class='error text-center'>Failed to Place Order.</div>";
                                    header('location:'.SITEURL);
                                }



                        }
        ?>



    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>