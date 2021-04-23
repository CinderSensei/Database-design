<!DOCTYPE html> 
<html> 
      
<head> 
    <title> 
        Invoice
    </title> 
</head> 
  
<body style="text-align:center;"> 
      
    <h1 style="color:blue;"> 
        Report Of Invoice
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

    $sql = "SELECT  customers.cus_name, products.p_name, CONCAT(products.price,' TL') AS productPrice , sales.sale_date FROM customers
            JOIN sales 
            ON 
            sales.cus_id = customers.cus_id
            JOIN salesmen
            ON
            sales.s_id = salesmen.s_id
            JOIN products
            ON 
            sales.p_id = products.p_id
            JOIN markets
            ON
            salesmen.m_id = markets.m_id
            JOIN cities
            ON
            cities.c_id = markets.c_id
            JOIN districts
            ON
            districts.d_id = cities.d_id ";
    $sql .= "where customers.cus_name = '" . $_POST['customerName'] . "'";   
    $result = mysqli_query($conn,$sql) or die("11");

     if (mysqli_num_rows($result) > 0) {
        echo "<table border='1'>";
        echo "<tr><td>customerName</td><td>productName</td><td>productPrice</td><td>saleDate</td></tr>";

        while($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["cus_name"]. "</td><td>" . $row["p_name"] . "</td><td>" . $row["productPrice"] . "</td><td>" . $row["sale_date"] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }


    $sql ="SELECT  CONCAT(SUM(products.price),' TL') AS totalprice FROM customers
            JOIN sales 
            ON 
            sales.cus_id = customers.cus_id
            JOIN salesmen
            ON
            sales.s_id = salesmen.s_id
            JOIN products
            ON 
            sales.p_id = products.p_id
            JOIN markets
            ON
            salesmen.m_id = markets.m_id
            JOIN cities
            ON
            cities.c_id = markets.c_id
            JOIN districts
            ON
            districts.d_id = cities.d_id ";
    $sql .= "where customers.cus_name = '" . $_POST['customerName'] . "'" . "GROUP BY customers.cus_name";   
    $result = mysqli_query($conn,$sql) or die("11");
                  
    $row = mysqli_fetch_array($result);
    echo "total cost: ";
    echo $row["totalprice"];
    


    mysqli_close($conn);

?>


<br><br><br>

<form method="post">
        <input type="button" value="Return main page" class="homebutton" id="btnHome" 
onClick="document.location.href='main.php'" />
        <input type="button" value="Go back" class="homebutton" id="btnHome" 
onClick="document.location.href='b.php'" />

</form> 

</head> 
  
</html> 