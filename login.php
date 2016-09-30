<?php
session_start();
if(isset($_SESSION['username'])){
  header("location: index.php");
}
?>
<!doctype html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Team_Stripes Login</title>
  <link rel="stylesheet" type="text/css" media="all" href="css/login.css">
  <script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" charset="utf-8" src="js/jquery.leanModal.min.js"></script>
</head>

<body>

  <div id="topbar"><a>Welcome</a></div>
  <div id="w">
    <div id="content">
      <h1>Welcome to the Team Stripes</h1>
      <img  class="displayed" src="/stripes_checklist/images/Build.jpg" alt="Build Release and Co-Ordination" style="width:304px;height:228px;">
      <p style="text-align:center">Just click the login link below to expand the login window.</p>
      <a href="#RegistrationModal" class="flatbtn" id="Registertrigger" style="margin-left: 35%;">Register</a>
      <a href="#loginmodal" class="flatbtn" id="logintrigger" style="margin-left: 10%;">Login</a>
    </div>
  </div>

  <div id="loginmodal" style="display:none;">
    <h1>User Login</h1>
    <div id="loginErrMsg" style="font-size: 150%;"></div>
    <form id="loginform" name="loginform" method="post">

      <label for="username">Username:</label>
      <input type="text" name="username" id="username" class="txtfield" tabindex="1">

      <label for="password">Password:</label>
      <input type="password" name="password" id="password" class="txtfield" tabindex="2">
      <div>
        <input type="submit" name="loginbtn" id="loginbtn" class="flatbtn-blu" value="Log In" tabindex="3" >
      </div>
    </form>
  </div>

  <div id= "RegistrationModal" style="display:none;">
    <h1>User Registration</h1>
    <div id="RegistrationMsg" style="font-size: 150%;"></div>
    <form onsubmit="" id="Registrationform" name="Registrationform" method="post" >

      <label for="Newname">Name: </label>
      <input type="text" id="Newname" name="Newname" class="txtfield" autocomplete="off">

      <label for="Newusername">Email: </label>
      <input type="text" id="Newusername" name="Newusername" class="txtfield" pattern="[a-zA-Z0-9.!#$%'*+/=?^_`{|}~-]+@hpe\.com" placeholder="xyzabc@hpe.com">

      <label for="Newpassword">Password: </label>
      <input type="password" id="Newpassword" name="Newpassword" class="txtfield" autocomplete="off"> 
      <div >
        <input type="submit" name="Registerbtn" id="Registerbtn"  class="flatbtn-blu" value="Register" tabindex="3">
      </div>
    </form>
  </div >

  <script type="text/javascript">

    $(function(){
      $('#logintrigger').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
    });

    $('#loginform').submit(function( event ){
      event.preventDefault();
      username = $("#loginform").find("input[name='username']").val();
      password = $("#loginform").find("input[name='password']").val();
      data={"username":username,"password":password};
      console.log(data);
      $.post("loginValidation.php",data,function(data)
      {
        if(data == "1")
        {
          window.location.href = "index.php";
        }
        else{
          $("#loginErrMsg").html(data);
        }
        $("#loginform")[0].reset();
      });

    });

    $('#Registrationform').submit(function(event){
      event.preventDefault();
      Newname = $("#Registrationform").find("input[name='Newname']").val();
      Newusername = $("#Registrationform").find("input[name='Newusername']").val();
      Newpassword = $("#Registrationform").find("input[name='Newpassword']").val();

      data={"Newname": Newname, "Newusername": Newusername, "Newpassword": Newpassword };
      console.log(data);
      $.post("Registration.php", data, function(data){
        if (data == "1") {
          $("#RegistrationMsg").html("Record Has been Added.");
          $("#Registrationform")[0].reset();
          setTimeout(function() { window.location.reload(); }, 1000);
        }
        else
        {
         $("#RegistrationMsg").html(data);
        }
     });
    });
    $(function(){
     $('#Registertrigger').leanModal({ top: 110, overlay: 0.45, closeButton: ".hidemodal" });
   });
  </script>
</body>
</html>
