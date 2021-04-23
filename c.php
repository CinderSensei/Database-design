<!DOCTYPE html> 
<html> 
      
<head> 
    <title> 
        Page c
    </title> 
</head> 
  
<body style="text-align:center;"> 
       
    <h1 style="color:blue;"> 
        Market Report
    </h1> 
      
    <h4> 
    </h4> 


<?php
    
    

    $servername = "localhost";
    $username = "root";
    $password = "mysql";
    $dbname = "kaan_topcu";

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } 

    $sql = "SELECT districts.d_name AS districtname, count(sales.sale_id) AS Quantity FROM SALES
            JOIN salesmen
            ON
            sales.s_id = salesmen.s_id
            JOIN markets
            ON
            salesmen.m_id = markets.m_id
            JOIN cities
            ON
            cities.c_id = markets.c_id
            JOIN districts
            ON
            cities.d_id = districts.d_id
            GROUP BY districts.d_id";
    $result = mysqli_query($conn,$sql) or die("Error");

   if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>districtName</td><td>Quantity</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["districtname"]. "</td><td>" . $row["Quantity"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    $sql = "SELECT markets.m_name AS marketname, count(sales.sale_id) AS Quantity FROM SALES
            JOIN salesmen
            ON
            sales.s_id = salesmen.s_id
            JOIN markets
            ON
            salesmen.m_id = markets.m_id
            GROUP BY markets.m_name";
    $result = mysqli_query($conn,$sql) or die("Error");

   if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>marketName</td><td>Quantity</td></tr>";
        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["marketname"]. "</td><td>" . $row["Quantity"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }






    mysqli_close($conn);
  
?> 

<br><br><br>

<form method="post">
        <input type="button" value="Return main page" class="homebutton" id="btnHome" 
onClick="document.location.href='main.php'" />

</form> 


</head> 
  
</html> 