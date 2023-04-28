//ESP32----------------------------
#include <WiFi.h>
#include <HTTPClient.h>
#include <time.h>
//RFID-----------------------------
#include <SPI.h>
#include <MFRC522.h>

#define SS_PIN 21
#define RST_PIN 22

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance.

const char *ssid = "Manu BG";
const char *password = "Manu@7795";

String getData, Link;
String CardID = "";

String URL = "http://192.168.9.7/rfidattendance/getdata.php";  //computer IP or the server domain

void setup() {
  Serial.begin(9600);
  SPI.begin();         // Init SPI bus
  mfrc522.PCD_Init();  // Init MFRC522 card
  connectToWiFi();
}

void loop() {
  if (!WiFi.isConnected()) {
    connectToWiFi();  //Retry to connect to Wi-Fi
  }

  //look for new card
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;  //got to start of loop if there is no card present
  }

  // Select one of the cards
  if (!mfrc522.PICC_ReadCardSerial()) {
    return;  //if read card serial(0) returns 1, the uid struct contians the ID of the read card.
  }

  for (byte i = 0; i < mfrc522.uid.size; i++) {
    CardID += mfrc522.uid.uidByte[i];
  }
  CardID.replace(" ", "");
  // Serial.println(CardID);
  SendCardID(CardID);
  CardID = "";
  delay(5000);
}

void SendCardID(String Card_uid) {
  Serial.println("Sending the Card ID");
  if (WiFi.isConnected()) {
    HTTPClient http;  //Declare object of class HTTPClient
    //GET Data
    getData = "?uid=" + String(Card_uid);  // Add the Card ID to the GET array in order to send it
    //GET methode
    Link = URL + getData;

    http.begin(Link);  //initiate HTTP request   //Specify content-type header

    int httpCode = http.GET();          //Send the request
    String payload = http.getString();  //Get the response payload

    Serial.println(httpCode);  //Print HTTP return code
    Serial.println(Card_uid);  //Print Card ID
    Serial.println(payload);   //Print request response payload
    http.end();                //Close connection
  }
}

void connectToWiFi() {
  WiFi.mode(WIFI_OFF);  //Prevents reconnection issue (taking too long to connect)
  delay(1000);
  WiFi.mode(WIFI_STA);
  Serial.print("Connecting to ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("Connected");
  delay(1000);
}
