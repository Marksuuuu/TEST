<?php
$db = new Postgresql();
$base_server = basename($_SERVER['SCRIPT_NAME']);

$linkStore = array();
$sql = "SELECT 
a.id,page_name,page_link,page_icon,employee_id
FROM 
page_list a 
JOIN
access_employee_page b
on
a.id = b.page_id
WHERE 
employee_id = '" . $_SESSION['hris']['employee_id_no'] . "'
AND 
status = 'active'";
$query = $db->fetchAll($sql);


// var_dump($query);
if (!$query) {
    echo '<script>localStorage.clear();</script>';
    echo
    '<script>
		window.location.href="ajax/logout.php"</script>';
}


foreach ($query as $key => $link) {

    $stringLink = $link["page_link"] . '.php';

    $linkStore[$key] = $stringLink;
}

if ($_SESSION['hris']['employee_department'] == 'Management Information System') {
    array_push($linkStore,'user_controller.php');
}

if (!in_array($base_server, $linkStore)) {
    echo
    '<script>
    window.history.back()
  </script>';
}


?>



<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="./index.html" class="text-nowrap logo-img">
                <img src="public/theme/images/logo.png" width="220" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <?php 
                // var_dump($query);
                
                foreach ($query as $key => $value) { ?>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="<?php echo $value["page_link"] . '.php' ?>" aria-expanded="false" <?php echo ($base_server == $value["page_link"] ? 'active'  : ''); ?>>
                            <span>
                                <i class="<?php echo $value["page_icon"] ?>"></i>
                            </span>
                            <span class="hide-menu"><?php echo $value["page_name"] ?></span>
                        </a>
                    </li>

                <?php }  ?>


                <div <?php if (!in_array('user_controller.php', $linkStore)) {echo 'hidden';} ?>>
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Administrator</span>
                    </li>
                    <li class="sidebar-item">
                        <a class="sidebar-link" href="user_controller.php" aria-expanded="false" <?php echo ($base_server == 'index.php' ? 'active'  : ''); ?>>
                            <span>
                                <i class="ti ti-settings"></i>
                            </span>
                            <span class="hide-menu">Users Controller</span>
                        </a>
                    </li>
                </div>

            </ul>

        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>