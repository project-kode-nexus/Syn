* * *

PVCpu (Pheonix Virtual CPU) Instruction Set Architecture
--------------------------------------------------------

### Category: MHSA (Modern Huge Simple Architecture)

**The PVCpu Architecture defines a modular instruction set focused on extensibility and efficient decoding.**

* * *

*   **PVCpu (Standard):** Fixed 32-bit width with 64/32-bit extensions.
*   **PVCpu-C (Compressed):** Optimized 16/32-bit format for density.

**Standard Instruction Layout (PVCpu) ->**  
`[ OPCODE: 12b ][ MODE: 4b ][ SRC: 6b ][ DEST: 6b ][ FLAGS: 4b ]`

**Flag Bitmask Structure:**  

\- _Bit 0:_ Valid Instruction (Executable)  
\- _Bit 1:_ Extension Present (Immediate / Absolute / Displacement)  
\- _Bit 2:_ Extension Width (1 = 64-bit, 0 = 32-bit)  
\- _Bit 3:_ Extended Flags Present (Chained flags enabled)

* * *

### Register Architecture

**Total Registers: 40 | Program-Accessible: 34**

**General Purpose Registers:**  

\- **G0 to G30:** Computation, addressing, and data movement.  
\- **NULL:** Constant zero.

**Control and Stack Registers:**  

\- **PC:** Program Counter (Internal)  
\- **LR:** Link Register (Return addresses)  
\- **SF:** Stack Frame Register  
\- **SP:** Stack Pointer

**Internal and System Registers:**  

\- **I0 - I2:** OS-reserved internal registers.  
\- **TR:** Timing Register (High-precision hardware delays/timers).

* * *

### PVCpu-C (Compressed Format)

**Base Header:** `[ OPCODE: 12b ][ EXTENDER: 4b ]`

**Key Benefits:**  

\- Instructions shrink to 2 bytes for zero-operand operations.  
\- Variable register field sizes (1, 2, 4, or 6 bits).  
\- Lower memory bandwidth usage and higher instruction density.

_**NOTE:** PVCpu-C is an encoding variant and is not used for native execution within current Pheonix-CPU hardware implementations._

* * *