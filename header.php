 <style>
 button.ugly {
	width:30px;
	height:30px;
 }
		.acomp {
		position: relative;
		display: inline-block;
		left: 105px;
		}
		.acompr {
		position: relative;
		display: inline-block;
		}
		.autocomplete {
		position: absolute;
		border-bottom: none;
		border-top: none;
		z-index: 99;
		top: 100%;
		left: 0;
		right: 0;
		}
 </style>
<header itemscope itemtype="http://schema.org/WPHeader">
  <div id="top-bar" class="loggedoff">
    <div id="logo">
      <a tabindex="-1" href="/">
        Kopya Sözlük
      </a>
    </div>
	<?php $_SESSION["svr"] = $_SERVER["REQUEST_URI"]; ?>
    <form autocomplete="off" action="<?php echo $_SERVER["REQUEST_URI"];?>" method="get" id="search-form" class="inline" role="search">
  <div class="acomp"><input type="text"  placeholder="başlık girin" id="searcher_box" accesskey="b"
          maxlength="145" style="width:400px" name="headeron" /></div>
		  <?php include "autocomplete_topics.php" ?>
  <span class="spin">↻</span>
  <button class="acompr" type="submit" name="header" value="load">
    <svg class="eksico">
      <use xlink:href="#eksico-filter"></use>
    </svg>
  </button>
  <button  class="acompr" type="submit" name="header" value="search" class="ugly">
        <svg class="eksico">
      <use xlink:href="#eksico-search"></use>
    </svg>
  </button>

</form>

  <nav id="top-navigation" class="" itemscope itemtype="http://schema.org/SiteNavigationElement">
<?php
	if(empty($_SESSION["username"])) {
		include "logged_out.php";
	}
	else 
	{
		include "logged_in.php";
	}
?>
  </nav>
    <div style="clear: both;"></div>
  
  <nav id="sub-navigation">
      <ul >
          <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>' title="bugün neler varmış bakalım">bugün</a></li>

  <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?c=1' title="evrenin sırlarını çözmek için">#bilim</a></li>
  <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?c=2' title="let's rock">#müzik</a></li>
  <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?c=3' title="stephen king'den robert jordan'a">#edebiyat</a></li>
  <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?c=4' title="if(!noproblem) noproblem = true">#coding</a></li>
  <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?c=5' title="ata sporları">#spor</a></li>
  <li><a href='<?php echo $_SERVER['PHP_SELF'] ?>?c=6' title="vahşet ve kan, kafa kesme ve korku">#siyaset</a></li>
</li>      
      </ul>

    </nav>


    <a href="https://seyler.eksisozluk.com" class="eksiseyler-logo-large-devices">
      <svg class="eksico">
        <use xlink:href="#eksico-drop"></use>
      </svg>
    </a>

  </div>
</header>





    


    <div class="container">

    </div>
    <div id="container">
        <div id="index-section" class="robots-nocontent">
            <nav id="partial-index" itemscope itemtype="http://schema.org/SiteNavigationElement">