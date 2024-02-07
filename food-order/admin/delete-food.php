<?php 

                // echo"Delete Food Page";

                // // //Include constants.php file here
                include('../config/constants.php');

                //check whether the id and image_name value is set or not
                if(isset($_GET['id']) AND isset($_GET['image_name'])) // we can use 'AND' or '&&'
                {
                        //Process to  delete
                        // echo "Process to Delete";
                        
                        //1. Get ID and image name
                        $id = $_GET['id'];
                        $image_name = $_GET['image_name'];

                        //2. Remove the image id available

                        //Remove the physical image file is available
                        if($image_name != "")
                        {
                                //Image is available. So remove it
                                $path = "../images/food/".$image_name;
                                //remove the image from folder
                                $remove = unlink($path);
                                
                                //If Failed to remove image then add an error message and stop the process
                                if($remove==false)
                                {
                                        //set the session message
                                        $_SESSION['remove'] = "<div class='error'> Failed to Remove Food Image File. </div>";
                                        //Redirect to manage category page
                                        header('location:'.SITEURL.'admin/manage-food.php');
                                        //Stop the Process
                                        die();
                                }
                        }

                        //3. delete Food from database
                        //Sql Query to Delete Data from Database
                        $sql = "DELETE FROM tbl_food WHERE id=$id";

                        //Execute the Query
                        $res = mysqli_query($conn,$sql);

                        //check whether the data is deleted from database or not
                        if($res==true)
                        {
                                //Set Success Message and Redirect, food Deleted
                                $_SESSION['delete'] = "<div class='success'> Food Deleted Successfully. </div>";
                                //Redirect to manage category page
                                header('location:'.SITEURL.'admin/manage-food.php');
                        }
                        else
                        {
                                //Set Fail Message and Redirect
                                //Set Success Message and Redirect
                                $_SESSION['delete'] = "<div class='error'> Failed to Delete Food. </div>";
                                //Redirect to manage category page
                                header('location:'.SITEURL.'admin/manage-food.php');
                        }

                        //Redirect to manage category page with message



                }
                else
                {
                        //redirect to manage Food page
                        $_SESSION['unauthorize'] = "<div class='error'> Unauthorized Access. </div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                }

      



?>