<!DOCTYPE html>
     <html>
     <head>
      <?php include "includes/head.php";  ?>
     </head>
     <body>
         <!-- <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed"> -->
                 <?php include("controller/" . getFileName());?>

         <!-- </div> -->
         <?php include("includes/scripts.php"); ?>
         <!-- <script src="public/app/mo_inquiry.js"></script> -->
     </body>
     </html>
