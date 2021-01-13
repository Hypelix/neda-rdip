<!-- <div class="navbar">
  <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_home_admin/display_contents_home_admin">Home</a> -->
  <?php 
  // if($_SESSION['user_type']==1){
  //   echo '<a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_investment_summary">Summary of Investments</a>';
  // }
  ?>
  <!--   <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_project">Agency Projects</a> -->
  <?php 
  // if($_SESSION['user_type']==1){ 
  //   echo '
  //   <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_users_list/display_contents_users_list">Users</a>
  //   <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_agencies/display_contents_agencies">Agencies</a>
  //   <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_fund_source/display_contents_fund_source">Fund Source</a>
  //   <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_rdip_masterlist">RDIP Masterlist</a>';
  // }
  ?>
  
<!--   <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_home_user/display_contents_home_user">User Mode</a>
  <a href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_home_admin/logout_and_remove_credentials">Logout</a>
</div> -->

<!-- Navbar -->
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_home_admin/display_contents_home_admin">RDIP</a>
  <ul class="navbar-nav ml-auto">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
  </ul>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <?php 
      if($_SESSION['user_type']==1){ 
        echo '<li class="nav-item">
        <a class="nav-link" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_investment_summary" style="color:white;">Summary of Investments</a>
        </li>'; 
      } 
      ?>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_project" style="color:white;">Agency Projects</a>
      </li>
      <?php 
      if($_SESSION['user_type']==1){
        echo '<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="" style="color:white;" id="navbardrop" data-toggle="dropdown">
        Manage
        </a>
        <div class="dropdown-menu">
        <a class="dropdown-item" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_agencies/display_contents_agencies">Agencies</a>
        <a class="dropdown-item" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_fund_source/display_contents_fund_source">Fund Source</a>
        <a class="dropdown-item" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_rdip_masterlist">RDIP Masterlist</a>
        <a class="dropdown-item" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_users_list/display_contents_users_list">Users</a>
        </div>
        </li>';
      } 
      ?>
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_home_user/display_contents_home_user" style="color:white;">User Mode</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link" href="http://localhost/debug/OOP/CodeIgniter-3.1.10/index.php/controller_RDIP/controller_home_admin/logout_and_remove_credentials" style="color:white;">Logout</a>
      </li>
    </ul>
  </div>
</nav>
<!-- Navbar -->