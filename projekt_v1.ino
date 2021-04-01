#include <Wire.h> 
#include <SparkFunTMP102.h>
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>

TMP102 sensor0;

void setup() {
  Serial.begin(115200);
  Wire.begin();
  
  if(!sensor0.begin())
  {
    Serial.println("Nie mozna sie polaczyc z czujnikiem");
    while(1);
  }

  
  Serial.println("Polaczono z czujnikiem");  
  delay(100);
  sensor0.sleep(); 

  WiFi.mode(WIFI_OFF);
      delay(1000);
      WiFi.mode(WIFI_STA);                              //rozłączenie wszystkich połączeń zestawionych
      WiFi.begin("nazwa_sieci", "haslo");               //polaczenie do sieci
      
  while (WiFi.status() != WL_CONNECTED){
    Serial.println("Brak polaczenia");
    delay(100);
  }
  Serial.print("Nawiazano polaczenie");
  Serial.print(WiFi.localIP());   //wyswietlenie przyznanego adresu IP
  delay(1000);

}
 
void loop()
{
  sensor0.oneShot(1); 

  while(sensor0.oneShot() == 0); 

  double wartosc = sensor0.readTempC();   //wykonanie pomiaru temperatury
  Serial.print("Wartosc temperatury: ");
  Serial.println(wartosc);                //wyswietlenie wartosci pomiaru
  
  String temp = "temperatura=" + (String)wartosc;   //przygotowanie wartosci do metody POST
  Serial.println(temp);
  HTTPClient http;
  http.begin("http://192.168.1.160/projekt_telemed/wartosc_temp.php");     //okreslamy miejsce pliku, ktory powinien sie wykonac
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");    //okreslenie wykorzystania metody post
  http.POST(temp);   //wysylanie danej
  http.end();
  delay(300);

  sensor0.sleep(); //uspienie czujnika
  delay(299700);
}
