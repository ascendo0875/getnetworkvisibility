<?php

error_reporting(E_ALL-E_NOTICE);
                       
$dir    = '.';
$files = scandir($dir);
$exclude = array(
				".",
				"..",
				"list.html",
				"index.php",
				"js",
				"images",
				"css",
				"js",
				"iepngfix.htc",
				"favicon.ico",
                "fonts"
				);

if($_REQUEST["array"] == 'true'):
	foreach($files as $f){
		if(!in_array($f, $exclude) && strpos($f, ".") !== 0 && strpos($f, "~") !== 0){
			?>"<?php echo $f ?>" => array(
	"name" => "<?php echo str_replace(".html", "", str_replace("-", " ", $f)) ?>",
	"dev"  => "",
	""     => "",
),
<?php
		}
	}
else:
	?><ul><?php
	foreach($files as $f){
		if(!in_array($f, $exclude) && strpos($f, ".") !== 0 && strpos($f, "~") !== 0){
			?><li><a href="<?php echo $f ?>" target="_blank"><?php echo $f ?></a></li><?php
		}
	}
	?></ul><?php
endif;

?>
