#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <MicroGear.h>
#include <ArduinoJson.h>
const char* ssid     = "Sai";  
const char* password = "1234567890"; 

const char* host = "https://jarvisled.herokuapp.com/bot.php"; // ตัวอย่างเช่น http://ชื่อappของคุณ.herokuapp.com/bot.php https://jarvisled.herokuapp.com/
#define APPID   "JARVISLED" // ชื่อ APP ID ใน NETPIE
#define KEY     "6cZImaH2psgv9JT" // key ของ Device Key
#define SECRET  "CrOxPF9NXDp8c1JhhcYUVQY5k" // Secret ของ Device Key

#define ALIAS   "NODEMCU"  // ตั้งให้ตรงกับชื่อ อุปกรณ์ของ Device Key ใน NETPIE
#define TargetWeb "switch"  

WiFiClient client;
String uid = "";
int timer = 0;
MicroGear microgear(client);

void onMsghandler(char *topic, uint8_t* msg, unsigned int msglen) { //
  Serial.print("Incoming message -->");
  msg[msglen] = '\0';
  Serial.println((char *)msg);
  String msgLINE = (char *)msg;
  if ( msgLINE == "ON" || msgLINE == "On" || msgLINE == "on" ) {
  send_json("เปิดไฟ เรียบร้อยแล้ว");
    digitalWrite(D0, HIGH);         // LED on
  }
  else if ( msgLINE == "OFF" || msgLINE == "Off"  || msgLINE == "off" ) {
  send_json("ปิดไฟ เรียบร้อยแล้ว");
    digitalWrite(D0, LOW);          // LED off
  }
}

void onConnected(char *attribute, uint8_t* msg, unsigned int msglen) {
  Serial.println("Connecting to NETPIE...");
  microgear.setName(ALIAS);
}


void setup() {
  microgear.setEEPROMOffset(3000);
  microgear.on(MESSAGE, onMsghandler);
  microgear.on(CONNECTED, onConnected);

  Serial.begin(115200);
  Serial.println("Starting...");

  pinMode(D0, OUTPUT);

  if (WiFi.begin(ssid, password)) {//ทำการ Connect SSID และ Pass
    while (WiFi.status() != WL_CONNECTED) {// ถ้าไม่สามารถเชื่อมต่อได้
    //Serial.println("Connectiong...  ");  // ทำการ Print "Connectiong..." ทุก 1000ms
      delay(500);
      //Serial.printf("Connection Status: %d\n", WiFi.status()); // แสดงสถานะการเชื่อมต่อ
      Serial.print(".");
    }
  }
// จะหลุดออกจาก while ก็ต่อเมือ Connected เรียบร้อย
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP()); // ทำการ Print IP ที่ได้รับมาจาก 

  microgear.init(KEY, SECRET, ALIAS);
  microgear.connect(APPID);
}

void send_json(String data) {
  StaticJsonBuffer<300> JSONbuffer;   //Declaring static JSON buffer
  JsonObject& JSONencoder = JSONbuffer.createObject();

  JSONencoder["ESP"] = data;

  JsonArray& values = JSONencoder.createNestedArray("values"); //JSON array
  values.add(20); //Add value to array
  values.add(21); //Add value to array
  values.add(23); //Add value to array


  char JSONmessageBuffer[300];
  JSONencoder.prettyPrintTo(JSONmessageBuffer, sizeof(JSONmessageBuffer));
  Serial.println(JSONmessageBuffer);

  HTTPClient http;    //Declare object of class HTTPClient

  http.begin(host);      //Specify request destination
  http.addHeader("Content-Type", "application/json");  //Specify content-type header

  int httpCode = http.POST(JSONmessageBuffer);   //Send the request
  String payload = http.getString();                                        //Get the response payload

  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);    //Print request response payload

  http.end();  //Close connection
}
void loop() {
  if (microgear.connected()) {
    Serial.println("Connected to NETPIE !");
    microgear.loop();
    timer = 0;
  }
  else {
    Serial.println("connection lost, reconnect...");
    if (timer >= 5000) {
      microgear.connect(APPID);
      timer = 0;
    }
    else timer += 100;
  }
  delay(100);
}
