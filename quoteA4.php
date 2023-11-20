<?php
session_start();
include('config.php');
include('functions.php');
if($_SESSION['BillNO']=='')
{
    echo "<script>";
//echo "alert('Logout Successfull');";
echo 'window.location.href="sales.php";';
echo "</script>";
}

$BillNO=$_SESSION['BillNO'];
// $CustomerID="2";

//-------------------------------------------------------------
//---------------------Bill Data ------------------------------
$selectquery = "SELECT * FROM `sales` where `BillNo`='$BillNO'";
//  echo $selectquery;
$result = mysqli_query($con, $selectquery);
$row = mysqli_fetch_assoc($result);
$BillId=$row['BillId'];
$invno=$row['BillNo'];
$CustomerID=$row['CustId'];
$invdate=$row['BillDate'];
$invpaymenttype=$row['PaymentType'];
$SubPaymentType=$row['SubPaymentType'];
$BillDiscount=$row['ExtraBillDiscount'];
//----------------------------------------------------------------
//----------------------Customer Data ----------------------------
$SelectCustomerData = "SELECT * FROM `customermaster` where `CustId`='$CustomerID'";
//  echo $SelectCustomerData;
$Customerres = mysqli_query($con, $SelectCustomerData);
$row1 = mysqli_fetch_assoc($Customerres);
$CustName=$row1['CustName'];
$Address=$row1['Address'];
//-----------------------------------------------------------------
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
$billheadercolor=$row2['billheadercolor'];
$billtextcolor=$row2['billtextcolor'];



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A4 Bill Design</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>
  

        <!-- <div class="container"> -->
            <div class="row">
                <div class="col-3">
                <img src="<?php echo $firmlogo; ?> " height="200px" width="200px" style="margin-top: -42px; margin-bottom: -36px;" alt="">
                </div>
                <div class="col-9">
                   <center>
                    <h1><?php echo $firmName; ?> </h1>
                    <p><?php echo $firmAddress; ?> <br> Mobile: <?php echo $firmMOB; ?> , State: Maharashtra</p>
                    <!-- <p></p> -->
                   </center>
                </div>
            </div>
<hr>
            <div class="row pl-1 pt-2 pb-2" style="background-color: <?php echo $billheadercolor;?>;">
                <div class="col" style="color:<?php echo $billtextcolor;?>; padding-left: 30px;"><h6 style="color:<?php echo $billtextcolor;?>;">Quot No.: <?php echo $invno;?></h6></div>
                <div class="col" style="color:<?php echo $billtextcolor;?>;"><center><h5>Quotation</h5></center></div>
                <div class="col" style="color:<?php echo $billtextcolor;?>;"><h6>Quot Date: <?php echo date("d-m-Y", strtotime($invdate));?></h6></div>
                
            </div>
            <div class="row">
                <p><b>To</b></p>
                <div class="col-7 mt--1">
                    <h5><?php echo $CustName; ?></h5>
                    <p><?php echo $Address; ?></p>
                </div>
                <div class="col-5"></div>
            </div>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Item Name</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <!-- <th>Taxable Amt</th>
                        <th>Tax(%)</th>
                        <th>Tax Amt</th> -->
                        <th>Net Total</th>
                    </tr>
                </thead>
                <tbody>
                  <?php
                  
                        $TotalTaxable=0;
                        $TotalTaxAmt=0;
                        $NetTotal=0;


                        $selectsalesdtlsQuery="SELECT * FROM `salesdetails` WHERE `BillId`='$BillId'";

                        $ressales=mysqli_query($con,$selectsalesdtlsQuery);

                        if(mysqli_num_rows($ressales)>0)
                        {
                        $num=1;
                                while($row=mysqli_fetch_array($ressales))
                        {
                            $TotalTaxable= $TotalTaxable+$row['TaxableAmt'];
                            $TotalTaxAmt= $TotalTaxAmt+$row['TaxAmt1'];
                            $NetTotal= $NetTotal+$row['NetAmt'];
                            
                            ?>
                                <tr>
                                <td><?php echo $num; ?></td>
                                
                                <td><b><?php echo getitemnamebyID($con,$row['ItemId'])."</b><br><small>".$row['ItemDescription']."</small>"; ?></td>
                                <td><b><?php echo $row['Qty']; ?></b></td>
                                <td><b><?php echo $row['Rate']; ?></b></td>
                                <!-- <td><?php //echo $row['TaxableAmt']; ?></td> -->
                                <!-- <td><?php //echo getitemTaxpercentbyID($con,$row['ItemId']); ?></td> -->
                                <!-- <td><?php //echo $row['TaxAmt1']*2; ?></td> -->
                                <td><b><?php echo $row['NetAmt']; ?></b></td>
                                </tr>
                            <?php 
                            $num++;
                        }
                        }else{
                        echo "<tr>
                                <td colspan='3' align='center'>No Component Found</td>
                        </tr>";
                        }
                        $TotalTaxAmt= $TotalTaxAmt*2;


                  ?>
                    <tr>
                        <td colspan="4" class="text-end"><b>SubTotal</b></td>
                        
                        <!-- <td><b><?php //echo $TotalTaxable; ?></b></td> -->
                        <!-- <td></td> -->
                        <!-- <td><b><?php //echo $TotalTaxAmt; ?></b></td> -->
                        <td><b><?php echo $NetTotal; ?></b></td>
                    </tr>
                </tbody>
              </table>

              <div class="row">
                <div class="col-7">
                    <!-- <B>BANK DETAILS</B>
                    <P>Name: Soulsoft Infotech Private Limited</P>
                    
                    <P>
                        IFSC Code: IDFB0042964<br>
                        Account No: 10087360151<br>
                        Bank: IDFC FIRST Bank,SANGAMNER</P> -->
                </div>
                <div class="col-5 ml-auto">
                <!-- <div class="col-5 float-right"> -->
                    <!-- <h6>TAXABLE AMOUNT ₹ <?php// echo $TotalTaxable; ?></h6> -->
                    <hr>
                    <h6>Total Quotation Amount ₹ <?php echo $NetTotal-$BillDiscount; ?></h6>
                    <hr>
                    <!-- <p>Received Amount ₹ 0</p> -->
                  
                </div>
              </div>
<br><br>
              <div class="row">
                <div class="col-7">
                    <p><b>TERMS AND CONDITIONS</b></p>
                    <p>
                        1. Domain & Hosting / Server Charges belong to the client only.<br>
                       2. AMC charges are applicable after one year of completion. <br>
                       3. Extra 18% GST Applicable. <br>
                       <!-- 2. AMC charges are applicable after one year of completion. <br> -->
                    </p>
                    
                </div>
                <div class="col-5">
                    <br>
                    <br>
                    <br>
                    <br>
                    <b>AUTHORISED SIGNATORY FOR</b>
                    <p><?php echo $firmName; ?></p>
                </div>
              </div>
        <!-- </div> -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>