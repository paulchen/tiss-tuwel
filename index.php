<?php
require_once('config.php');

$filter = "host.name == \"$host\" && service.name == \"$service\"";

require_once('icinga-status.php');

$last_check = $icinga_service_data[$host][$service]['last_check_result']['execution_start'];
$current_state = $icinga_service_data[$host][$service]['state'];
$last_change = $icinga_service_data[$host][$service]['last_state_change'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Ist <?php echo $name ?> down? &ndash; <?php if($current_state == 0): ?>NEIN<?php else: ?>JA<?php endif; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="60" />
</head>
<body style="padding:0; margin: 0; overflow: hidden;">
	<div style="position: absolute; top: 50%; left: 50%;">
		<div style="position: absolute; width: 800px; left: -400px; height: 320px; top: -160px; font-family: sans-serif; text-align: center;">
			<div style="font-size: 200px; font-weight: bold;">
				<?php if($current_state == 0): ?>NEIN.<?php else: ?>JA.<?php endif; ?><br />
			</div>
			<?php if($current_state == 0): ?>
				<a href="https://<?php echo $vhost ?>/"><?php echo $name ?></a> ist derzeit erreichbar.
			<?php else: ?>
				<a href="https://<?php echo $vhost ?>/"><?php echo $name ?></a> ist derzeit nicht erreichbar.
			<?php endif; ?>
			<br /><br />
			(seit <?php echo date('d.m.Y H:i', $last_change); ?>)<br /><br />
			Letzte &Uuml;berpr&uuml;fung: <?php echo date('d.m.Y H:i', $last_check); ?>
			<br /><br /><br />
			<span style="font-size: 80%;">
				<a href="//rueckgr.at">rueckgr.at</a> | <a href="//staroch.name">staroch.name</a>
			</span>
		</div>
	</div>
</body>
</html>
