<?php
function FUNCLIB_encode_ip($dotquad_ip)
{
	if (!$dotquad_ip) return "";
	$ip_sep = explode('.', $dotquad_ip);
	return sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
    
}
?>