<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        </br>
        </br>

        <?php 
                //Check whether the id is set or not
                if(isset($_GET['id']))
                {
                    //Get the id and all other details
                    // echo "getting the data";
                    $id = $_GET['id'];
                    //Create SQL Query to get all other details
                    $sql = "SELECT * FROM tbl_order WHERE id=$id";

                    //execute the query
                    $res = mysqli_query($conn, $sql);

                    $count = mysqli_num_rows($res);
                        //check whether food available or not
                        if($count==1)
                        {
                            //We have data
                            // Get the data from Database
                            $row = mysqli_fetch_assoc($res);

                            $food = $row['food'];
                            $price = $row['price'];
                            $qty = $row['qty'];
                            $status = $row['status'];
                            $customer_name = $row['customer_name'];
                            $customer_contact = $row['customer_contact'];
                            $customer_email = $row['customer_email'];
                            $customer_address = $row['customer_address'];

                            

                        }
                        else
                        {
                            //Detail not available
                            //Redirect to manage order page
                            header('location:'.SITEURL.'admin/manage-order.php');
                        }
                }
                else
                {
                    //redirect to manage category
                    header('location:'.SITEURL.'admin/manage-order.php');
                    
                }
        
        ?>





        <!-- Update Food Form Start -->
        <form action="" method="POST" >

            <table class="tbl-30">
                <tr>
                    <td>Food Name </td>
                    <td>
                       <b> <?php echo $food; ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                    <b> रू <?php echo $price; ?></b>
                    </td>
                </tr>
                <tr>
                    <td>Qty</td>
                    <td>
                    <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" >
                            <option <?php if($status=="Orderedrdered"){echo"selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On Delivery"){echo"selected";} ?> value="On Delivery">On Delivery</option>
                            <option <?php if($status=="Delivered"){echo"selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelle"){echo"selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>
               
                <tr>
                    <td colspan="2">
                        <!-- //delete colspan="2" in need -->
                        <imput type="hidden"name="id"value="<?php echo $id; ?>" >
                        <imput type="hidden"name="price"value="<?php echo $price; ?>" >
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
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
                    
                    $qty = $_POST['qty'];
                    $total = $price * $qty; // basic multiply
                    $status = $_POST['status']; //order kinds=ordered, on delivery, delivered, cancelled
                    $customer_name = $_POST['customer_name'];
                    $customer_contact = $_POST['customer_contact'];
                    $customer_email = $_POST['customer_email'];
                    $customer_address = $_POST['customer_address'];
                    
                    //2. Update the Values
                        $sql2 = "UPDATE tbl_order SET
                                
                                qty = $qty,
                                total = $total,
                                status = '$status',
                                customer_name = '$customer_name',
                                customer_contact = '$customer_contact',
                                customer_email = '$customer_email',
                                customer_address = '$customer_address'
                                WHERE id=$id

                        ";

                        //Execute the query
                        $res2 = mysqli_query($conn, $sql2);

                        //CHECK whether update or not

                        if($res2==TRUE)
                                {
                                    // order updated
                                    $_SESSION['update'] = "<div class='success '>Food Order Updated Successfully.</div>";
                                    header('location:'.SITEURL.'admin/manage-order.php');
                                }
                                else
                                {
                                    //Failed to Place Order
                                    $_SESSION['update'] = "<div class='error '>Failed to Update Order.</div>";
                                    header('location:'.SITEURL.'admin/manage-order.php');
                                }


                       
                    
                    


                }


        ?>

    </div>
</div>





<!-- Footer Section Starts -->
<?php include('partials/footer.php'); ?>