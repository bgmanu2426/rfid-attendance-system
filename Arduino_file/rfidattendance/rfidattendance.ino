/*------------------------------------References--------------------------------------
//
// HTTPClient for ESP32 --> https://github.com/espressif/arduino-esp32/tree/master/libraries/HTTPClient
// MFRC522 for RFID Reader --> https://github.com/miguelbalboa/rfid
// ThingPulse OLED SSD1306 for OLED 128x64 Display --> https://github.com/ThingPulse/esp8266-oled-ssd1306
// NTPClient for showing time --> https://github.com/arduino-libraries/NTPClient
// NTPClient ESP32 time example --> https://randomnerdtutorials.com/esp32-ntp-client-date-time-arduino-ide/
// WiFi and WiFiUdp --> https://github.com/espressif/arduino-esp32/tree/master/libraries/WiFi
// Display Fonts --> http://oleddisplay.squix.ch/
//
*/

#include <WiFi.h>           // ESP32 WiFi Library
#include <HTTPClient.h>     // To send HTTP Request to Server
#include <SPI.h>            // To declare software SPI pins
#include <MFRC522.h>        // RFID Library
#include <SSD1306Wire.h>    // 128x64 OLED Display
#include <Wire.h>           // To declare software I2C pins
#include <NTPClient.h>      // NTP (Network Time Protocol) to display time
#include <WiFiUdp.h>        // To send request and update time from NTP Server

//Local files these should be imported locally which contains Fonts, Server and Wi-Fi Credentials
#include "Rancho_Regular.h"
#include "secrets.h"

// Define SPI pins for RFID Reader
#define SS_PIN 21
#define RST_PIN 5
#define Relay_Pin 15

String getData, Link;
String formattedDate;
String dayStamp;
String timeStamp;

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance.
WiFiUDP ntpUDP;
NTPClient timeClient(ntpUDP); // Define NTP Client to get time

const char *ssid = WLAN_USERNAME;
const char *password = WLAN_PASSWORD;

// Define I2C pins for OLED display
#define OLED_RESET -1  // Reset pin because OLED dosent have a default reset PIN
#define OLED_SDA 4
#define OLED_SCL 22
SSD1306Wire display(0x3C, OLED_SDA, OLED_SCL); //0x3C is the I2C address of OLED display

void setup() {
  Serial.begin(9600);
  SPI.begin();         // Init SPI bus
  mfrc522.PCD_Init();  // Init MFRC522 card
  display.init();      // Init OLED display
  display.flipScreenVertically();  // Flips the screen
  connectToWiFi();        // Connect to WiFi
  timeClient.begin();     // Init NTPClient
  timeClient.setTimeOffset(19800); // Set offset according to IST
}

void loop() {
  if (!WiFi.isConnected()) {
    connectToWiFi();  //Retry to connect to Wi-Fi
  }

  while (!timeClient.update()) {
    timeClient.forceUpdate();  // Update time
  }
  
  formattedDate = timeClient.getFormattedDate(); 
  int splitT = formattedDate.indexOf("T");
  dayStamp = formattedDate.substring(0, splitT); // Extract date
  timeStamp = formattedDate.substring(splitT + 1, formattedDate.length() - 1); // Extract time

  display.clear();
  display.setFont(Rancho_Regular_20);
  display.setTextAlignment(TEXT_ALIGN_LEFT);
  display.drawString(13, 10, "Scan Your Card");
  // display.drawString(6, 35, dayStamp);
  display.drawString(36, 35, timeStamp);
  display.display();

  //look for new card
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;  //got to start of loop if there is no card present
  }

  // Select one of the cards
  if (!mfrc522.PICC_ReadCardSerial()) {
    return;  //if read card serial(0) returns 1, the uid struct contians the ID of the read card.
  }

  // Read Card UID
  String CardID = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    CardID += mfrc522.uid.uidByte[i];
  }

  CardID.replace(" ", ""); //Remove spaces from the CardUID Number
  SendCardID(CardID);
  delay(3000);
}

// Send CardUID to Website
void SendCardID(String Card_uid) {
  display.clear();
  display.setFont(ArialMT_Plain_10);
  display.setTextAlignment(TEXT_ALIGN_CENTER_BOTH);
  display.drawString(64, 25, "Verifying the ID");
  display.display();

  Serial.println("Sending the Card ID :");
  if (WiFi.isConnected()) {
    HTTPClient http;                       //Declare object of class HTTPClient
    getData = "?uid=" + String(Card_uid);  // Add the Card ID to the GET array in order to send it //GET Data
    Link = REQ_URL + getData;                  //GET method
    http.begin(Link);                      //initiate HTTP request   //Specify content-type header

    int httpCode = http.GET();          //Send the request
    String payload = http.getString();  //Get the response payload
    Serial.println(Card_uid);
    Serial.println(httpCode);
    Serial.println(payload);

    if (httpCode == -1) {
      display.clear();
      display.setFont(ArialMT_Plain_10);
      display.setTextAlignment(TEXT_ALIGN_CENTER_BOTH);
      display.drawString(64, 30, "Internal Server ERROR");
      display.display();
    } else {
      display.clear();
      display.setFont(ArialMT_Plain_10);
      display.setTextAlignment(TEXT_ALIGN_LEFT);
      display.drawStringMaxWidth(10, 10, 128, payload);
      display.display();
    }

    if (httpCode == 200) {
      //Open the Lock
      digitalWrite(Relay_Pin, HIGH);
      Serial.println("Lock is Open");
      delay(7000);
      digitalWrite(Relay_Pin, LOW);
      Serial.println("Lock is Closed");
    }
    http.end();  //Close connection
  }
}

void connectToWiFi() {
  display.clear();
  display.setFont(ArialMT_Plain_10);
  display.setTextAlignment(TEXT_ALIGN_CENTER_BOTH);
  display.drawString(64, 34, "Connecting to Wi-Fi");  //  adds to buffer
  display.display();

  WiFi.mode(WIFI_OFF);  //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);
  Serial.print("Connecting to Wi-Fi");
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("Connected to ");
  Serial.println(ssid);

  display.clear();
  display.setFont(ArialMT_Plain_10);
  display.setTextAlignment(TEXT_ALIGN_CENTER_BOTH);
  display.drawString(64, 28, "Wi-Fi Connected to");
  display.drawString(64, 38, String(ssid));
  display.display();
  delay(3000);
}