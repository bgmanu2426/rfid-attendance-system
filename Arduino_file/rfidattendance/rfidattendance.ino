#include <WiFi.h>
#include <HTTPClient.h>
#include <SPI.h>
#include <MFRC522.h>
#include <SSD1306Wire.h>
#include <Wire.h>

#define SS_PIN 21
#define RST_PIN 5
#define Relay_Pin 15

MFRC522 mfrc522(SS_PIN, RST_PIN);  // Create MFRC522 instance.

const char *ssid = "Manu BG";
const char *password = "Manu@7795";

String getData, Link;
String URL = "http://3.234.15.228/getdata.php";  //computer IP or the server domain

#define OLED_RESET -1  // Reset pin because OLED dosent have a default reset PIN
#define OLED_SDA 4
#define OLED_SCL 22
SSD1306Wire display(0x3C, OLED_SDA, OLED_SCL);

void setup() {
  Serial.begin(9600);
  SPI.begin();         // Init SPI bus
  mfrc522.PCD_Init();  // Init MFRC522 card
  display.init();
  display.flipScreenVertically();
  connectToWiFi();
}

void loop() {
  if (!WiFi.isConnected()) {
    connectToWiFi();  //Retry to connect to Wi-Fi
  }

  display.clear();
  display.setFont(ArialMT_Plain_16);
  display.setTextAlignment(TEXT_ALIGN_LEFT);
  display.drawString(10, 10, "Scan Your Card");  //  adds to buffer
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

  CardID.replace(" ", "");
  SendCardID(CardID);
  delay(5000);
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
    Link = URL + getData;                  //GET method
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