# RFID-Based Smart Attendance System

An IoT-enabled smart attendance system built using RFID technology, the ESP32 microcontroller, and a LAMP stack. This system not only tracks attendance but also controls access through a solenoid lock, providing an integrated solution for user authentication and data management.

---

## Features
- **RFID Authentication**: Use RFID cards to authenticate users.
- **OLED Display**: Displays user details upon successful authentication.
- **Access Control**: A solenoid lock unlocks the entry for authorized users.
- **Web Dashboard**: View and manage attendance records using a LAMP stack-based web interface with DataTables.
- **Real-Time Updates**: The server instantly updates attendance data.

---

## Hardware Components
- **ESP32**: Microcontroller for handling RFID data and communication with the server.
- **RFID-RC522 Reader**: Reads RFID card data for user authentication.
- **OLED Display**: Shows user details and system status.
- **Relay Module**: Controls the solenoid lock based on the ESP32's signal.
- **Solenoid Lock**: Grants or denies access based on authentication.
- **Power Supply**: Provides power to the components.

---

## Software Stack
- **Microcontroller Programming**: Code written in Arduino IDE for the ESP32.
- **Backend**: 
  - **Linux**: Hosting the server.
  - **Apache**: Web server to handle requests.
  - **MySQL**: Database to store user and attendance data.
  - **PHP**: Backend scripting for server logic.
- **Frontend**: 
  - **HTML/CSS/JavaScript**: Builds the web interface.
  - **DataTables**: Enhances the data display with search, filter, and sort functionality.

---

## Installation and Setup
### 1. **Hardware Setup**
   - Connect the RFID-RC522 reader to the ESP32 following the pinout provided in the code.
   - Connect the OLED display to the ESP32.
   - Connect the relay module to the ESP32 and configure it to control the solenoid lock.
   - Attach the solenoid lock to the relay.
   - Ensure the ESP32 is powered and connected to the internet.

### 2. **Software Setup**
   - Clone this repository:
     ```bash
     git clone https://github.com/bgmanu2426/rfid-attendance-system
     ```
   - Upload the Arduino code to the ESP32 using the Arduino IDE.
   - Set up the LAMP stack on your server:
     1. Install Apache, MySQL, and PHP.
     2. Import the provided database schema into MySQL.
     3. Place the PHP and web interface files in the Apache web directory.
   - Update the ESP32 code with your server's IP address and Wi-Fi credentials.

---

## Usage
1. **Register Users**:
   - Add new users by registering their RFID card details in the database.
2. **Authenticate Users**:
   - When a user scans their RFID card, the system validates their details.
   - If authenticated, the OLED display shows their details, the relay module activates the solenoid lock, and access is granted.
3. **Manage Users**:
   - Update the details of the currently enrolled users or to delete the user.
5. **Monitor Attendance**:
   - Log in to the web interface to view and manage attendance records.

---

## Future Enhancements
- Add email/SMS notifications for attendance and alerts.
- Integrate biometric authentication for added security.
- Expand the web dashboard with analytics and user management features.

---

## Acknowledgments
- Thanks to the open-source community for libraries and tools.
- Special mention to tutorials and guides that inspired this project.

---

## References
- The detailed report of the project is found avilable [here](/public/RFID%20Cloud%20Based%20Smart%20Attendace%20System%20-%20Project%20Report.pdf)

---

## Contact
If you have any questions or suggestions, please mail me [here](mailto:bgmanu2426@gmail.com).

