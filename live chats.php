<?php 
/*
Plugin Name: Live Chats
Description: Select or change your live chat provider in one click.
Author: Chudesnet
Version: 1.2.5
*/


$zm_poly = new zm_chat;

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'plugin_add_settings_link' );

function plugin_add_settings_link( $links ) {
	$settings_link = '<a href="admin.php?page=live-chats-for-woocommerce-all-in-one/live%20chats.php">Settings</a>';
	array_push( $links, $settings_link );
	return $links;
}
	
class zm_chat{
	
	function __construct(){
		add_action( "admin_menu",array($this,"reg_menu"));
		add_action( 'admin_init', array($this,'register_mysettings') );
		add_action( 'wp_footer', array($this,'print_script'));
	}
	
	function print_script(){
		$options=get_option("zm_chat_settings_group");
		echo "\n<!--Live Chats-->";
		if(isset( $options["active"] ) && $options["active"]=="Zopim"){
		?>	
<!-- begin Zopim code -->
<!-- end Zopim code -->
		<?php		
		}
		elseif(isset( $options["active"] ) && $options["active"]=="Purechat"){
		?>	
<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: '<?php echo $options["Purechat"];?>', f: true }); done = true; } }; })();</script>
		<?php		
		}
		elseif(isset( $options["active"] ) && $options["active"]=="Olark"){
		?>	

<!-- begin olark code -->
<script data-cfasync="false" type='text/javascript'>/*<![CDATA[*/window.olark||(function(c){var f=window,d=document,l=f.location.protocol=="https:"?"https:":"http:",z=c.name,r="load";var nt=function(){
f[z]=function(){
(a.s=a.s||[]).push(arguments)};var a=f[z]._={
},q=c.methods.length;while(q--){(function(n){f[z][n]=function(){
f[z]("call",n,arguments)}})(c.methods[q])}a.l=c.loader;a.i=nt;a.p={
0:+new Date};a.P=function(u){
a.p[u]=new Date-a.p[0]};function s(){
a.P(r);f[z](r)}f.addEventListener?f.addEventListener(r,s,false):f.attachEvent("on"+r,s);var ld=function(){function p(hd){
hd="head";return["<",hd,"></",hd,"><",i,' onl' + 'oad="var d=',g,";d.getElementsByTagName('head')[0].",j,"(d.",h,"('script')).",k,"='",l,"//",a.l,"'",'"',"></",i,">"].join("")}var i="body",m=d[i];if(!m){
return setTimeout(ld,100)}a.P(1);var j="appendChild",h="createElement",k="src",n=d[h]("div"),v=n[j](d[h](z)),b=d[h]("iframe"),g="document",e="domain",o;n.style.display="none";m.insertBefore(n,m.firstChild).id=z;b.frameBorder="0";b.id=z+"-loader";if(/MSIE[ ]+6/.test(navigator.userAgent)){
b.src="javascript:false"}b.allowTransparency="true";v[j](b);try{
b.contentWindow[g].open()}catch(w){
c[e]=d[e];o="javascript:var d="+g+".open();d.domain='"+d.domain+"';";b[k]=o+"void(0);"}try{
var t=b.contentWindow[g];t.write(p());t.close()}catch(x){
b[k]=o+'d.write("'+p().replace(/"/g,String.fromCharCode(92)+'"')+'");d.close();'}a.P(2)};ld()};nt()})({
loader: "static.olark.com/jsclient/loader0.js",name:"olark",methods:["configure","extend","declare","identify"]});
/* custom configuration goes here (www.olark.com/documentation) */
olark.identify('<?php echo $options["Olark"];?>');/*]]>*/</script><noscript><a href="https://www.olark.com/site/<?php echo $options["Olark"];?>/contact" title="Contact us" target="_blank">Questions? Feedback?</a> powered by <a href="http://www.olark.com?welcome" title="Olark live chat software">Olark live chat software</a></noscript>
<!-- end olark code -->
		<?php		
		}
		elseif(isset( $options["active"] ) && $options["active"]=="Websitealive"){
		?>
<script type="text/javascript" charset="utf-8">		
function wsa_include_js(){
var wsa_host = (("https:" == document.location.protocol) ? "https://" : "http://");
var js = document.createElement("script");
js.setAttribute("language", "javascript");
js.setAttribute("type", "text/javascript");
js.setAttribute("src",wsa_host + "tracking.websitealive.com/vTracker_v2.asp?objectref=<?php echo $options["Websitealive"];?>&groupid=<?php echo $options["Websitealive2"];?>&websiteid=<?php echo $options["Websitealive3"];?>");
document.getElementsByTagName("head").item(0).appendChild(js);
}
if (window.attachEvent) {window.attachEvent("onload", wsa_include_js);}
else if (window.addEventListener) {window.addEventListener("load", wsa_include_js, false);}
else {document.addEventListener("load", wsa_include_js, false);}
</script>
		<?php		
		}
		echo "<!--End Live Chats-->\n";
	}
	
	function reg_menu(){
		$menu_slug = add_menu_page("Your Live Chat Settings","Live Chat","administrator",__FILE__, array($this, "page_content"));
	}
	
	function register_mysettings(){
		register_setting( 'zm_chat_settings_group', 'zm_chat_settings',array($this,"sanitize_settings" ));
	}
	
	function sanitize_settings($sett){
		$options=get_option("zm_chat_settings_group",array());
		if(isset($sett["Zopim"])){
			$options["Zopim"]=$sett["Zopim"];
			$options["active"]="Zopim";
		}
		elseif(isset($sett["Olark"])){
			$options["Olark"]=$sett["Olark"];
			$options["active"]="Olark";
		}
		elseif(isset($sett["Purechat"])){
			$options["Purechat"]=$sett["Purechat"];
			$options["active"]="Purechat";
		}
		elseif(isset($sett["Websitealive"])){
			$options["Websitealive"]=$sett["Websitealive"];
			$options["Websitealive2"]=$sett["Websitealive2"];
			$options["Websitealive3"]=$sett["Websitealive3"];
			$options["active"]="Websitealive";
		}
		elseif(isset($sett["reset"])){
			$options["active"]=false;
		}
		update_option("zm_chat_settings_group", $options);
	}
	
	function page_content(){
		$options=get_option("zm_chat_settings_group",array());
		?>
      <style>
	  .chats .item{width: 400px;background-color: #EAEAEA;margin-top: 20px;padding: 10px 20px;}
	  .disable{background: none;border: none;cursor: pointer;color: blue;}
	  .inline{display:inline;}
	  .disable:hover{text-decoration: underline;}
		input[type="text"]{
			height: 38px;
			width: 395px;
			padding: 8px 12px;
			font-size: 14px;
			line-height: 1.42857143;
			color: #272b30;
			background-color: #ffffff;
			background-image: none;
			border: 1px solid #cccccc;
			border-radius: 4px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
			box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
			-webkit-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
			transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		}
		.chats .item .margin_botton{
			margin-bottom:10px;
		}
		.chats .item .txtlabel a{
			font-size:13px;
			font-weight:bold;
		}
		.chats .item .txtlabel{
			margin-bottom:5px;
			margin-top:5px;
			font-size:15px;
		}
		
		.optin{
			padding:30px;
			font-size:15px;
			font-weight:bold;
		}
		.chats .item h2{
			padding-top:0px;
			font-size:20px;
		}
		

	  </style>
	  <div class="wrap chats">
          <h1>Your Live Chat Settings</h1><h2></h2>
			<?php
			if(isset( $options["active"] ) && $options["active"]){
			  echo '<h2>Active Chat: <b>'. $options["active"] . '</b>';
			?>
              <form method="post" action="options.php" class="inline">
                <?php settings_fields( 'zm_chat_settings_group' ); ?>
                <input type="hidden" name="zm_chat_settings[reset]" value="1"/>
                <input type="submit" value="Disable" name="submit" id="submit" class="disable"  />
              </form>
          	<?php
			}
			else
			  echo "<h2 style=\"font-size:14px; color:red;\">No active chat selected. Choose your chat service from the list.";
			?>
          </h2>
			
			<div class="item">
				<h2>Pure Chat Setting <?php if(isset( $options["active"] ) && $options["active"]=="Purechat") echo " (Active)";?></h2>
				<div class="txtlabel">Chat Box ID <a href="https://www.purechat.com/?aid=531b6ea6-f7f0-4909-875c-fe2af7a6c19d&cid=d3bfe4fd-e3d7-467c-a0e6-9c9ca968704d" target="_blank">don't have one? get on official site</a></div>
				<form method="post" action="options.php" onsubmit="return validatePurechat('zm_text');">
				  <?php settings_fields( 'zm_chat_settings_group' ); ?>
				  <div><input class="margin_botton" id="zm_text" type="text" name="zm_chat_settings[Purechat]" value="<?php if(isset( $options["Purechat"] )) echo $options["Purechat"];?>" placeholder="Type your Chat Box ID here" /></div>
				  <div><input type="submit" value="Activate" name="submit" id="submit" class="button button-primary"/></div>
				</form>
			</div>
			<div class="item">
				<h2>WebsiteAlive Setting <?php if(isset( $options["active"] ) && $options["active"]=="Websitealive") echo " (Active)";?></h2>
				<div class="txtlabel">Account settings <a href="http://bit.ly/1ruRqGR" target="_blank">don't have one? get on official site</a></div>
				<form method="post" action="options.php" onsubmit="return validateWebsitealive();">
				  <?php settings_fields( 'zm_chat_settings_group' ); ?>
				  <div><input class="margin_botton" type="text" id="ws1_text" name="zm_chat_settings[Websitealive]" value="<?php echo $options["Websitealive"];?>" placeholder="Type your ObjectRef here" /></div>
				  <div><input class="margin_botton" type="text" id="ws2_text" name="zm_chat_settings[Websitealive2]" value="<?php echo $options["Websitealive2"];?>" placeholder="Type your GroupID here" /></div>
				  <div><input class="margin_botton" type="text" id="ws3_text" name="zm_chat_settings[Websitealive3]" value="<?php echo $options["Websitealive3"];?>" placeholder="Type your WebsiteID here" /></div>
				  <div><input type="submit" value="Activate" name="submit" id="submit" class="button button-primary"/></div>
				</form>
			</div>
			<div class="item">
				<h2>Olark Setting <?php if(isset( $options["active"] ) && $options["active"]=="Olark") echo " (Active)";?></h2>
				<div class="txtlabel">Account ID <a href="http://special.olark.com/cvM9s" target="_blank">don't have one? get on official site</a></div>
				<form method="post" action="options.php" onsubmit="return validateOlark();">
				  <?php settings_fields( 'zm_chat_settings_group' ); ?>
				  <div><input class="margin_botton" type="text" id="o_text" name="zm_chat_settings[Olark]" value="<?php if(isset( $options["Olark"] )) echo $options["Olark"];?>" placeholder="Type your Olark Account ID here" /></div>
				  <div><input type="submit" value="Activate" name="submit" id="submit" class="button button-primary"/></div>
				</form>
			</div>  
	  
	  </div>
	  
	  <script>
		
		function validatePurechat(inputName)
		{
			if(document.getElementById(inputName).value == '')
			{
				alert('Please fill Chat Box ID');
				return false;
			}
			return true;
		}
		
		function validateWebsitealive()
		{
			if(document.getElementById("ws1_text").value == '')
			{
				alert('Please fill Object ID');
				return false;
			}
			if(document.getElementById("ws2_text").value == '')
			{
				alert('Please fill Group ID');
				return false;
			}
			if(document.getElementById("ws3_text").value == '')
			{
				alert('Please fill Website ID');
				return false;
			}
			return true;
		}

		function validateOlark()
		{if(document.getElementById("o_text").value == '')
			{alert('Please fill Account ID');
				return false;}
			return true;
		}

		function validate(inputName)
		{
			if(document.getElementById(inputName).value == '')
			{
				alert('Please fill Widget ID');return false;
			}
			return true;
		}

	  
	  </script>
	  
        <?php
	}
}