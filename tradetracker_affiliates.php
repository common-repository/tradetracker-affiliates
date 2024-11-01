<?php
/*
Plugin Name: * tradetracker affiliates
Plugin URI: http://portaljumper.com
Description: Turn tradetracker affiliate datafeed into live & dynamic shopping pages on wordpress.
Author: owagu
Author URI: http://portaljumper.com/shop
Version: 1.0
*/

/*
/////////////////////////- how it works - ////////////////////////////////////////
This plugin will contact the linksalt.com servers to get the latest descriptions, images and pricing on the products
that you selected. 
Linksalt.com retrieves this information from all the associated affiliate networks and updates product information
on a frequent basis. (Sometimes up to 12 x per day).
On every page-load the latest information is fetched so your shopping page products are always up-to-date. You also never have to
worry about penalties from your merchants again for advertising wrong prices and/or product descriptions ( e.g. German
networks and merchants are very strict with that, other merchants are following suit)
/////////////////////////////////////////////////////////////////////////////////
*/



$tradetracker = 'tradetracker';
$aff_ID = '65027';

add_shortcode('tt_affi_code', 'affi_shortcode');

if (!function_exists('affi_shortcode'))
	{
	function affi_shortcode($pjatts)
		{
		global $m4n;
		ob_start();
		$feed = $pjatts['feed'];
		$net = $pjatts['net'];
		$count = $pjatts['count'];
		$ident = $pjatts['ident'];
		$search = $pjatts['search'];
		$layout = $pjatts['layout'];
		$who = get_bloginfo('url');
		$url = "http://linksalt.com/fmchome/pagemaker.php?count=$count&ident=$ident&net=$net&feed=$feed&s=$search&layout=$layout&who=$who";
			$fg = curl_init();
			curl_setopt($fg,CURLOPT_URL,$url);
			curl_setopt($fg,CURLOPT_FRESH_CONNECT,TRUE);
			curl_setopt($fg,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($fg,CURLOPT_CONNECTTIMEOUT,5);
			$page = curl_exec($fg);
			curl_close($fg);
		echo $page;
		
		$list = ob_get_clean();
			return $list;
		}
	}
	
add_action('admin_menu', 'tradetracker_affiliates_menu');

if (!function_exists('tradetracker_affiliates_menu'))
	{
	function tradetracker_affiliates_menu() 
		{
			add_options_page('tradetracker affiliate Options', 'tradetracker affiliates', 'manage_options', 'tradetracker_affiliate_settings', 'tradetracker_affiliate_page_content');
		}
	}

if (!function_exists('tradetracker_affiliate_page_content'))
	{	
	function tradetracker_affiliate_page_content() 
		{
		global $tradetracker;
		global $aff_ID;
		$x = plugins_url('',__FILE__);
		echo $x;
		echo "<LINK href='$x/style.css' rel='stylesheet' type='text/css'>";

		// reply on screen when page is complete
		if (isset($_POST['select1']) && wp_verify_nonce($_POST['mynonce'],'submit_'.$tradetracker)) 
			{		
			if (empty($_POST['shoptitle']))	{$_POST['shoptitle'] = "Shopping";}		
			elseif (empty($_POST['pj-layout'])) { echo "<h2>Couldn't find a layout selection</h2>Page not created ... please try again !<br>";}
			elseif (empty($_POST['pj-pagefeed'])) { echo "<h2>Couldn't find a feed selection</h2>Page not created ... please try again !<br>";}
			elseif (empty($_POST['pj-count'])) { echo "<h2>Couldn't find a count selection</h2>Page not created ... please try again !<br>";}
			elseif (empty($_POST['ID'])) { echo "<h2>Couldn't find an affiliate ID</h2>Page not created ... please try again !<br>";}
			else
				{
				$search= $_POST['pj-keyw'];
				if (empty($search)) {$key = "not provided";$s = "";} else {$key = $search;$s = "search=$search";}				
				$content = "[tt_affi_code $s net=$tradetracker layout=".$_POST['pj-layout']." feed=".$_POST['pj-pagefeed']." count=".$_POST['pj-count']." ident=".$_POST['ID']."]";			
				// Create post object
					$my_post = array(
					'post_type' => 'page',
					'post_title' => $_POST['shoptitle'],
					'post_content' => $content,
					'comment_status' => $_POST['comment'],
					'post_status' => 'publish',
					'post_author' => 1,  );
				// Insert the post into the database
					$pageID = wp_insert_post( $my_post );
					$permalink = get_permalink( $pageID ); 
					?>
				<div style='border:2px solid blue;box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;width:80%;padding:10px;margin:5px auto;text-align:center'>
				<h2>CHECK IT OUT ! A new page named <font color='blue'><?PHP echo $_POST['shoptitle']; ?></font> was created ! </h2>
				<b>The seedling keyword (if any) for this shop is </b><font color='red'><b><?PHP echo $key; ?></b></font><br>	
				<br><b>Note that the actual URl to your new page depends on your permalink settings.</b><br>
				Your new page can be found here : <a href='<?PHP echo $permalink; ?>' target='_BLANK'><?PHP echo $permalink; ?></a><BR><BR>";
				</div>
				<?PHP				
				}
			}
		?>
		
		<?PHP 
		/*
		IFRAME (NEWS UPDATES) removed per request plugins@wordpress.org
		<iframe src="http://linksalt.com/fmchome/plugintop-news.php" width="100%" height="30" scrolling="no">Your system does not support Iframes so you can not see the latest news</iframe>
		*/
		?>
		
		<div style='box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;width:80%;padding:10px;margin:5px auto;text-align:center'>
			<h1>tradetracker SEO Product Page builder</h1>
			by: Portaljumper.com - Affiliate masters for WordPress<br /><br />
				The tool on this page builds wordpress pages that display many of your affiliate products at once. More products on a page means more chances to sell.<br>
				Please note that this tool can be used in free mode or in Premium mode.<br />
				<table class="sample" >
				<strong><tr><th>Free Mode</th><th>Premium Mode</th></tr></strong>
				<tr><td>Sharing some links</td><td>ALL links point back to your ID</td></tr>
				<tr><td>Some reference to portaljumper.com</td><td>Complete white label operations</td></tr>
				<tr><td>low bandwidth server</td><td>high bandwidth PREMIUM server</td></tr>
				<tr><td>slower new shop-product updates</td><td>fast new shop-product updates</td></tr>
				<tr><td>maximum 10 pages per ID globally</td><td>No limits set per ID</td></tr>
				</table>

				<br/>
				The pages that you build using this tool are <strong>dynamically built in real-time</strong> and therefore always have the latest and most up-to-date product information.<br>
				You can now 'FIRE & FORGET' leaving your pages unattended as the content is always updated automatically.
				<hr>
				<form method="post">
				<input type="submit" name="video" value="show a help video" style="background-color:#81F781">
				</form>
				<?PHP 
				if ($_POST['video'] == "show a help video")
					{ echo '<iframe title="YouTube video player" width="480" height="390" src="http://www.youtube.com/embed/j_w5sUVd--A" frameborder="0" allowfullscreen></iframe>
					<form method="post">
					<input type="submit" name="video" value="hide this video" style="background-color:#81F781">
					</form>
					';
					}
				?>
		</div>

		<div id='creator' style='box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;width:80%;padding:10px;margin:5px auto;text-align:center'>
			<h1>DYNAMIC PAGE CREATOR </h1>
			<h2>All right ! Let's start building a product-page ....</h2><br>
			<form method="post"> 
			Provide your tradetracker Affiliate ID <br />
			<input type='text' name='tt_id' value='<?PHP echo get_option('tt_affiliate_id',$aff_ID); ?>' style='text-align:center;font-size:19px;font-weight:900;border:3px solid red;border-radius:15px'><br />
			<input type="hidden" name="netselect" value="yes">
			<?php wp_nonce_field('select'.$tradetracker,'mynonce'); ?>
			<input type="submit" style="background-color:yellow" value="Go Fetch the affiliate shops"/>
			</form>
		</div>
		
		<?PHP
		// once network selected get other options	
		if ( ($_POST['netselect'] == "yes") && wp_verify_nonce($_POST['mynonce'],'select'.$tradetracker))
			{		
				// fetching datafeeds from selected network
				$url = "http://linksalt.com/fmchome/getfeeds.php?network=$tradetracker";
				
				$fg = curl_init();
				curl_setopt($fg,CURLOPT_URL,$url);
				curl_setopt($fg,CURLOPT_FRESH_CONNECT,TRUE);
				curl_setopt($fg,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($fg,CURLOPT_CONNECTTIMEOUT,5);
				$feeds = curl_exec($fg);
				curl_close($fg);
		
				// explode & count stuff
				$feed = explode("|", $feeds);
				$feedcount = count($feed);
				// retrieve ID used for this particular network
				$selectID = $_POST['tt_id'];	
				
				// now let's go and check what kind of validuserid we have (freebie, PREMIUM, banned)
				$vurl = "http://linksalt.com/fmchome/checkid.php?checkid=".$selectID."&network=".$tradetracker;

				$vfg = curl_init();		
				curl_setopt($vfg,CURLOPT_URL,$vurl);
				curl_setopt($vfg,CURLOPT_FRESH_CONNECT,TRUE);
				curl_setopt($vfg,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($vfg,CURLOPT_CONNECTTIMEOUT,5);
				$validuser = curl_exec($vfg);
				$validuser = explode("|",$validuser);
				curl_close($vfg);
				$pjo['validuserid'] = $validuser[0];
		
				// end checking validuserid - the type of user is now stored
				?>
			<div id='success' style='box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;width:80%;padding:10px;margin:5px auto;text-align:center'>
				Succesfully retrieved data for the <font color='red'><?PHP echo $tradetracker; ?></font> network | <font color='red'><?PHP echo $feedcount; ?></font> feeds were found.<br/>
				<?PHP if (empty($selectID)) exit("<br><h3><font color='red'>Sorry, but I can not find an ID for the ".$tradetracker." network. Please select another network, or go enter your ID first !</font></h3>"); ?>
				your ID: <font color='red'><?PHP echo $selectID; ?> </font>is registered with this network in <font color='red'><?PHP echo $pjo['validuserid']; ?></font> mode.<br>Please proceed with your selection below.<hr>";
				<br />
				<form method="post"> 
				<!-- select a title -->
				<br>
				<h1>Your new shop acts as a PAGE in wordpress.</h1>
				Please provide a title for your new shop -><br>
					<script>			
						function clearText(thefield){
						if (thefield.defaultValue==thefield.value)
						thefield.value = ""
						} 
					</script>							
				<input type="text" name="shoptitle" size="60" value="portaljumper.com shop ..." onFocus="clearText(this)"><br><br>				
					<div style="margin:auto;width:70%;height:150px;overflow:auto;text-align:left;background-color:#F8ECE0">
					<?PHP
						for ( $feedcounter = 0; $feedcounter < $feedcount; $feedcounter++) 
							{
							echo "<input type='radio' name='pj-pagefeed' value='$feed[$feedcounter]'";
							 if ($feedcounter == "3") echo "CHECKED";
							echo ">$feed[$feedcounter]<br>";
							}
					?>
					</div>
				<br><br>
				<!-- select amount og products -->
				how many products do you want to show on your shopping page ?<br>
				(more products = slightly higher loading time)<br>
				<select name='pj-count'>
				<option DISABLED>Select number of products
				<?PHP
				$newfeed = 0;
				for ( $counter = 2; $counter < 40; $counter=$counter + 1) 
					{				
					$counterplus = $counter + 1;
					echo "<option value='$counterplus'>$counter products";
					}
				?>	
				</select>
				<br><br>
				<!-- select comment status -->
				Would you like to enable comments on your shop ?<br>
				<input type="radio" name="comment" value="open"> yes 
				<input type="radio" name="comment" value="closed" checked> No<br><br>			
				If you only want your shop to feature certain items you can provide a keyword here, otherwise leave this blank.
				<br> ( Tip: If there are no products with this word in the title your shop will be empty !).<br>
				<input type="text" name="pj-keyw" /><br>
				
				<br><br>
				Finally select a layout below:<hr>
					<?PHP
					// loop through all layouts and display selectors (...../layout/layout**)
					$locdir = plugin_dir_path(__FILE__); 
					$x = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
					if($handle = opendir($locdir."layout/")) {  
					  while(($file = readdir($handle)) !== false)
					  { 
						if (substr($file,0,6) == "layout" && substr($file,-3) == "jpg")
							{
							$detail = file_get_contents($locdir."layout/" . str_replace("jpg","txt",$file));
							$prpic = $x . "layout/" . $file;
							$noshow = $x . "layout/nopreview.jpg";
							$rem_file = str_replace(".jpg",'',$file);
							echo "
							<div style='float:left;width:180px; height:180px; overflow:hidden;border-style:solid;margin:2px;'>
							<input type='radio' name='pj-layout' value='$rem_file'>$rem_file
							<a class='thumbnail' href='#thumb'>
							<img src='$prpic' width='160' onError=\"this.src='$noshow';\" ><br>
							<span>$detail.<br><img src='$prpic' onError=\"this.src='$noshow';\"><br></span></a></div>";  		
							}
					  }    
					  closedir($handle);  
					 }  
					?>	
				<div style='clear:both'></div>	
				<br>				
				<INPUT TYPE=hidden NAME="ID" VALUE="<?PHP echo $selectID; ?> ">
				<INPUT TYPE=hidden NAME="pj-pagenet" VALUE="<?PHP echo $_POST['pj-pagenet']; ?> ">
				<INPUT TYPE=hidden NAME="select1" VALUE="1">
				<?php wp_nonce_field('submit_'.$tradetracker,'mynonce'); ?>
				<input type="submit" style="background-color:yellow" value="build a shopping PAGE with these values"/>
				</form>			
			</div>
			<div style='clear:both'></div>

			<?PHP
			}
		?>


			<div style='clear:both' id="bottom"></div>
		
		<div id='foot' style='box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;width:80%;padding:10px;margin:5px auto;text-align:center'>
		<p align="center">Portaljumper.com - feedmonster<br>Program & Design by: Pete Scheepens</p>
		Feedmonster is fully operational in free mode and many users make great money while they continue in freebie mode. Regular (free) accounts are allowed unlimited use of our servers but may be throttled down in favor of PREMIUM users when serverloads are high.<br>
		If you are operating feedmonster in free mode you can not use searchword and SEO features.<br>
		<br>
		<div style='clear:both'></div>
			<div>
				<div style="text-align:center;float:left;width:45%;box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;">
				<strong>Go premium now for just 9,95 a month and stop sharing</strong>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="KUL66HWC9VRHJ">
				<br>
				<input type="hidden" name="on0" value="enter your affiliate ID + net">enter your affiliate ID + network name<br><input type="text" name="os0" maxlength="60">
				<br>
				<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
				<img alt="" border="0" src="https://www.paypal.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
				</form>
				</div>

				<div style="text-align:center;float:right;width:45%;box-shadow:rgba(0,0,0,0.5) 0px 0px 24px; border-radius:12px;">
				<strong>Try premium for one month( 22,- once will stop automatically)</strong>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="hosted_button_id" value="QMT4UDYD4WQHU">
				<br>
				<input type="hidden" name="on0" value="enter network &amp; affiliate ID">enter your affiliate ID + network name<br><input type="text" name="os0" maxlength="60">
				<br>
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal is feed-monster's preferred partner.">
				<img alt="" border="0" src="https://www.paypal.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
				</form>
				</div>
			</div>
		<div style='clear:both'></div>
		</div>
		
		<?PHP 
		}
	}

			
			
			
			