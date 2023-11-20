<?php

include('config.php');
include('functions.php');

// $fromdate="2022-11-2";
// $todate="2023-11-2";

if(!isset($_GET['fromdate']) || !isset($_GET['todate']))
{
  header('Location:newchallan.php');
}

$fromdate=$_GET['fromdate'];
$todate=$_GET['todate'];
//------------------------ Company Data ---------------------------
$comapanyquery = "SELECT * FROM `firmmaster` where `FirmId`='1'";
//  echo $comapanyquery;
$companyres = mysqli_query($con, $comapanyquery);
$row2 = mysqli_fetch_assoc($companyres);
$firmName=$row2['FirmName'];
$firmAddress=$row2['FirmAddress'];
$firmMOB=$row2['FirmNo'];
$firmEmail=$row2['FirmEmail'];
$firmgst=$row2['FirmGst'];
$firmlogo=$row2['LogoAddress'];


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Curvdent Health Care</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
  

        <!-- <div class="container"> -->
        <div class="row">
                <div class="col-3">
                <img src="<?php echo $firmlogo; ?>" height="200px" width="200px" alt="">
                </div>
                <div class="col-9">
                   <center>
                    <h1><?php echo $firmName; ?></h1>
                    <p><?php echo $firmAddress; ?></p>
                    <p>Mobile: <?php echo $firmMOB; ?> , State: Maharashtra</p>
                   </center>
                </div>
            </div>
<hr>
            <div class="row pt-2 pb-2" style="background-color:rgb(230, 230, 230);">
               <center>
               <h4>Sales Statement Bill Wise</h4>
               </center>
            </div>
            <div class="row ">
               <div class="col d-flex justify-content-end mt-1">
                    <b>From: <?php echo date("d-m-Y", strtotime($fromdate)); ?> - TO: <?php echo date("d-m-Y", strtotime($todate)); ?></b>
               </div>
            </div>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bill No</th>
                        <th>Customer Name</th>
                        <th>Total Amt</th>                 
                        <th>Total Tax</th>
                        <th>Taxable</th>
                        <th>Bill Total</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                        $totalQty=0;
                        $NetTotal=0;
                        $selectsalesdtlsQuery="SELECT * FROM `sales` WHERE `BillDate` BETWEEN '" . $fromdate . "' AND '" . $todate . "'";

                        $ressales=mysqli_query($con,$selectsalesdtlsQuery);

                        if(mysqli_num_rows($ressales)>0)
                        {
                        $num=1;
                                while($row=mysqli_fetch_array($ressales))
                        {
                          $NetTotal=$NetTotal+$row['NetTotal'];
                            ?>
                                <tr>
                                <td><?php echo $num; ?></td>
                                
                                <!-- <td><?php //  ?></td> -->
                                <td><?php echo $row['BillNo']; ?></td>
                                <td><?php  echo getcustomernameById($con,$row['CustId']); ?></td>
                                <td><?php echo $row['TotItemAmt']; ?></td>
                                <td><?php echo $row['TotalTax']; ?></td>
                                <td><?php echo $row['TaxableTotal']; ?></td>
                                <td><?php echo $row['NetTotal']; ?></td>
                                </tr>
                            <?php 
                            $num++;
                        }
                        }else{
                        echo "<tr>
                                <td colspan='3' align='center'>No Component Found</td>
                        </tr>";
                        }


                  ?>
                  <tr>
                    <td colspan='6' class="text-end"><b>SubTotal</b> </td>
                   
                    <td><b><?php echo $NetTotal;?></b></td>
                  </tr>
                </tbody>
              </table>
<!-- 
              <div class="row">
                <div class="col-7">
                    <B>BANK DETAILS</B>
                    <P>Name: SPARKSOUL INFOTECH PRIVATE LIMITED</P>
                    
                    <P> <br>
                        IFSC Code: ICIC0001095<br>
                        Account No: 109505005440<br>
                        Bank: ICICI Bank,SANGAMNER</P>
                </div>
                <div class="col-5 float-right">
                    <h6>TAXABLE AMOUNT ₹ <?php// echo $TotalTaxable; ?></h6>
                    <hr>
                    <h6>TOTAL AMOUNT ₹ <?php// echo $NetTotal; ?></h6>
                    <hr>
                    <p>Received Amount ₹ 0</p>
                  
                </div>
              </div> -->

              <div class="row">
                <div class="col-7">
                    <!-- <p><b>TERMS AND CONDITIONS</b></p>
                    <p>1. Domain & Hosting Charges belong to the client only.<br>
                        2. All disputes are subject to Sangamner jurisdiction only</p> -->
                </div>
                <div class="col-5">
                   <center>
                   <br>
                   <br>
                   <br>
                   <br>
                    <b>AUTHORISED SIGNATORY FOR</b>
                    <p><?php echo $firmName; ?></p>
                   </center>
                </div>
              </div>
        <!-- </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>