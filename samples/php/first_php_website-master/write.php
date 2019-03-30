<?php
include_once "./db.php";
?>

<!DOCTYPE HTML>
<html>
<head>
  <title>EIT_industries</title>
  <meta charset="utf-8">
  <meta name="description" content="website description" />
  <meta name="keywords" content="website keywords, website keywords" />
  <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
  <link rel="stylesheet" type="text/css" href="style/style.css" />
</head>

<body>
  <div id="main">
    <div id="header">
      <div id="logo">
        <div id="logo_text">
          <!-- class="logo_colour", allows you to change the colour of the text -->
          <h1><a href="main.php">EIT<span class="logo_colour">industries</span></a></h1>
          <h2>Enriching lives through innovation</h2>
        </div>
      </div>
      <div id="menubar">
        <ul id="menu">
          <!-- put class="selected" in the li tag for the selected page - to highlight which page you're on -->
          <li><a href="main.php">Home</a></li>
          <li><a href="about.html">About</a></li>
          <li><a href="products.html">Products</a></li>
          <li><a href="investors.html">Investors</a></li>
          <li class="selected"><a href="news.php">News</a></li>
        </ul>
      </div>
    </div>
    <div id="content_header"></div>
    <div id="site_content">
      <div id="sidebar_container">
          <div class="sidebar">
            <div class="sidebar_top"></div>
            <div class="sidebar_item">
              <!-- insert your sidebar items here -->
              <h3>Latest News</h3>
              <h4>Fourth Quarter 2018 Common Dividend</h4>
              <h5>December 21st, 2018</h5>
              <p> EIT Corporation today announced that its board of directors has declared a $0.1625 per share cash dividend on its common stock. The dividend is payable on December 31, 2018, to stockholders of record as of December 14, 2018.<br /><a href="#">Read more</a></p>
            </div>
            <div class="sidebar_base"></div>
          </div>
          <div class="sidebar">
            <div class="sidebar_top"></div>
            <div class="sidebar_item">
              <h3>Our Partners</h3>
              <ul>
                <li><a href="#">BASE Corp.</a></li>
                <li><a href="#">PowDuPoint</a></li>
                <li><a href="#">LxxonCobil</a></li>
                <li><a href="#">LF Chem</a></li>
              </ul>
            </div>
            <div class="sidebar_base"></div>
          </div>
        </div>

        <div id="board_write">
          <h1><a href="./news.php">News</a></h1>
          <h4>write board</h4>
          <div id="write_area">
            <form action="write_ok.php" method="post">
              <div id="in_title">
                <textarea name="title" id="utitle" rows="1" cols="55" placeholder="title" maxlength="100" required></textarea>
	      </div>
              <br><br>
              <div class="wi_line"></div>
              <div id="in_content">
                <textarea name="content" id="ucontent" placeholder="contents" required></textarea>
              </div>
              <div class="bt_se">
                <button type="submit">submit</button>
              </div>
            </form>
          </div>
        </div>
    <div id="content_footer"></div>
    <div id="footer">
      <p><a href="News">Home</a> | <a href="about.html">About</a> | <a href="products.html">Products</a> | <a href="investors.html">Investors</a> | <a href="news.php">News</a></p>
      <p>Copyright 2001- 2018 EIT International LLC. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
