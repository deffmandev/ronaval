#include "WiFi.h"
#include <HTTPClient.h>


#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SH110X.h>

#include <OneWire.h>
#include <DallasTemperature.h>


#include "FS.h"
#include "SD.h"
#include "SPI.h"

const char* ssid     = "";
const char* password = ""; 

String server = "https://alize38.fr/ronaval/in.php";  
String FileName="/test.txt";

#define SENSOR_PIN 13
#define SCREEN_WIDTH 128 
#define SCREEN_HEIGHT 64
#define i2c_Address 0x3c
#define OLED_RESET -1   

Adafruit_SH1106G oled = Adafruit_SH1106G(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);
OneWire oneWire(SENSOR_PIN);         // setup a oneWire instance
DallasTemperature DS18B20(&oneWire); // pass oneWire to DallasTemperature library
HTTPClient http;


int numberOfDevices;

String temperature;
String Datafile;


void setup() 
{
  //Serial com -->usb
    Serial.begin(115200);

  //Afficher
  oled.begin(i2c_Address, true); 
  delay(200);
  oled.clearDisplay();
  oled.setTextSize(1);    
  oled.setTextColor(SH110X_WHITE);
  oled.setCursor(5, 5);
  oled.println(F("RONAVAL")); 
  oled.display();

  //Carte SD Detecte
 if(!SD.begin()){
        Serial.println("Erreur Card SD");
        oled.setTextSize(1);    
        oled.println("Erreur Card SD"); 
        oled.display();
        return;
    }
    uint8_t cardType = SD.cardType();

    if(cardType == CARD_NONE){
        Serial.println("No SD card attached");
        oled.setTextSize(1);    
        oled.println("Erreur Card SD"); 
        oled.display();
        return;
    }
    uint64_t cardSize = SD.cardSize() / (1024 * 1024);
    Serial.printf("SD Card Size: %lluMB\n", cardSize);
    oled.println(cardSize); 
    oled.display();

    DS18B20.begin(); 


  numberOfDevices = DS18B20.getDeviceCount();
  DS18B20.setResolution(12);
  oled.setTextSize(1);    
  oled.print(numberOfDevices); 
  oled.display();
 

   WiFi.mode(WIFI_STA);
  WiFi.begin(ssid, password);
  while (WiFi.waitForConnectResult() != WL_CONNECTED) {
    Serial.println("Connection Failed! Rebooting...");
    delay(5000);
  ESP.restart();
  }
  
  Serial.print("Connected to ");
  Serial.println(ssid);

  oled.print("  IP:"); 
  oled.print(WiFi.localIP()); 
  oled.display();

  Serial.println("Connection au serveur");
  Serial.println(server);
  http.begin(server);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
}

void appendFile(fs::FS &fs, String path, String message){

    File file = fs.open(path, FILE_APPEND);
    if(!file)
      {
        Serial.println("Erreur d'ajout data");
        return;
      }
    if(file.print(message))
      {
      } 
      else 
      {
        Serial.println("Append erreur");
      }
    file.close();

      //connection au serveur
  
}

String explode(const String& input, char separator, int index) {
    int partIndex = 0;
    int start = 0;
  
    for (int i = 0; i <= input.length(); i++) {
      if (i == input.length() || input.charAt(i) == separator) {
        partIndex++;
        if (partIndex - 1 == index) {
          return input.substring(start, i);
        }
        start = i + 1;
      }
    }
    return ""; 
  }


void loop() {

  oled.setTextSize(1);    
  oled.fillRect(0, 30, 128, 64, 0);
  oled.setCursor(0, 30);
  DS18B20.requestTemperatures();             // send the command to get temperatures

  Datafile="";

  for (int j=0; j<numberOfDevices;j++)
  {
  float tempCelsius = DS18B20.getTempCByIndex(j);  // read temperature in Celsius

  temperature  = String(tempCelsius, 1);
  temperature += char(247) + String("C");

  oled.print(temperature);
  oled.print(" ");

  if (j>0) Datafile+=",";
    Datafile+=String(tempCelsius,1);
  }


  Serial.println(Datafile);
  Serial.println("  ");

                appendFile(SD, FileName, Datafile+="\n");

  oled.display();

  
//Envoie Au serveurs
 
  int httpCode = http.POST("test="+String(Datafile));

  if (httpCode > 0) {
    if (httpCode == HTTP_CODE_OK) 
    {
      String payload = http.getString();
      Serial.println(payload);
    } 
    else 
    {
      Serial.printf("[HTTP] GET... code: %d\n", httpCode);
    }
    } 
    else 
    {
      Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }

  //http.end();

delay(15000);

    
String preloy="84.89.41.77,24/05/2066,18:44";
String date = explode(preloy, ',', 1); // Returns "test"

Serial.println(date);
}
