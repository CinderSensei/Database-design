<!DOCTYPE html> 
<html> 
      
<head> 
    <title> 
        installphp
    </title> 
</head> 
  
<body style="text-align:center;"> 
      
    <h1 style="color:blue;"> 
        Database Creation
    </h1> 
      
    <h4> 
        Press button to install database<br><br>
    </h4> 

<?php

function button1(){

$servername = "localhost";
$username = "root";
$password = "mysql";



$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$sql = "DROP DATABASE IF EXISTS kaan_topcu";
if ($conn->query($sql) !== TRUE) {
  		echo "Error";
	}



$sql = "CREATE DATABASE kaan_topcu";
	
	if ($conn->query($sql) !== TRUE) {
  		echo "Error";
	}

$dbname = "kaan_topcu";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = "CREATE TABLE IF NOT EXISTS CUSTOMERS
(
	cus_id int not null auto_increment,
	cus_name varchar(40),
	primary key(cus_id)
) ";
mysqli_query($conn,$sql) or die("Error");

$filename = "csv/isimsoyisim.csv";
	
if(!file_exists($filename) || !is_readable($filename))
	return FALSE;

$fullname = [];
$customercount = 0;
$header = NULL;
	if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				array_push($fullname, $row[0]);
				array_push($fullname, $row[1]);
			}
		}
		fclose($handle);
	}
	$i = 0;
	while($i<1620){
		$nameindex = rand(0,998);
		$nameindex = $nameindex + ($nameindex % 2);
		$surnameindex = rand(0,998);
		if($surnameindex%2 === 0){
			$surnameindex++;
		}
		$insert_name = $fullname[$nameindex] . " " . $fullname[$surnameindex];
		$sql = "insert into CUSTOMERS(cus_name) values ('$insert_name')";
		$customercount++; 
		$conn->query($sql);
		$i++;
	}





$sql = "CREATE TABLE IF NOT EXISTS PRODUCTS
(
	p_id int not null auto_increment,
	p_name varchar(100),
	price double,
	primary key(p_id)
) ";
mysqli_query($conn,$sql) or die("Error");

$filename = "csv/products.csv";
	
if(!file_exists($filename) || !is_readable($filename))
	return FALSE;


$header = NULL;
$name = [];
$price = [];
$productcount = 0;
if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				array_push($name,$row[0]);
				array_push($price,$row[1]);
				$productcount++;
			}
		}
		fclose($handle);
	}

$i = 0;

	while($i<$productcount){
		$sql = "insert into PRODUCTS(p_name, price) values ('$name[$i]', $price[$i])";
		$conn->query($sql);
		$i++;
	}


$sql = "CREATE TABLE IF NOT EXISTS DISTRICTS
(
	d_id int not null auto_increment,
	d_name varchar(20),
	primary key(d_id)
) ";
mysqli_query($conn,$sql) or die("Error");


$sql = "CREATE TABLE IF NOT EXISTS CITIES
(
	c_id int not null auto_increment,
	c_name varchar(40),
	d_id int,
	primary key(c_id),
	foreign key(d_id) references DISTRICTS(d_id)
) ";
mysqli_query($conn,$sql) or die("Error");


$filename = "csv/districtcities.csv";
	
if(!file_exists($filename) || !is_readable($filename))
	return FALSE;

$header = NULL;

$locations = [];
$currentdistrict_id = 1;
$citycount = 1;
if (($handle = fopen($filename, 'r')) !== FALSE)
	{	

		$row = fgetcsv($handle, 1000, ';');
		if(!$header)
				$header = $row;
		$row = fgetcsv($handle, 1000, ';');
		$prevdistrict_name = $row[0];
		$sql = "insert into DISTRICTS(d_name) values ('$prevdistrict_name')";
		$conn->query($sql);
		$sql = "insert into CITIES(c_name, d_id) values ('$row[1]', '$currentdistrict_id')";
		$conn->query($sql);
		$citycount++;
		
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			
				if($prevdistrict_name !== $row[0]){
					$prevdistrict_name = $row[0];
					$currentdistrict_id++;
					$sql = "insert into DISTRICTS(d_name) values ('$prevdistrict_name')";
					$conn->query($sql);
				}
				$sql = "insert into CITIES(c_name, d_id) values ('$row[1]', '$currentdistrict_id')";
				$citycount++;
				$conn->query($sql);
			
		}
		fclose($handle);
	}




