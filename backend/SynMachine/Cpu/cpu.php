<?php

// PVCpu Opcodes
final class PVCpuOpcodes {
	public const int OP_ADD = 0x1;
    public const int OP_SUB = 0x2;
    public const int OP_MUL = 0x3;
    public const int OP_DIV = 0x4;
    public const int OP_AND = 0x5;
    public const int OP_OR = 0x6;
    public const int OP_NOR = 0x7;
    public const int OP_XOR = 0x8;
    public const int OP_XNOR = 0x9;
    public const int OP_NOT = 0xA;
    public const int OP_NAND = 0xB;
    public const int OP_CMP = 0xC;
    public const int OP_UCMP = 0xD;
    public const int OP_TEST = 0xE;
    public const int OP_RSHIFT = 0xF;
    public const int OP_LSHIFT = 0x10;
    public const int OP_ARSHIFT = 0x11;
    public const int OP_ARLSHIFT = 0x12;
    public const int OP_ROTR = 0x13;
    public const int OP_ROTL = 0x14;
    // Memory
    public const int OP_LOAD = 0x100;
    public const int OP_STORE = 0x101;
    // Registers
	public const int OP_MOV = 0x150;
}

// PVCpu Modes
final class PVCpuModes {
    public const int NULL_MODE = 0x0; // No mode
    public const int REG_REG = 0x1; // dest = src
    public const int REG_IMM = 0x2; // src is actually a imm! dest is a reg (dest = src (as imm))
    public const int REG_EXTIMM = 0x3; // Allows use of Bit 1 of Flags (dest = imm)
    public const int REG_DISP = 0x4; // Allows use of Bit 2 of Flags (dest = mem[disp + PC])
    public const int LOAD_REGADDR = 0x5; // dest = mem[src]
    public const int LOAD_IMMADDR = 0x6; // dest = mem[imm]
    public const int LOAD_PC_REL = 0x7; // dest = mem[src (as offset) + PC]
    public const int STORE_REGADDR = 0x8; // mem[dest] = src
    public const int STORE_IMMADDR = 0x9; // mem[imm] = src
    public const int STORE_PC_REL = 0xA; // mem[dest (as offset) + PC] = src
    // Special
    public const int SRC_REG = 0xB; // opcode (src)
    public const int SRC_REG_IMM = 0xC; // opcode (src (as imm))
    public const int SRC_IMM = 0xD; // opcode (imm)
}

class PVCpuRegfile {
	// Reg file <array[str, int]>
	private array $registers = [];
	private const array REGFILE_MAP = [
		1 => "g0",
		2 => "g1",
		3 => "g2",
		4 => "g3",
		5 => "g4",
		6 => "g5",
		7 => "g6",
		8 => "g7",
		9 => "g8",
		10 => "g9",
		11 => "g10",
		12 => "g11",
		13 => "g12",
		14 => "g13",
		15 => "g14",
		16 => "g15",
		17 => "g16",
		18 => "g17",
		19 => "g18",
		20 => "g19",
		21 => "g20",
		22 => "g21",
		23 => "g22",
		24 => "g23",
		25 => "g24",
		26 => "g25",
		27 => "g26",
		28 => "g27",
		29 => "g28",
		30 => "g29",
		31 => "g30",
		32 => "lr",
		33 => "sf",
		34 => "sp"
	];

	// Returns if register exists
	public function does_register_exist(int $addr) : bool {
		if (isset(self::REGFILE_MAP[$addr])) {
			$regname = self::REGFILE_MAP[$addr];
			if (isset($this->registers[$regname])) {
				return true;
			}
		}
		return false;
	}

	// Retrieves the Register value
	public function get_register_value(int $addr) : int {
		if ($this->does_register_exist($addr)) {
			$regname = self::REGFILE_MAP[$addr];
			return $this->registers[$regname];
		}
		return -1;
	}

	// Sets/Updates the value of a register
	public function set_register_value(int $addr, int $value) : bool {
		if ($this->does_register_exist($addr)) {
			$regname = self::REGFILE_MAP[$addr];
			$this->registers[$regname] = $value;
			return true;
		}
		return false;
	}

	// Resets all registers
	public function reset() : void {
		for ($i = 0; $i < 31; $i++) {
			$this->registers["g{$i}"] = 0;
		}
		$this->registers['lr'] = 0;
		$this->registers['sf'] = 0;
		$this->registers['sp'] = 0xFFFF;
	}

	public function __construct() {
		$this->reset();
	}
}

class PVCpuIState {
	// IState Reg file <array[str, int]>
	private array $registers = [];
	private const array REGFILE_MAP = [
		// 35 is PC, aka not allowed for access
		36 => "i0",
		37 => "i1",
		38 => "i2",
		39 => "tr",
	];

	// Returns if register exists
	public function does_register_exist(int $addr) : bool {
		if (isset(self::REGFILE_MAP[$addr])) {
			$regname = self::REGFILE_MAP[$addr];
			if (isset($this->registers[$regname])) {
				return true;
			}
		}
		return false;
	}

	// Retrieves the Register value
	public function get_register_value(int $addr) : int {
		if ($this->does_register_exist($addr)) {
			$regname = self::REGFILE_MAP[$addr];
			return $this->registers[$regname];
		}
		return -1;
	}

	// Sets/Updates the value of a register
	public function set_register_value(int $addr, int $value) : bool {
		if ($this->does_register_exist($addr)) {
			$regname = self::REGFILE_MAP[$addr];
			$this->registers[$regname] = $value;
			return true;
		}
		return false;
	}

	// Resets all registers
	public function reset() : void {
		for ($i = 0; $i < 3; $i++) {
			$this->registers["i{$i}"] = 0;
		}
		$this->registers['tr'] = 0;
	}

	public function __construct() {
		$this->reset();
	}
}

// NOTE: Uses PVCpu Architecture
class SynCpu {
	private const VERSION = "1.0.0";

	private PVCpuRegfile $regfile;
	private PVCpuIState $istate;

	private int $pc = 0;
	private bool $halted = false;

	public function __construct() {
		$this->regfile = new PVCpuRegfile();
		$this->istate = new PVCpuIState();
		$this->reset();
	}

	// Resets the CPU
	public function reset() : void {
		$this->pc = 0; // Starts execution at addr 0
		$this->halted = false;

		// Reset Registers
		$this->regfile->reset();
		$this->istate->reset();
	}
}

?>