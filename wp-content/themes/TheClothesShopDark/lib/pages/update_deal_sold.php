<?php
//Update_deal_sold
if ( !empty($_GET) && !empty($_GET['p'])) {
	update_post_meta ($_GET['p'], "ad_post_status", "SOLD OUT");
}
?>