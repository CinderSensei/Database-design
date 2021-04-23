<!DOCTYPE html> 
<html> 
      
<head> 
    <title> 
        Page b
    </title> 
</head> 
  
<body style="text-align:center;"> 
      
    <h1 style="color:blue;"> 
        Page b
    </h1> 
      
    <h4> 
    </h4> 

<?php
    function button1(){
    

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "kaan_topcu";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT count(products.p_id) AS Quantity, products.p_name AS productName FROM PRODUCTS
            JOIN SALES 
            ON 
            sales.p_id = products.p_id
            GROUP BY products.p_id";
    $result = mysqli_query($conn,$sql) or die("Error");

   if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>productName</td><td>Quantity</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["productName"]. "</td><td>" . $row["Quantity"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    

    mysqli_close($conn);

    
    }

    function button2(){
    

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "kaan_topcu";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT count(sales.sale_id) AS Quantity, salesmen.s_name AS salesmanName FROM SALESMEN
            JOIN SALES 
            ON 
            sales.s_id = salesmen.s_id
            GROUP BY salesmen.s_id";
    $result = mysqli_query($conn,$sql) or die("Error");

   if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>salesmanName</td><td>Quantity</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["salesmanName"]. "</td><td>" . $row["Quantity"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    

    mysqli_close($conn);

    
    }



    function button3(){

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "kaan_topcu";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT salesmen.s_name FROM SALESMEN";
    $result = mysqli_query($conn,$sql) or die("Error");

    if (mysqli_num_rows($result) > 0) {
        echo "<form action='b3.php' method='post'>";
        echo '<select name="salesmanName">';
        while($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row["s_name"] . "'>";
            echo $row["s_name"];
            echo "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="show">';
        echo "</form>";
    } else {
        echo "0 results";
    }





    mysqli_close($conn);

}



    function button4(){

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "kaan_topcu";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT customers.cus_name FROM CUSTOMERS";
    $result = mysqli_query($conn,$sql) or die("Error");

    if (mysqli_num_rows($result) > 0) {
        echo "<form action='b4.php' method='post'>";
        echo '<select name="customerName">';
        while($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row["cus_name"] . "'>";
            echo $row["cus_name"];
            echo "</option>";
        }
        echo '</select>';
        echo '<input type="submit" value="show">';
        echo "</form>";
    } else {
        echo "0 results";
    }

    



    mysqli_close($conn);

}


    if(array_key_exists('button1', $_POST)) { 
            button1(); 
        }
    if(array_key_exists('button2', $_POST)) { 
            button2(); 
        }
    if(array_key_exists('button3', $_POST)) { 
            button3(); 
        }
    if(array_key_exists('button4', $_POST)) { 
            button4(); 
        }     
?>




<form method="post"> 
        <input type="submit" name="button1"
                class="button" value="Product" />
        <input type="submit" name="button2"
                class="button" value="Salesman" /> 
        <input type="submit" name="button3"
                class="button" value="Choose a saleman" />
        <input type="submit" name="button4"
                class="button" value="Invoice" />        
          
    </form> 

<br><br><br>

<form method="post">
        <input type="button" value="Return main page" class="homebutton" id="btnHome" 
onClick="document.location.href='main.php'" />

</form> 


</head> 
  
</html> 