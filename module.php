
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html> 
    <head> 
        <title>Component sync</title> 
        <link rel="stylesheet" type="text/css" href="media/style/MODxCarbon/style.css" /> 
    </head> 
    <body> 
    <script type="text/javascript">
    var locationOptions = { dump: 'file system', load: 'database' };
    function updateContent(obj){
  		var objContent = document.getElementById('change-location');
  		objContent.innerHTML = locationOptions[ obj[obj.selectedIndex].value ];
  	}
    </script>
        <h1>Component Sync</h1> 
        <div id="actions"> 
            <ul class="actionButtons"> 
                <li id="Button1"><a href="#" onclick="document.location.href='index.php?a=106';"><img src="media/style/MODxCarbon/images/icons/stop.png" /> Close Component Sync</a></li> 
            </ul> 
        </div>        
	    <div class="sectionHeader">Select an action</div> 
	    <div class="sectionBody"> 
	   
<form method="post" action="">

<p>I'd like to copy snippets, chunks, templates, plugins</p>
<p><select name="action" onchange="updateContent(this)">
	<option value="dump">From the Database TO the file system</option>
	<option value="load">From the File System TO the Database</option>
</select></p>

<p><input type="checkbox" name="agree" value="1"/> I understand that all changes I've made in the <span id="change-location">file system</span> <strong>will be overwritten</strong>, and it is my responsibility to back them up (e.g. using version control)</p>

<input type="submit" />
</form>
	    </div> 
	</div> 
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST'):?>
	<div id="interaction"> 
    <div class="sectionHeader">Results</div> 
    <div class="sectionBody"> 
<?php if ($_POST['agree'] != 1): ?>You must tick the box!
<?php else: 
$tt = array('snippets', 'chunks', 'plugins', 'templates');

if ($_POST['action'] == 'dump') {
  $class = 'ComponentDump';
} else if ($_POST['action'] == 'load') {
  $class = 'ComponentLoad';
} else {
  die("Option '{$argv[1]}' is unknown\nThe possible options are:\n\tload\n\tdump\n");
}

require_once $modx->config['base_path']."assets/modules/component-sync/classes/$class.php";
foreach($tt as $t) {
	/* @var $c ComponentLoad */
  try {
	$c = new $class($modx, $t);
	$c->run();
	echo '<pre>';
	echo $c->getStats();
	echo '</pre>';
  } catch (Exception $e) {
    echo '<pre>'.$e->getMessage().'</pre>';
  }
}
endif; ?>
    <div style="clear:both;"></div> 
</div> 
<?php endif; ?>
    </body> 
</html>