 <?php


include_once("session.php");

$msg = '';

$sendFlag = true;


if(empty($_POST['email']))
{
	$sendFlag = false;
}
else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $msg.='<p style="color:red;">Invalid email address</p>';
    $sendFlag = false;
}

if(!empty($_POST['captcha_contact'])) { 
	$ccode = explode("_",$_POST['captcha_contact']);
	$ccode_sess=$_SESSION['captcha_contact_captchaCodes'][$_SESSION['captcha_contact_captchaAnswer']];

	if(trim($_POST['captcha_contact']) == ''){
			$msg.='<p style="color:red;">Captcha empty</p>';
			$sendFlag = false;
	}	
	else if(trim($ccode[1]) != $ccode_sess){
	 		$msg.='<p style="color:red;">Invalid Captcha</p>';
	 		$sendFlag = false;
 }
}


if($sendFlag){	
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	//email('to','subject','from','body');
	header("Location: index.php?action=success");
	//header("Location: index.html");

}
	
	if(!empty($_GET['action']) && $_GET['action'] == 'success')
		$msg.='<p style="color:green;">Email sent successfully</p>';	

?>


<!doctype html>
<html>
<head>
	
<meta charset="utf-8">
<title>Sexy Captcha Php</title>



 <link rel="stylesheet" type="text/css" href="sexy-captcha/styles.css" />
 




<style>
html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video{
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	font: inherit;
	vertical-align: baseline;
}
.Outer{ width:970px; height:auto; overflow:hidden; margin:30px auto; padding:20px 20px; color:#a4a6a9}
.Envelop{ width:700px; height:495px; no-repeat; margin:30px auto; text-align:center; padding-top:25px;}
.TextAlignCent{ text-align:center;}
.Txt01{ font-size:17px; letter-spacing:1px;}
.Txt02{ font-size:17px;}
.space40{ margin:15px 0;}
.space20{ margin:10px 0;}
.bold{ font-weight:bold;}
.blueLink{ color:#0074bd; text-decoration:none; font-weight:bold;}
.blueLink:hover{ color:#ec1b21;}
.blueLink{ color:#0074bd;}
.TxtField{ display:inline-block; margin:0 12px; border:1px solid #cacaca; padding:6px; border-radius:4px;}
.FieldStyle{ border:none;}
input[type="text"], input[type="password"], textarea, select {outline: none; color:#0074bd}
.NotifyBtn{ display:inline-block; }
.NotifyBtn a{ padding:8px 16px; background-color:#ec1b21; border-radius:6px; text-decoration:none; color:#fff; font-weight:bold;
border-bottom: 5px solid #9f0f13;}
.NotifyBtn:hover{ background-color:#fc060d; cursor: hand;}
.contect_input {padding: 0 30px;display: block;}
.signup-form-label {display: block;}
.button{ padding:8px 16px; background-color:#ec1b21; border-radius:6px; text-decoration:none; color:#fff; font-weight:bold;
border-bottom: 5px solid #9f0f13;}
</style>
</head>

<body>
<div class="Outer">
	
   
    <div class="Envelop">
    	
        <p class="TextAlignCent Txt02 space40"><a href="#" target="_self" class="blueLink">Sign up</a> here and <strong>get unlimited download access!</strong></p>

    <form name="signup" id="signup" action="index.php" method="post">
    	<div id="html_element">
    		<?php 
			 if(!empty($msg) && $msg !='')
			 	echo $msg;
			 ?>
    	</div>
    	  
        <div class="TextAlignCent space20">
        	<div class="TxtField"><input name="name" type="text" placeholder="Your Name" class="FieldStyle" /></div>
            <div class="TxtField"><input name="email" type="text" placeholder="Email"  class="FieldStyle" /></div>
        </div>
        
       

        <div class="TextAlignCent space20">
        	<span class="contect_input">
            <label class="signup-form-label">In order to prevent abuse, we ask that you drag the correct figure to the right, into the box. The box will then turn green and you can send your message.</label>
            <div class="myCaptcha"  id="contactContainer"></div>
         </span>
         </div>


        <div class="TextAlignCent space40">
        	<div class="NotifyBtn">
        		<input class="button" type="submit" value="Notify Me">
        		</div>
        		</div>      
    </form>
    
    
    </div>
</div>

 <script type="text/javascript" src="./js/jquery.min.js"></script>
 <script src="./js/jquery-ui.js"></script>
 <script type="text/javascript" src="./js/jquery.sexy-captcha-0.1.js"></script> 

<script type="text/javascript" src="./js/jquery.validate.min.js"></script>
 
<script type="text/javascript">



 $(function() {

 	$('#contactContainer').sexyCaptcha('captcha.process.php?captcha_name=captcha_contact');


	$("#signup").validate(
      {
        rules: 
        {
          name: 
          {
            required: true
          },
          email: 
          {
            required: true            
          }
        },
        messages: 
        {
          name: 
          {
            required: "Please enter your name."
          },
          display_name: 
          {
            required: "Please enter your email address."
          }
        }
      });   

}); 

</script>
</body>
</html>