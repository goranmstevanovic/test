<html>
<head>
    <style>
        #pozivH th,td {
            border: 1px solid #009900;

        }
        th,td,select,input {
            border: 1px solid #A4A4A4;
            border-radius: 5px;
            padding: 7px 15px ;
        }

    </style>

    <title> Novi student </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="tigrakal/tcal.css" />
    <script type="text/javascript" src="tigrakal/tcal.js"></script>

</head>

<body bgcolor=white>
<?php

error_reporting(E_ALL);
ini_set("display_errors",1);
date_default_timezone_set("Europe/Belgrade");
include_once 'db.php';
include_once 'funct.php';
if (mysqli_connect_errno()) {
    printf("Spajanje na mysql server je bilo neuspešno: %s\n", mysqli_connect_error());
    exit();}

?>
<form  method='post'>

    <table id='pozivH'>
        <tr>

            <td style='border:0;'><input type='submit'  value='snimi i izadji' name='btnSub' class="btn btn-primary" ></td>
        </tr>
    </table>
    <br/>
    <table id='pozivH' style="width:70%; margin:auto;" >
        <tr>
            <td>Ime:</td><td><input  type='text'  size='24' name='ime_text' required></td>
            <td>Prezime:</td><td ><input  type='text' size='24' name='prezime_text' ></td>
        </tr>
        <tr>
            <td>Adresa:</td><td colspan="3"><input  type='text'  size='61' name='adresa_text' ></td>
        </tr>
        <tr>
            <td>jmbg:</td><td><input  type='text'  size='24' name='jmbg' required ></td>
       </tr>
        <?php $imeOdbora = citanjeOdbora($con); ?>
        <tr>
            <td>School Board :</td>
            <td>
                <select id='odbor' name='odbor'>";
                    <?php	foreach ($imeOdbora as $key => $value) {
                        echo "<option value= " . $key . ">" . $value . "</option>";}
                    ?>
                </select>
            </td>
            <script type="text/javascript">
                document.getElementById('odbor').value = "<?php echo $_POST['odbor'];?>";
            </script>
        </tr>
    </table>
</form>
<?php
if(isset($_POST['btnSub'])){

    $ime_text="";
    $prezime_text="";
    $adresa_text="";
    $jmbg="";

    if(isset($_POST['ime_text'])){$ime_text=$_POST['ime_text'];}
    if(isset($_POST['prezime_text'])){$prezime_text=$_POST['prezime_text'];}

    if(isset($_POST['adresa_text'])){$adresa_text=$_POST['adresa_text'];}

    if(isset($_POST['jmbg'])){$jmbg=$_POST['jmbg'];}


    $provera="SELECT * FROM `students` WHERE `jmbg`='$jmbg'  ";
    $q_provera=mysqli_query($con,$provera);

    if( mysqli_num_rows($q_provera)==0  ){
        $upis="INSERT INTO `students`( `name`, `surname`, `JMBG`, `address`) VALUES
		('$ime_text','$prezime_text','$jmbg','$adresa_text')";

        if (!$q=mysqli_query($con,$upis)){echo '<script>	alert("Nije uspeo upis, pa pokusajte ponovo");</script>';}
        else{echo '<script>	alert("Uspesno upisano novostanje u bazu");</script>';}
        echo'<script>
			window.parent.opener.location.reload();
			</script>';
      //  echo "<script>window.close();</script>";
    }else{ echo '<script>	alert("User ili Password vec postje u bazi pa se ne mogu ponavljati");</script>'; }

}




?>



</body>
</html>