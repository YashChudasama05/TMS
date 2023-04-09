<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(isset($_POST['submit2']))
{
$pid=intval($_GET['pkgid']);
$useremail=$_SESSION['login'];
$fromdate=$_POST['fromdate'];
$todate=$_POST['todate'];
$comment=$_POST['comment'];
$status=0;
$payment=$_POST['payment'];
$city1=$_POST['city1'];
$city2=$_POST['city2'];
$sql="INSERT INTO tblbooking(PackageId,UserEmail,FromDate,ToDate,Comment,status,payment,city1,city2) VALUES(:pid,:useremail,:fromdate,:todate,:comment,:status,:payment,:city1,:city2)";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':comment',$comment,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':payment',$payment,PDO::PARAM_STR);
$query->bindParam(':city1',$city1,PDO::PARAM_STR);
$query->bindParam(':city2',$city2,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
  $pid=$_GET['pkgid'];
  $db=mysqli_connect('localhost','root','','tms');
$sql = "SELECT * from tbltourpackages where PackageId=$pid";
$query = mysqli_query($db,$sql);
$result=mysqli_fetch_assoc($query);
  $to=$useremail;
        $subject='Booking successfully';
        $message= 'Thankyou! Your Booking done successfully!'
        .'
        '.'
Package Name : '. $result['PackageName'].'
Package Features : '.$result['PackageFetures'].'
Package Location : '.$result['PackageLocation'].'
Payment : '.'Rs.'.$payment.'';
        $header='From:TourismExpress@gmail.com';
       $m=mail($to,$subject,$message,$header);

$msg="Booked Successfully";

}
else 
{
$error="Something went wrong. Please try again";
}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>TES | Package Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		 new WOW().init();
	</script>
