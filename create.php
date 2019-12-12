<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */

require "../config.php";
require "../common.php";

if (isset($_POST['submit'])) {
  if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();

  try  {
    $connection = new PDO($dsn, $username, $password, $options);
    
    $new_user = array(
      "firstname" => $_POST['firstname'],
      "lastname"  => $_POST['lastname'],
      "email"     => $_POST['email'],
      "age"       => $_POST['age'],
      "location"  => $_POST['location']
    ); 
	$x=0;
	
	if($_POST['firstname']=="")
	{
		echo "first name is not entered<br>";
		$x++;
	}
	else if(preg_match("/^[a-zA-Z ]*$/",$_POST['firstname'])===0)
	{
		echo "name not numeric <br>";
		$x++;
	}
	if(preg_match("/^[a-zA-Z ]*$/",$_POST['lastname'])===0)
	{
		echo "lastname not numeric";
		$x++;
	}
	if($_POST['email']=="")
	{
		echo "enter  correct email<br>";
		$x++;
	}
	else if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
	{//
}
    else
	{
		echo "enter correct email<br>";
	}
	if(preg_match("/^[a-zA-Z ]*$/",$_POST['location'])===0)
	{
		echo "enter correct location";
		$x++;
	}
		if(!is_numeric($_POST['age']))
		{
			echo "enter corrct age<br>";
		}
		if($x<1)
		{
    $sql = sprintf(
      "INSERT INTO %s (%s) values (%s)",
      "users",
      implode(", ", array_keys($new_user)),
      ":" . implode(", :", array_keys($new_user)));

    $statement = $connection->prepare($sql);
    $statement->execute($new_user);
  }
 
  else
  {
	  echo "enter deatils are incorrect";
  }
}
  catch(PDOException $error) 
  {
      echo $sql . "<br>" . $error->getMessage();
  }
}
?>
<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote><?php echo escape($_POST['firstname']); ?> successfully added.</blockquote>
  <?php endif; ?>

  <h2>Add a user</h2>
  <form  name="register" method="post"  onsubmit="return validate()";>
  <script>/*
  function validate()
{
	var name=document.forms["register"]["firstname"].value;
	if(name=="")
	{
		alert("enter your firstname");
		document.forms["register"]["firstname"].focus();
		return false;
		
	}
	var lastname=document.forms["register"]["lastname"].value;
	if(lastname=="")
	{
		alert("enter your lastname");
		document.forms["register"]["lastname"].focus();
		return false;
		
	}
	var email=document.forms["register"]["email"].value;
	var atposition=email.indexOf("@");
	var dotposition=email.indexOf(".");
	if(atposition<1||dotposition<atposition+2||dotposition+2>=email.length)
	{
		alert("enter valid email");
		document.forms["register"]["email"].focus();
		return false;
	}
	
	var age=document.forms["register"]["age"].value;
	if(age=="")
	{
		alert("enter age");
		document.forms["register"]["age"].focus();
		return false;
		
	}
	else if(isNaN(age))
	{
		alert("enter digit in  age");
		document.forms["register"]["age"].focus();
		return false;
		
	}
	var location=document.forms["register"]["location"].value;
	if(location=="")
	{
		alert("enter your location");
		document.forms["register"]["location"].focus();
		return false;
		
	}
}
	*/</script>
  
    <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
  </form>

  <a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
