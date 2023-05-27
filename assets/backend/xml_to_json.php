<?php
include 'db_connection.php';

$fileContents= file_get_contents('test.xml');
$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
$fileContents = trim(str_replace('"', "'", $fileContents));
$simpleXml = simplexml_load_string($fileContents);
$json = json_encode($simpleXml,JSON_PRETTY_PRINT);
       

$obj = json_decode($json, TRUE);
foreach($obj as $key => $value)
{
    if($key == 'VehAvailCore')
    {
		$val = json_encode($value);
   		$vehil_core = $val;
    }else
    if($key == 'VehAvailInfo')
    {
    	$val = json_encode($value);
   		$vehil_info = $val;
    }

    $insert = "INSERT INTO `xml_to_json`(`vehavail_core`,`vehavail_info`,`created_at`, `updated_at`) VALUES ('$vehil_core','$vehil_info',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
	$i_query = mysqli_query($conn,$insert);
   
 }

?>

<style>
    pre { white-space: pre-wrap;
   
        font-family: Consolas, "Andale Mono WT", "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", "DejaVu Sans Mono", "Bitstream Vera Sans Mono", "Liberation Mono", "Nimbus Mono L", Monaco, "Courier New", Courier, monospace;
        overflow-x: auto;
    }
    .heading{
        font-size: 30px;
        color: blue;
    }
</style>
<div class="codingSection">
<h1 class="heading">Xml To Json Conversion</h1>
<pre><?php echo $json; ?></pre>
</div>