<?php
declare(strict_types=1);

final class SynMachine {
	private bool $loaded = false; // Specifies if the machine is loaded

	// Starts the machine, REQUIRED TO CALL BEFORE ANY OTHER FUNCTION
	public function start(array $configuration = []) : void {
		if ($this->loaded) {
			throw new RuntimeException("(SynMachine): Machine is already started!");
		}

		$this->loaded = true;
		echo "(SynMachine): Started!\n";
	}

	// Returns the state of the machine (if it has been started)
	public function is_started(): bool {
		return $this->loaded;
	}
}

$machine = new SynMachine();
if (!$machine->is_started()) {
	$machine->start();
}
?>