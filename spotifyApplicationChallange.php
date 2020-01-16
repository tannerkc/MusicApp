<?php 
$para = "
If you want to jumpstart the process of talking to us about this role, here’s a little challenge: write a program that outputs the largest unique set of characters that can be removed from this paragraph without letting its length drop below 50.
";
$characterCount = strlen($para);

$valArray = array();
foreach (count_chars($para, 1) as $i => $val) {
    if($val < 8 && chr($i) != " "){
        $valArray[] = chr($i);
    }
 }

$newPara = str_replace($valArray, "", $para);

 echo "<br>" . strlen($newPara);
 echo "<br>" . $newPara;
?>

<script>
function findUnique(str){
    var para = str;
    var unique = "";

 for (var x=0;x < para.length;x++)
 {

 if(unique.indexOf(str.charAt(x))==-1 && unique.indexOf(str.charAt(x)) != " ")
  {

    var re = new RegExp(str[x], "gi");
    var numMatches = str.match(re).length;
    if(numMatches < 8){
     unique += str[x] +"|";  
    }
  
   }
  } 
  unique = unique.replace(" ", "");
  unique = unique.replace("||", "|");
  var re = new RegExp(unique, 'gi');
  return para.replace(re, "");
}  

console.log(findUnique('If you want to jumpstart the process of talking to us about this role, here’s a little challenge: write a program that outputs the largest unique set of characters that can be removed from this paragraph without letting its length drop below 50.'));
</script>