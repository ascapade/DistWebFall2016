<?php
/**
 * Created by PhpStorm.
 * User: edwin-young
 * Date: 11/25/2016
 * Time: 4:11 PM
 */
session_start();
require_once("php/config.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM inventory WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('productName'=>$productByCode[0]["productName"], 'code'=>$productByCode[0]["code"],'pictureLink'=>$productByCode[0]["pictureLink"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));

                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],$_SESSION["cart_item"])) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productByCode[0]["code"] == $k)
                                $_SESSION["cart_item"][$k]["quantity"] = $_POST["quantity"];

                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            }
            break;
        case "remove":
            if(!empty($_SESSION["cart_item"])) {
                foreach($_SESSION["cart_item"] as $k => $v) {
                    if($_GET["code"] == $k)
                        unset($_SESSION["cart_item"][$k]);
                    if(empty($_SESSION["cart_item"]))
                        unset($_SESSION["cart_item"]);
                }
            }
            break;
        case "empty":
            unset($_SESSION["cart_item"]);
            break;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width= device-width, initial-scale = 1">

        <title>Tech Savvy</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

        <link href='https://fonts.googleapis.com/css?family=Roboto+Slab' rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
        <style type="text/css">
            #logoText{
                font-family: 'Roboto Slab';
            }
        </style>
    </head>

    <body>


    <!-- Collapsible Navigation Bar -->
    <div class="container">

        <!-- .navbar-fixed-top, or .navbar-fixed-bottom can be added to keep the nav bar fixed on the screen -->
        <nav class="navbar navbar-fixed-top">
            <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">

                    <!-- Button that toggles the navbar on and off on small screens -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">

                        <!-- Hides information from screen readers -->
                        <span class="sr-only"></span>

                        <!-- Draws 3 bars in navbar button when in small mode -->
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- You'll have to add padding in your image on the top and right of a few pixels (CSS Styling will break the navbar) -->
                    <a class="pull-left" href="#">
                        <img src="logoSM.png" width="40" length="40" id="logo" >

                    </a>

                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">About Us</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">T-Shirts <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="mensshirts.php">Mens</a></li>
                                <li><a href="wmsshirts.php">Womens</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="tshirts.php">View Selection</a></li>
                            </ul>
                        <li></li>
                        </li>
                    </ul>
                    <!-- navbar-left will move the search to the left -->
                    <form class="navbar-form navbar-right" role="search">
                        <div class="form-group">
                            <a href="shoppingcart.php" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart">
                            </span>
                                <?php
                                if(isset($_SESSION["cart_item"])) {
                                    $item_total = 0;
                                    ?>
                                    <?php echo sizeof($_SESSION["cart_item"]); ?>
                                    <?php
                                }
                                ?>
                            </a>

                            <input type="text" class="form-control search" placeholder="Search">

                            <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></button>

                        </div>

                    </form>
                    <button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#modalSignin"  id="btnSignIn">Sign in</button>
                    <p id="loggedInUser"></p>

                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
    <br>
    <br>
    <br>






    <br>






    <div class="container">
        <div class="page-header">
            <h1>Shopping Cart</h1>
        </div>
    </div>

    <div id="shopping-cart">
        <div class="txt-heading">Shopping Cart <a id="btnEmpty" href="shoppingcart.php?action=empty">Empty Cart</a></div>
        <?php
        if(isset($_SESSION["cart_item"])){
        $item_total = 0;
        ?>
        <table class="table table-hover" cellpadding="10" cellspacing="1">
            <tbody>
            <tr>
                <th><strong>Name</strong></th>
                <!--<th><strong>Code</strong></th>-->
                <th><strong>Quantity</strong></th>
                <th><strong>Price</strong></th>
                <th><strong>Action</strong></th>
            </tr>
            <?php
            foreach ($_SESSION["cart_item"] as $item) {
                ?>
                <tr>
                    <td><div class="product-image"><a href="<?php echo "" . $item["code"] . ".php";?>"><img src="<?php echo "images/thumbnails/" . $item["code"] . "_tn.jpg"; ?>"></a></div>
                        <div><strong><?php echo $item["productName"]; ?></strong></div>
                    </td>
                    <!--<td></td>-->
                    <td><?php echo $item["quantity"]; ?></td>
                    <td align=right><?php echo "$" . $item["price"]; ?></td>
                    <td><a href="shoppingcart.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">Remove
                            Item</a></td>
                </tr>
                <?php
                $item_total += ($item["price"] * $item["quantity"]);
            }
            ?>

            <tr>
                <td colspan="5" align=right><strong>Total:</strong> <?php echo "$" . $item_total; ?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php
    }
    ?>
    <!--<div class="row">
        <div class="col-sm-12 col-md-10 col-md-offset-1">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Total</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="col-sm-8 col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="picMwhiteT.jpg" style="width: 72px; height: 102px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">White T-Shirt /M</a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                <span>Status: </span><span class="text-success"><strong>In Stock</strong></span>
                            </div>
                        </div></td>
                    <td class="col-sm-1 col-md-1" style="text-align: center">
                        <input type="email" class="form-control" id="exampleInputEmail1" value="1">
                    </td>
                    <td class="col-sm-1 col-md-1 text-center"><strong>$45.99</strong></td>
                    <td class="col-sm-1 col-md-1 text-center"><strong>$45.99</strong></td>
                    <td class="col-sm-1 col-md-1">
                        <button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button></td>
                </tr>
                <tr>
                    <td class="col-md-6">
                        <div class="media">
                            <a class="thumbnail pull-left" href="#"> <img class="media-object" src="picWwhiteT.jpg" style="width: 72px; height: 102px;"> </a>
                            <div class="media-body">
                                <h4 class="media-heading"><a href="#">White T-Shirt /W</a></h4>
                                <h5 class="media-heading"> by <a href="#">Brand name</a></h5>
                                <span>Status: </span><span class="text-warning"><strong>Leaves warehouse in 2 - 3 weeks</strong></span>
                            </div>
                        </div></td>
                    <td class="col-md-1" style="text-align: center">
                        <input type="email" class="form-control" id="exampleInputEmail1" value="1">
                    </td>
                    <td class="col-md-1 text-center"><strong>$45.99</strong></td>
                    <td class="col-md-1 text-center"><strong>$45.99</strong></td>
                    <td class="col-md-1">
                        <button type="button" class="btn btn-danger">
                            <span class="glyphicon glyphicon-remove"></span> Remove
                        </button></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Subtotal</h5></td>
                    <td class="text-right"><h5><strong>$92.00</strong></h5></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Estimated shipping</h5></td>
                    <td class="text-right"><h5><strong>$6.94</strong></h5></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h3>Total</h3></td>
                    <td class="text-right"><h3><strong>$98.94</strong></h3></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <button type="button" class="btn btn-default">
                            <span class="glyphicon glyphicon-shopping-cart"></span> Continue Shopping
                        </button></td>
                    <td>
                        <button type="button" class="btn btn-success">
                            Checkout <span class="glyphicon glyphicon-play"></span>
                        </button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>-->



    <!-- Modals -->
    <div class="modal fade clickable" id="modalSignin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h1 class="modal-title">Sign In</h1>
                </div>
                <div class="modal-body">
                    <img class="img-responsive" src="images/logos/fadelogo.jpg"/>
                    <form class="login" action="./php/login.php" method="post">
                        <div class="form-group">
                            <label for="" class="control-label">Please Sign in</label>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Email</span>
                                <input type="text" class="form-control" id="" name="loginEmail">
                            </div>
                            <br>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Password</span>
                                <input type="password" class="form-control" id="" name="loginPassword">
                            </div>
                        </div>
                        <div class="text-right">
                            <a data-toggle="modal" data-target="#modalRegister">Register</a>
                            <button type="submit" class="btn btn-success">
                                Sign In
                                <span class="glyphicon glyphicon-play">
										</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade clickable" id="modalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                    <h1 class="modal-title">Sign Up</h1>
                </div>
                <div class="modal-body">
                    <img class="img-responsive" src="images/logos/fadelogo.jpg"/>
                    <div class="form-group">
                        <form name="register" action="./php/register.php" method="post">
                            <label for="" class="control-label">Sign Up</label>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">First Name</span>
                                <input type="text" class="form-control" id="txtFname" name="fname">
                            </div>
                            <br>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Last Name</span>
                                <input type="text" class="form-control" id="txtLname" name="lname">
                            </div>
                            <br>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Email</span>
                                <input type="text" class="form-control" id="txtEmail" name="email">
                            </div>
                            <br>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Location</span>
                                <input type="text" class="form-control" id="txtLocation" name="location">
                            </div>
                            <br>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Password</span>
                                <input type="password" class="form-control" id="txtPass" name="password">
                            </div>
                            <br>
                            <div class="input-group input-group-md">
                                <span class="input-group-addon">Confirm Password</span>
                                <input type="password" class="form-control" id="txtPass2">
                            </div>
                            <div class="text-right">
                                <br>
                                <button type="submit" class="btn btn-success">
                                    Register
                                    <span class="glyphicon glyphicon-play">
											</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/checkLogin.js"></script>
        <script src="js/logout.js"></script>
    </div></body>

</html>
