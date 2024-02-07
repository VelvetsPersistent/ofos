<?php 

                // echo"Delete Page";

                // // //Include constants.php file here
                include('../config/constants.php');

                //check whether the id and image_name value is set or not
                if(isset($_GET['id']) AND isset($_GET['image_name']))
                {
                        //get the value and delete
                        // echo "Get Value and Delete";
                        $id = $_GET['id'];
                        $image_name = $_GET['image_name'];

                        //Remove the physical image file is available
                        if($image_name != "")
                        {
                                //Image is available. So remove it
                                $path = "../images/category/".$image_name;
                                //remove the image
                                $remove = unlink($path);
                                
                                //If Failed to remove image then add an error message and stop the process
                                if($remove==false)
                                {
                                        //set the session message
                                        $_SESSION['remove'] = "<div class='error'> Failed to Remove Category Image. </div>";
                                        //Redirect to manage category page
                                        header('location:'.SITEURL.'admin/manage-category.php');
                                        //Stop the Process
                                        die();
                                }
                        }

                        //delete data from database
                        //Sql Query to Delete Data from Database
                        $sql = "DELETE FROM tbl_category WHERE id=$id";

                        //Execute the Query
                        $res = mysqli_query($conn,$sql);

                        //check whether the data is deleted from database or not
                        if($res==true)
                        {
                                //Set Success Message and Redirect
                                $_SESSION['delete'] = "<div class='success'> Category Deleted Successfully. </div>";
                                //Redirect to manage category page
                                header('location:'.SITEURL.'admin/manage-category.php');
                        }
                        else
                        {
                                //Set Fail Message and Redirect
                                //Set Success Message and Redirect
                                $_SESSION['delete'] = "<div class='error'> Failed to Delete Category. </div>";
                                //Redirect to manage category page
                                header('location:'.SITEURL.'admin/manage-category.php');
                        }

                        //Redirect to manage category page with message



                }
                else
                {
                        //redirect to manage catefory page
                        header('location:'.SITEURL.'admin/manage-category.php');
                }

        



?>