$sql = "CREATE TABLE IF NOT EXISTS MARKETS
(
	m_id int not null auto_increment,
	m_name varchar(40),
	c_id int,
	primary key(m_id),
	foreign key(c_id) references CITIES(c_id)
) ";
mysqli_query($conn,$sql) or die("Error");

$filename = "csv/markets.csv";
	
if(!file_exists($filename) || !is_readable($filename))
	return FALSE;

$header = NULL;
$markets = [];
$totalmarketcount = 0;

if (($handle = fopen($filename, 'r')) !== FALSE)
	{
		while (($row = fgetcsv($handle, 1000, ';')) !== FALSE)
		{
			if(!$header)
				$header = $row;
			else{
				array_push($markets,$row[0]);	
			}
		}
		fclose($handle);
	}
	$i=1;
	$j=0;
	while($i < $citycount){
		$temp = [];
		$current_len = count($temp);
		while($current_len < 5){
			array_push($temp, $markets[rand(0,9)]);	
			$temp = array_unique($temp);
			$current_len = count($temp);
		}
		while($j < 5){
			$sql = "insert into MARKETS(m_name, c_id) values ('$temp[$j]', '$i')";
			$totalmarketcount++;
			$conn->query($sql);
			$j++;
		}
		$j = 0;
		$i++;
	}


$sql = "CREATE TABLE IF NOT EXISTS SALESMEN
(
	s_id int not null auto_increment,
	s_name varchar(40),
	m_id int,
	primary key(s_id),
	foreign key(m_id) references MARKETS(m_id)
) ";
mysqli_query($conn,$sql) or die("Error");

$i = 1;
$j = 0;

$salesmancount = 0;
while($i < $totalmarketcount+1)
{
	while($j<3){
		$nameindex = rand(0,998);
		$nameindex = $nameindex + ($nameindex % 2);
		$surnameindex = rand(0,998);
		if($surnameindex%2 === 0){
			$surnameindex++;
		}
		$insert_name = $fullname[$nameindex] . " " . $fullname[$surnameindex];
		$sql = "insert into SALESMEN(s_name, m_id) values ('$insert_name','$i')";
		$salesmancount++;
		$conn->query($sql);
		$j++;
	}
	$j=0;
	$i++;
}




$sql = "CREATE TABLE IF NOT EXISTS SALES
(
	sale_id int not null auto_increment,
	sale_date date,
	cus_id int,
	s_id int,
	p_id int,
	primary key(sale_id),
	foreign key(cus_id) references CUSTOMERS(cus_id),
	foreign key(p_id) references PRODUCTS(p_id),
	foreign key(s_id) references SALESMEN(s_id)
) ";
mysqli_query($conn,$sql) or die("Error");


$i=1;
$j=0;
$customercount++;
$date = date('Y-m-d');
while($i < $customercount) {
		$rand_val = rand(1,5);
		while($j<$rand_val) {
			$productid = rand(1,$productcount);
			$salesmanid = rand(1,$salesmancount);
			$customerid = $i;
			$sql = "insert into sales(sale_date, cus_id, s_id, p_id) values ('$date',$customerid,'$salesmanid',$productid)";
			$conn->query($sql);
			$j++;
		}
		$j=0;
		$i++;
	}




mysqli_close($conn);
}



if(array_key_exists('button1', $_POST)) { 
            button1(); 
        }

?>

<form method="post"> 
        <input type="submit" name="button1"
                class="button" value="create_db" />        
    </form>


<br><br><br>

<form method="post">
        <input type="button" value="Return main page" class="homebutton" id="btnHome" 
onClick="document.location.href='main.php'" />
</form> 



</head> 
  
</html> 