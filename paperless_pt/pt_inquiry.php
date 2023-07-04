<!DOCTYPE html>
     <html>
     <head>
      <?php include "includes/head.php";  ?>
     </head>
     <body>
         <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
         <?php include("includes/sidebar.php"); ?>
             <div class="body-wrapper">
                 <?php include("includes/topnav.php"); ?>
                 <?php include("controller/" . getFileName());?>
             </div>
         </div>
         <?php include("includes/scripts.php"); ?>
         <script src="public/app/pt_inquiry.js"></script>
     </body>
     </html>
