<?php
function citanjeOdbora($conection){
$sql="select * from  school_boards";
if (!$q=mysqli_query($conection,$sql)){echo "Nastala je greska pri izvodjenju upita u tabeli  school_boards";	exit;}
if (mysqli_num_rows($q)==0){echo "Tabela je prazna";}
else{$a=0;
while ($vrsta=mysqli_fetch_assoc($q))
{$a=$a+1;
$imeOdbora[$a]=$vrsta["name"];
}
}
return $imeOdbora;
}
?>