<?php include ('partials/menu.php'); ?>

<!-- Main Content Section Starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>MANAGE ORDER</h1>



        <br /><br />

        <?php 
            if(isset($_SESSION['update'])) // Checking Whether the Session is Set or Not
            {
            echo $_SESSION['update'];    //Displaying Session Message
            unset($_SESSION['update']); //Removing Session Message
                
            }

        ?>
        <br />
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>

            <?php 

                //Get all the orders from database
                $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //Display the latest order 
                //execute Query
                $res = mysqli_query($conn, $sql);
                //Count the rows
                $count = mysqli_num_rows($res);

                $sn = 1;

                if($count>0)
                {
                    //Order Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get all the order details
                        $id=$row['id'];
                        $food=$row['food'];
                        $price=$row['price'];
                        $qty=$row['qty'];
                        $total=$row['total'];
                        $order_date=$row['order_date'];
                        $status=$row['status'];
                        $customer_name=$row['customer_name'];
                        $customer_contact=$row['customer_contact'];
                        $customer_email=$row['customer_email'];
                        $customer_address=$row['customer_address'];


                        ?>
                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $food; ?></td>
                                    <td><?php echo $price; ?></td>
                                    <td><?php echo $qty; ?></td>
                                    <td><?php echo $total; ?></td>
                                    <td><?php echo $order_date; ?></td>

                                    <td>
                                        <?php
                                        //Ordered , on delivery, delivered, cancelled
                                        if($status=="Ordered")
                                        {
                                            echo "<label style ='color: blue;'>$status</label>";
                                        }
                                        else if($status=="On Delivery")
                                        {
                                            echo "<label style ='color: orange;'>$status</label>";
                                        }
                                        else if($status=="Delivered")
                                        {
                                            echo "<label style ='color: green;'>$status</label>";
                                        }
                                        else if($status=="Cancelled")
                                        {
                                            echo "<label style ='color: red;'>$status</label>";
                                        }
                                    
                                        
                                        
                                        ?>
                                
                                        
                                    </td>

                                    <td><?php echo $customer_name; ?></td>
                                    <td><?php echo $customer_contact; ?></td>
                                    <td><?php echo $customer_email; ?></td>
                                    <td><?php echo $customer_address; ?></td>

                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">update Order</a>
                                        
                                    </td>

                                </tr>

                        <?php
                    }
                }
                else
                {
                    //Order not available
                    echo"<tr><td colspan='12' class='error'>Order not Available.</td></tr>";
                }
            
            ?>





        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>