<script src="js/jquery-ui.js"></script>
					<script>
						$(function() {
						$( "#datepicker,#datepicker1" ).datepicker();
						});
					</script>
	  <style>
		.errorWrap {
    padding: 40px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 40px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>				
</head>
<body>
<!-- top-header -->
<?php include('includes/header.php');?>
<div class="banner-3">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> TES -Package Details</h1>
	</div>
</div>
<!--- /banner ---->
<!--- selectroom ---->
<div class="selectroom">
	<div class="container">	
		  <?php 
      if($error)
      {?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
<?php 
$pid=intval($_GET['pkgid']);
$sql = "SELECT * from tbltourpackages where PackageId=:pid";
$query = $dbh->prepare($sql);
$query -> bindParam(':pid', $pid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<form name="book" method="post">
		<div class="selectroom_top">
			<div class="col-md-4 selectroom_left wow fadeInLeft animated" data-wow-delay=".5s">
				<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
			</div>
			<div class="col-md-8 selectroom_right wow fadeInRight animated" data-wow-delay=".5s">
				<h2><?php echo htmlentities($result->PackageName);?></h2>
				<p class="dow">#PKG-<?php echo htmlentities($result->PackageId);?></p>
				<p><b>Package Type :</b> <?php echo htmlentities($result->PackageType);?></p>
				<p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
					<p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p>

					<h3>Package Details</h3>
				<p style="padding-top: 1%"><?php echo htmlentities($result->PackageDetails);?> </p>	
				<div class="clearfix"></div>
		</div><br>
				
				<div class="clearfix"></div>
				<div class="grand">
					<!-- <p>Grand Total</p> -->
					<!-- <h3>INR.8000</h3> -->
				</div>
				<!-- <input type="date" id="dateControl2"  class="form-control" name="todate" placeholder="To Date" required> -->
            </div>

			<!-- <div class="ban-bottom">
				<div class="bnr-right">
				<label class="inputLabel">From</label>
				<input class="date" id="datepicker" type="text" placeholder="dd-mm-yyyy"  name="fromdate" required="">
			</div>
			<div class="bnr-right">
				<label class="inputLabel">To</label>
				<input class="date" id="datepicker1" type="text" placeholder="dd-mm-yyyy" name="todate" required="">
			</div>
			</div> -->

            <div class="form-group">
              <label>Select Person</label><br>
              <select name="city1" id="city1" class="form-control" onchange='payment_gen(this.value)' name="startpoint" >
                <option selected>Select</option>
                <option id="1" value="1">1</option>
                <option id="2" value="2">2</option>
                <option id="3" value="3">3</option>
                <option id="4" value="4">4</option>
                <option id="5" value="5">5</option>
                <option id="6" value="6">6</option>
                <option id="7" value="7">7</option>
                <option id="8" value="8">8</option>
              </select>
              </div>
              <div>
              <label>Total Days</label><br>
              <select name="city2" id="city2" class="form-control" onchange='payment_gen(this.value)'  name="endpoint" >
                <option selected>Select</option>
                <option id="3" value="3">3</option>
                <option id="4" value="4">4</option>
                <option id="5" value="5">5</option>
                <option id="6" value="6">6</option>
                <option id="7" value="7">7</option>
                <option id="8" value="8">8</option>
                <option id="9" value="9">9</option>
                <option id="10" value="10">10</option>
              </select>
              </div><br>

			  <div>
              <label>Payment</label><br>
              <input class="form-control" type="number" name="payment" id="textbox" name="payment" readonly>
              </div>

              <div class="selectroom-info animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp; margin-top: -70px">
				<ul>
				
					<li class="spe">
						<label class="inputLabel">Comment</label>
						<input class="special" type="text" name="comment" required="">
					</li>
					<?php if($_SESSION['login'])
					{?>
						<li class="spe" align="center">
					<button type="submit" name="submit2" class="btn-primary btn">Book</button>
						</li>
						<?php } else {?>
							<li class="sigi" align="center" style="margin-top: 1%">
							<a href="#" data-toggle="modal" data-target="#myModal4" class="btn-primary btn" > Book</a></li>
							<?php } ?>
					<div class="clearfix"></div>
				</ul>
			</div>
			
		</div>

			</div>

			<script type="text/javascript">

                function payment_gen() {
                  var city1=document.getElementById("city1").value;
                  var city2=document.getElementById("city2").value;
                  if (city1=="2" && city2=="8") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="3") {
                  var pay="4000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="4") {
                  var pay="6000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="5") {
                  var pay="5500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="6") {
                  var pay="7500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="7") {
                  var pay="9500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="8") {
                  var pay="10300";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="9") {
                  var pay="10800";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="8" && city2=="10") {
                  var pay="12500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="3") {
                  var pay="3000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="4") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="5") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="6") {
                  var pay="7500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="7") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="8") {
                  var pay="8500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="9") {
                  var pay="10700";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="8" && city2=="10") {
                  var pay="10900";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="3") {
                  var pay="4000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="4") {
                  var pay="6000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="5") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="6") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="7") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="8") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="9") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="8" && city2=="10") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="3") {
                  var pay="2000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="4") {
                  var pay="6000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="5") {
                  var pay="2000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="6") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="7") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="8") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="9") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="8" && city2=="3") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="4") {
                  var pay="2000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="5") {
                  var pay="6000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="6") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="7") {
                  var pay="2000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="8") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="9") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="3") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                }else if (city1=="8" && city2=="4") {
                  var pay="5500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="5") {
                  var pay="4000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="6") {
                  var pay="6000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="7") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="8") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="9") {
                  var pay="13000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="10") {
                  var pay="20000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="3") {
                  var pay="15000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="8" && city2=="4") {
                  var pay="5000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="5") {
                  var pay="5800";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="6") {
                  var pay="6000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="7") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="8") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="9") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="3") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="4") {
                  var pay="15000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="8" && city2=="5") {
                  var pay="11000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="1" && city2=="6") {
                  var pay="6500";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="2" && city2=="7") {
                  var pay="6700";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="3" && city2=="8") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="4" && city2=="9") {
                  var pay="7000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="5" && city2=="10") {
                  var pay="8000";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="6" && city2=="3") {
                  var pay="10700";
                  document.getElementById("textbox").value=pay;
                } else if (city1=="7" && city2=="4") {
                  var pay="8200";
                  document.getElementById("textbox").value=pay;
                } 
				else if (city1=="8" && city2=="5") {
                  var pay="12000";
                  document.getElementById("textbox").value=pay;
                } 
				else if (city1=="1" && city2=="7") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                }
				else if (city1=="1" && city2=="8") {
                  var pay="8400";
                  document.getElementById("textbox").value=pay;
                } 
				else if (city1=="1" && city2=="9") {
                  var pay="8200";
                  document.getElementById("textbox").value=pay;
                } 
				else if (city1=="1" && city2=="10") {
                  var pay="9800";
                  document.getElementById("textbox").value=pay;
                }  
                else if (city1=="2" && city2=="9") {
                  var pay="8200";
                  document.getElementById("textbox").value=pay;
                }  
                else if (city1=="2" && city2=="10") {
                  var pay="8200";
                  document.getElementById("textbox").value=pay;
                }  
                else if (city1=="3" && city2=="9") {
                  var pay="7200";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="4" && city2=="10") {
                  var pay="8700";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="5" && city2=="3") {
                  var pay="8400";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="5" && city2=="4") {
                  var pay="6800";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="5" && city2=="5") {
                  var pay="8900";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="6" && city2=="4") {
                  var pay="8300";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="6" && city2=="5") {
                  var pay="7900";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="6" && city2=="6") {
                  var pay="8700";
                  document.getElementById("textbox").value=pay;
                }  
                 else if (city1=="6" && city2=="7") {
                  var pay="9000";
                  document.getElementById("textbox").value=pay;
                }  
				else {
                  var pay=" ";
                  document.getElementById("textbox").value=pay;
                }
                }
              </script><br><br>
				
		<!-- <div class="selectroom_top">
			<h2>Travels</h2> -->
			
		</form>
<?php }} ?>


	</div>
</div>
<!--- /selectroom ---->
<!--- /footer-top ---->
<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>
</body>
</html>