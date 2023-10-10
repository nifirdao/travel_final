<!DOCTYPE html>
<html>

<head>
    <?php include('h.php');
    error_reporting(0);
    ?>

    <head>

    <body>
        <div class="container">
            <?php include('navbar.php'); ?>
            <p></p>
            <div class="row">
                <div class="col-md-3">
                    <!-- Left side column. contains the logo and sidebar -->
                    <?php include('menu_left.php'); ?>
                    <!-- Content Wrapper. Contains page content -->
                </div>

                <div class="col-md-9">
                    

                    <?php
                
                    include('member_list.php');
                    ?>
                </div>

            </div>
        </div>

    </body>

</html>