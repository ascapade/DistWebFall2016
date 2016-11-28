<?php
/**
 * Created by PhpStorm.
 * User: edwin-young
 * Date: 11/25/2016
 * Time: 3:56 PM
 */

session_start();
require_once("php/config.php");
$db_handle = new DBController();
if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
        case "add":
            if(!empty($_POST["quantity"])) {
                $productByCode = $db_handle->runQuery("SELECT * FROM inventory WHERE code='" . $_GET["code"] . "'");
                $itemArray = array($productByCode[0]["code"]=>array('productName'=>$productByCode[0]["productName"], 'code'=>$productByCode[0]["code"], 'quantity'=>$_POST["quantity"], 'price'=>$productByCode[0]["price"]));

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
    <script src="js/test-shirts.js"></script>
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
    <nav class="navbar navbar-fixed-top" style="background: #2242c6;">
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


                <a class="pull-left" href="index.php">
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
                            </span><?php
                            if(isset($_SESSION["cart_item"])) {
                                $item_total = 0;
                                ?>
                                <?php echo sizeof($_SESSION["cart_item"]); ?>
                                <?php
                            }
                            ?>
                        </a>

                        <input type="text" class="form-control" placeholder="Search">

                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></button>

                    </div>

                </form>
                <button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#modalSignin" id="btnSignIn">Sign in</button>
                <p id="loggedInUser"></p>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</div>
<br>
<br>
<br>








<div class="container">
    <div class="page-header">
        <h1>Womens T-Shirts</h1>
    </div>
</div>

<!-- Thumbnails -->
<div class="container">

    <?php
    $product_array = $db_handle->runQuery("SELECT * FROM inventory WHERE gender='female' ORDER BY product_id ASC");
    if (!empty($product_array)) {
        foreach($product_array as $key=>$value){
            ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <form method="post" action="tshirts.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                    <div class="product-image"><a href="<?php echo "" . $product_array[$key]["code"] . ".php";?>"><img src="<?php echo $product_array[$key]["pictureLink"]; ?>"></a></div>
                    <div><strong><?php echo $product_array[$key]["productName"]; ?></strong></div>
                    <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                    <div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
                </form>
            </div>
            <?php
        }
    }
    ?>
    <!--<div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail">
                <img src="picWwhiteT.jpg" alt="...">
                <div class="caption">
                    <a href="w.html"><h4>W/ Basic White Tee</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail">
                <img src="images/shirts/womens-1.jpg" alt="...">
                <div class="caption">
                    <a href="w1.html"><h4>W/ C Shirt</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail">
                <img src="images/shirts/womens-2.jpg" alt="...">
                <div class="caption">
                    <a href="w2.html"><h4>W/ Abstract Shirt</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail ">
                <img src="images/shirts/womens-3.jpg" alt="...">
                <div class="caption">
                    <a href="w3.html"><h4>W/ Sleep Shirt</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
    </div>-->
</div>


<div class="container">
    <div class="text-right">
        <a href="wmsshirts.php"><h4>View More&raquo;</h4></a>
    </div>
</div>







<hr>







<div class="container">
    <div class="page-header">
        <h1>Mens T-Shirts</h1>
    </div>
</div>

<!-- Thumbnails -->
<div class="container">
    <?php
    $product_array = $db_handle->runQuery("SELECT * FROM inventory WHERE gender='male' ORDER BY product_id ASC");
    if (!empty($product_array)) {
        foreach($product_array as $key=>$value){
            ?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <form method="post" action="tshirts.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>">
                    <div class="product-image"><a href="<?php echo "" . $product_array[$key]["code"] . ".php";?>"><img src="<?php echo $product_array[$key]["pictureLink"]; ?>"></a></div>
                    <div><strong><?php echo $product_array[$key]["productName"]; ?></strong></div>
                    <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                    <div><input type="text" name="quantity" value="1" size="2" /><input type="submit" value="Add to cart" class="btnAddAction" /></div>
                </form>
            </div>
            <?php
        }
    }
    ?>
    <!--<div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail">
                <img src="picMwhiteT.jpg" alt="...">
                <div class="caption">
                    <a href="m.html"><h4>M/ Basic White Tee</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail">
                <img src="images/shirts/mens-1.jpg" alt="...">
                <div class="caption">
                    <a href="m1.html"><h4>M/ App Shirt</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail">
                <img src="images/shirts/mens-2.jpg" alt="...">
                <div class="caption">
                    <a href="m2.html"><h4>M/ Friendly Shirt</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
            <div class="thumbnail ">
                <img src="images/shirts/mens-3.jpg" alt="...">
                <div class="caption">
                    <a href="m3.html"><h4>M/ IT Shirt</h4></a>
                    <p>$45.oo</p>
                    <p><a href="javascript:;" class="btn btn-primary" role="button" onclick="incrementValue()">Add to Cart</a></p>
                </div>
            </div>
        </div>
    </div>-->
</div>

<div class="container">
    <div class="text-right">
        <a href="mensshirts.php"><h4>View More&raquo;</h4></a>
    </div>
</div>




<hr>




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
