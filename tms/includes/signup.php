<?php
error_reporting(0);
if(isset($_POST['submit']))
{
$fname=$_POST['fname'];
$mnumber=$_POST['mobilenumber'];
$email=$_POST['email'];
$password=md5($_POST['password']);
$sql="INSERT INTO  tblusers(FullName,MobileNumber,EmailId,Password) VALUES(:fname,:mnumber,:email,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':mnumber',$mnumber,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Registration successfull. Now you can login');</script>";
$to=$email;
        $subject='Registration successful';
        $message= 'Your Login Details is '
.' '.
'
Full Name : '.$fname.'
Password : '.$_POST['password'].'
Email : '.$email.'';
        $header='From:TourismExpress@gmail.com';
        $m=mail($to,$subject,$message,$header);
}
else 
{
echo "<script>alert('Something went wrong. Please try again');</script>";
}
}

?>


<!--Javascript for check email availabilty-->
<script>
function checkAvailability() {

$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#email").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>						
						</div>
							<section>
								<div class="modal-body modal-spa">
									<div class="login-grids">
										<div class="login">
											<!-- <div class="login-left">
												<ul>
													<li><a class="fb" href="#"><i></i>Facebook</a></li>
													<li><a class="goog" href="#"><i></i>Google</a></li>
													
												</ul>
											</div> -->
											<div class="login-right">
												<form name="signup" method="post">
													<h3>Create your account </h3>
					
				<input type="text" placeholder="Full Name" name="fname" autocomplete="off"  required="" >
				<input type="text" value="" placeholder="Mobile number" maxlength="10" name="mobilenumber" autocomplete="off" required="">
		<input type="text" value="" placeholder="Email id" name="email" id="email" onBlur="checkAvailability()" autocomplete="off"  required="">	
		 <span id="user-availability-status" style="font-size:12px;"></span> 
	<input type="password" value="" placeholder="Password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required="">	
													<input type="submit" name="submit" id="submit" value="CREATE ACCOUNT">
												</form>
<!-- <script>
  function validateFullName() {
    var Full name = document.getElementById("Full name").value;
    // var nameError = document.getElementById("nameError");
    var nameRegex = /^[a-zA-Z]+ [a-zA-Z]+$/;

    if (!nameRegex.test(Full name)) {
      nameError.innerHTML = "Please enter a valid full name";
    } else {
      nameError.innerHTML = "";
    }
  }
</script> -->
											</div>
												<div class="clearfix"></div>								
										</div>
											<!-- <p>By logging in you agree to our <a href="page.php?type=terms">Terms and Conditions</a> and <a href="page.php?type=privacy">Privacy Policy</a></p> -->
									</div>
								</div>
							</section>
					</div>
				</div>
			</div>