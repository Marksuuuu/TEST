<?php

$db = new Postgresql();

$link = $_POST["link"];
$name = $_POST["name"];
$icon = $_POST["icon"];
$users = "(".$_POST["emp"].") ".$_POST["fname"];
$date = date("Y-m-d h:i:s a");

$status = "";
$mainfileContent = '';
$controllerfileContent = '';
$viewfileContent = '';
$jsfileContent = '';


$sql = "INSERT INTO public.page_list(page_name, page_link, page_icon, added_on, added_by)
	    VALUES('$name','$link','$icon','$date','$users')";
$query = $db -> query($sql);


$jsfile = fopen("../../public/app/".$link.".js", "w");
$viewfile = fopen("../../view/".$link.".php", "w");
$controllerfile = fopen("../../controller/".$link.".php", "w");
$mainfile = fopen("../../".$link.".php", "w");
if($query){
    $mainfileContent .= '<!DOCTYPE html>'. PHP_EOL
                     .'     <html>'. PHP_EOL
                     .'     <head>'. PHP_EOL
                     .'      <?php include "includes/head.php";  ?>'. PHP_EOL
                     .'     </head>'. PHP_EOL
                     .'     <body>'. PHP_EOL
                     .'         <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">'. PHP_EOL
                     .'         <?php include("includes/sidebar.php"); ?>'. PHP_EOL
                     .'             <div class="body-wrapper">'. PHP_EOL
                     .'                 <?php include("includes/topnav.php"); ?>'. PHP_EOL
                     .'                 <?php include("controller/" . getFileName());?>'. PHP_EOL
                     .'             </div>'. PHP_EOL
                     .'         </div>'. PHP_EOL
                     .'         <?php include("includes/scripts.php"); ?>'. PHP_EOL
                     .'         <script src="public/app/'.$link.'.js"></script>'. PHP_EOL
                     .'     </body>'. PHP_EOL
                     .'     </html>'. PHP_EOL;
         
    $controllerfileContent .= '<?php'. PHP_EOL
                           .' include("view/" . getFileName()); ?>'. PHP_EOL;
    $viewfileContent .= '<div class="container-fluid">'. PHP_EOL
                   .'       <div class="card">'. PHP_EOL
                   .'           <div class="card-body">'. PHP_EOL
                   .'                      <h5 class="card-title fw-semibold mb-4">Sample Page</h5>'. PHP_EOL
                   .'           </div>'. PHP_EOL
                   .'       </div>'. PHP_EOL
                   .'   </div>';


    $jsfileContent .= '$(document).ready(function () {'. PHP_EOL
                .' });'. PHP_EOL;


                
    fwrite($viewfile, $viewfileContent);
    fwrite($controllerfile, $controllerfileContent);
    fwrite($mainfile, $mainfileContent);
    fwrite($jsfile, $jsfileContent);
    fclose($viewfile);
    fclose($controllerfile);
    fclose($mainfile);
    fclose($jsfile);


        
    $status = "success";

} 
else {
   $status = "error";
}


$data = array(
    "status" => $status
);

echo json_encode($data);

?>