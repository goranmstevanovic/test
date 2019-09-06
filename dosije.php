<html>
    <head>
        <title> Dosije student </title>
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
        <style>
            th,td,select,input {
                border: 1px solid #009900;
                border-radius: 5px;
                padding: 5px 5px 5px 5px ;
            }
        </style>
    </head>
    <body>
        <?php
                    error_reporting(E_ALL);
                    ini_set("display_errors",1);
        include_once 'db.php';
        include_once 'funct.php';
        if (isset($_GET["prenos"]) and $_GET["prenos"]!==null )
        {
            $student_id=$_GET['prenos'];
            echo "Student : ",$student_id;
        }

        $sql_student="select * from students where id='$student_id' " ;
        $q_student=mysqli_query($con,$sql_student);
        if (mysqli_num_rows($q_student)==0){echo "Tabela je prazna";}

        $rez=mysqli_fetch_assoc($q_student);
        $name = $rez['name'];
        $surname = $rez['surname'];
        $jmbg = $rez['JMBG'];
        $address = $rez['address'];
        $school_board = $rez['id_school_board'];

        $sql_ocene="SELECT * FROM `school_grades` where `id_student` = '$student_id'";
        $q_ocene=mysqli_query($con,$sql_ocene);
        if (mysqli_num_rows($q_ocene)==0)
        {
            $ocena1=5;
            $ocena2=5;
            $ocena3=5;
            $ocena4=5;
        }else
            {
                $rez_ocene=mysqli_fetch_assoc($q_ocene);
                $ocena1=$rez_ocene['grade1'];
                $ocena2=$rez_ocene['grade2'];
                $ocena3=$rez_ocene['grade3'];
                $ocena4=$rez_ocene['grade4'];

            }
        ?>
        <form method="POST">

            <table id='pozivH'>
                <tr>

                    <td style='border:0;'><input type='submit'  value='snimi i izadji' name='btnSub' class='btn btn-secundary' ></td>
                </tr>
            </table>

            <table id='pozivH' style="width:70%; margin:auto;" >
                <tr>
                    <td> Ime: </td>
                    <td>
                        <input  type='text'  size='24' name='ime_text' required  value='<?php echo $name; ?>'>
                    </td>
                    <td>Prezime:</td><td ><input  type='text' size='24' name='prezime_text' value='<?php echo $surname; ?>' ></td>
                </tr>
                <tr>
                    <td>Adresa:</td><td colspan="3"><input  type='text'  size='61' name='adresa_text' value='<?php echo $address; ?>' ></td>
                </tr>
                <tr>
                    <td>jmbg:</td><td><input  type='text'  size='24' name='jmbg' required value='<?php echo $jmbg; ?>'></td>
                </tr>
                <?php $imeOdbora = citanjeOdbora($con); ?>
                <tr>
                    <td>School Board :</td>
                    <td>
                        <select id='odbor' name='odbor'>";
                            <?php	foreach ($imeOdbora as $key => $value) {
                                 if ($key == $school_board)
                                     { echo "<option value= " . $key . " selected >" . $value . "</ option>"; } else
                                    {
                                        echo "<option value= " . $key . ">" . $value . "</ option>";
                                    }}
                            ?>
                        </select>
                    </td>
                    <script type="text/javascript">
                        document.getElementById('odbor').value = "<?php echo $_POST['odbor'];?>";
                    </script>
                </tr>


            </table>
            <p>OCENE STUDENTA</p>
            <table id='pozivH' style="width:70%; margin:auto;" >
                <tr><td>Ocena 1</td><td><input type="number" name="ocena1" min="5" max="10" value="<?php echo $ocena1; ?>" ></td></tr>
                <tr><td>Ocena 2</td><td><input type="number" name="ocena2" min="5" max="10" value="<?php echo $ocena2; ?>" ></td></tr>
                <tr><td>Ocena 3</td><td><input type="number" name="ocena3" min="5" max="10" value="<?php echo $ocena3; ?>" ></td></tr>
                <tr><td>Ocena 4</td><td><input type="number" name="ocena4" min="5" max="10" value="<?php echo $ocena4; ?>" ></td></tr>



            </table>


        </form>
        <?php
        if(isset($_POST['btnSub']))
        {
                $ime_text="";
                $prezime_text="";
                $adresa_text="";
                $jmbg="";



                if(isset($_POST['ime_text'])){$ime_text=$_POST['ime_text'];}
                if(isset($_POST['prezime_text'])){$prezime_text=$_POST['prezime_text'];}
                if(isset($_POST['adresa_text'])){$adresa_text=$_POST['adresa_text'];}
                if(isset($_POST['jmbg'])){$jmbg=$_POST['jmbg'];}
                if(isset($_POST['odbor'])){$odbor=$_POST['odbor'];}

            if(isset($_POST['ocena1'])){$ocena1=$_POST['ocena1'];}
            if(isset($_POST['ocena2'])){$ocena2=$_POST['ocena2'];}
            if(isset($_POST['ocena3'])){$ocena3=$_POST['ocena3'];}
            if(isset($_POST['ocena4'])){$ocena4=$_POST['ocena4'];}

          echo $ocena1, $ocena2, $ocena3, $ocena4, $odbor;

           // $uppis = "UPDATE `students` SET `username`='$username_text',`password`='$password_lozinka',`skype_username`='$skype_username_text',`Skype_password`='$skype_password_text', `zaposlen`='$aktivan' WHERE `pk_id`=$zaposleni_id";
            $upis_students="UPDATE `students` SET `name`='$ime_text',`surname`='$prezime_text',`JMBG`='$jmbg',`address`='$adresa_text',`id_school_board`='$odbor' WHERE `id`='$student_id'";
            mysqli_query($con,$upis_students);
            $provera = " SELECT * FROM `school_grades` WHERE `id_student` = '$student_id'";
            $q_provera = mysqli_query($con,$provera);
            if( mysqli_num_rows($q_provera)==0  )
            {
                $upis_ocene="INSERT INTO `school_grades` (`id_student`, `grade1`, `grade2`, `grade3`, `grade4`) VALUES ('$student_id','$ocena1','$ocena2','$ocena3','$ocena4')";
            }else {
                $upis_ocene = "UPDATE `school_grades` SET `grade1`='$ocena1',`grade2`='$ocena2',`grade3`='$ocena3',`grade4`='$ocena4' WHERE  `id_student`='$student_id'";
            }
            if(mysqli_query($con,$upis_ocene)){echo '<script>	alert("Uspesno upisano novostanje u bazu");</script>';} else
                {
                    echo '<script>	alert("NESTO NE VALJA");</script>';
                }
            echo'<script>window.parent.opener.location.reload();</script>';
            echo "<script>window.close();</script>";
        }
        ?>

    </body>
</html>