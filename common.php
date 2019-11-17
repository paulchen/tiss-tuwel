<?php
require_once('config.php');
$current_state=trim(`grep -A 35 "vhost $vhost" /var/lib/icinga/status.dat|grep current_state|sed -e "s/^.*=//g"`);
$last_change=trim(`grep -A 35 "vhost $vhost" /var/lib/icinga/status.dat|grep last_state_change|sed -e "s/^.*=//g"`);
$last_check=trim(`grep -A 35 "vhost $vhost" /var/lib/icinga/status.dat|grep last_check|sed -e "s/^.*=//g"`);

