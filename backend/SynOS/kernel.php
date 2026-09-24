<?php

class SynOS {
	public function boot(): void {
		echo "SynOS Loaded!\n";
	}
}

$kernel = new SynOS();
$kernel->boot();

?>