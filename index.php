<style>
body {
	background: #FFFFFF;
	font-family: "Trebuchet MS", Helvetica, sans-serif;
}

input 				{
  font-size:18px;
  padding:10px 10px 10px 5px;
  display:inline-block;
  width:250px;
  border:none;
  margin-bottom: 5px;
  border-bottom:1px solid #757575;
  margin-left: 8px;
  background-color: #EEEEEE;
}
input:focus 		{ outline:none; }
#center {
	width: 90%;
	margin: auto;
	background-color: #EEEEEE;
	text-align: center;
}

#submit {
	background-color: #FF4136;
	border: 1px solid white;
	color: white;
}

#submit:hover {
	background-color: #E5342B;

}
</style>
<div id="center">
<h1>Project AIUB Sections+</h1>

<form action="routine.php" method="post">
	Your Roll / ID (12-34567-8): <input type="text" name="roll_id"/> <input id="submit" type="submit" name="formSubmit" value="I've Submitted before." />
	 <br>
    Enter your registered CLASS IDS for FALL-2015 SEMESTER:<br> (Ex: 00135 is the Class ID of Programming Language 2 [A])<br>
        Enter only the classes you have registered, leave the rest empty.<br>
    <br>
    Class ID: <input type="text" name="sec1"/> <br>
    Class ID: <input type="text" name="sec2"/> <br>
    Class ID: <input type="text" name="sec3"/> <br>
    Class ID: <input type="text" name="sec4"/> <br>
    Class ID: <input type="text" name="sec5"/> <br>
    Class ID: <input type="text" name="sec6"/> <br>
    Class ID: <input type="text" name="sec7"/> <br>
    Class ID: <input type="text" name="sec8"/> <br>

    <br>
    If you want to connect with people who will attend the same classes as you, please fill the OPTIONAL fields below:
    <br>
    Your Name(optional): <input type="text" name="name"/> (ex:Abul Mia) <br>
    Your Email(optional): <input type="text" name="email"/>(ex:abul@gmail.com) <br>
    Your Facebook(optional): <input type="text" name="fbid"/>(ex:http://facebook.com/abulmia12) <br>


By clicking submit you agree that the developer of this website can not be held responsible for any error or time mismatch in your generated routine.<br>
Your submitted information is public and can be seen by other people who are in your classes.<br>
    <input id="submit" type="submit" name="formSubmit" value="Submit" />
</form>
<div style="width: 100%;text-align:center;margin-top: 10px;">Developed by <a href="http://sohan.cf">Sohan Chowdhury</a></div>

</div>
