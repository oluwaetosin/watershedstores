<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="dns-prefetch" href="ajax.googleapis.com">
<link rel="dns-prefetch" href="//malsup.github.com">
<title><?php echo $title; ?></title>
<link href="<?php echo $css; ?>" rel="stylesheet" >
<link href='css/gen.css' rel='stylesheet'>
</head>
<body>
<header>
  <div class="wrapper">
    <div class="head-link">&nbsp;<a href='#'>Account</a>&nbsp;|&nbsp;<a href='cart.php'><img src="images/1400076274_Item_3D.png" alt="my cart"></a>&nbsp;&nbsp;|&nbsp; <a href="Login">Login</a></div>
    <div>
      <div class='logo'></div>
      <div>
      <div id='form1'><form><input type="text" name="search" id='search'><button id='search'>Search</button></form></div>
      <div class='icons'><a href="#"><img src="images/socialicons_r1_c1.png"></a></div>
      <div class='icons'><a href="#"><img src="images/socialicons_r1_c3.png"></a></div>
      </div>
    </div>
  </div>
</header>
<section class="main-content wrapper">
<div>
  <ul class="categories">
    <span class="highlight">Categories</span>
    <li><a href="index.php">Home</a></li>
    <?php echo $categoryOptions ?>
    
  </ul>