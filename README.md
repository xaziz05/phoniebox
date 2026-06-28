Phoniebox – RFID-basierte Musikbox mit Raspberry Pi

Einführung

Dieses Repository dokumentiert unser Projekt im Modul App Development. Ziel des Projekts ist der Aufbau und die Erweiterung einer sogenannten Phoniebox. Dabei handelt es sich um eine Musikbox, die über RFID-Karten gesteuert werden kann.

Die Grundidee ist, dass eine RFID-Karte oder ein RFID-Chip an einen Reader gehalten wird und dadurch ein bestimmter Audioinhalt abgespielt wird. Dadurch kann die Musikbox ohne klassische Bedienoberfläche genutzt werden und eignet sich zum Beispiel für Kinder, Lerninhalte oder eine einfache Mediensteuerung.

Projektgrundlage

Als technische Grundlage verwenden wir ein bestehendes Open-Source-Projekt zur Phoniebox / RPi-Jukebox-RFID:

https://github.com/MiczFlor/RPi-Jukebox-RFID

Die ursprüngliche Software wurde nicht vollständig von uns selbst entwickelt, sondern dient als Basis für unsere eigene Umsetzung. Unser Fokus liegt darauf, die vorhandene Software auf unserer Hardware lauffähig zu machen, die Komponenten zu verstehen, zu konfigurieren und mögliche Erweiterungen für unser Projekt zu entwickeln.

Projektziel

Das Ziel unseres Projekts ist es, eine funktionsfähige RFID-Musikbox mit einem Raspberry Pi umzusetzen.

Dabei sollen folgende Punkte erreicht werden:

* Einrichtung eines Raspberry Pi als zentrale Steuereinheit
* Installation und Konfiguration der Phoniebox-Software
* Anschluss und Test eines RFID-/NFC-Readers
* Steuerung von Audioinhalten über RFID-Karten
* Test der Audioausgabe über Lautsprecher
* Dokumentation der Einrichtung, Probleme und Lösungsansätze
* Entwicklung und Beschreibung möglicher Erweiterungen für die bestehende Software

Hardware

Für das Projekt werden folgende Komponenten verwendet:

* Raspberry Pi 3
* RFID-/NFC-Reader, z. B. PN532
* RFID-Karten oder RFID-Chips
* Lautsprecher über Klinke oder Bluetooth
* Netzteil und Verbindungskabel

Software

Verwendete Software und Tools:

* Raspberry Pi OS Lite
* Phoniebox / RPi-Jukebox-RFID als Basissoftware
* GitHub zur Versionierung und Dokumentation
* Terminal zur Einrichtung und Konfiguration
* VS Code / GitHub-Weboberfläche zur Bearbeitung des Repositorys

Eigener Projektanteil

Da die Phoniebox-Software bereits als Open-Source-Projekt existiert, besteht unser eigener Projektanteil vor allem aus der praktischen Umsetzung, Konfiguration, Analyse und Dokumentation.

Unsere bisherigen Arbeitsschritte:

1. Recherche zur bestehenden Phoniebox-Software
2. Download und Einrichtung der Software auf dem Raspberry Pi
3. Anschluss und Test des RFID-/NFC-Readers
4. Prüfung der Hardwareverbindung
5. Test der Audioausgabe
6. Analyse von Problemen bei Bluetooth und Tonwiedergabe
7. Dokumentation wichtiger Terminal-Befehle
8. Strukturierung des GitHub-Repositorys
9. Planung möglicher Erweiterungen für das Projekt

Repository-Struktur

Die Ordnerstruktur enthält einerseits Bestandteile der verwendeten Phoniebox-Basissoftware und andererseits unsere eigene Projektdokumentation.

.
├── README.md
├── components/
├── docs/
├── htdocs/
├── logs/
├── misc/
├── playlists/
├── scripts/
├── settings/
├── shared/
├── requirements.txt
├── packages.txt
└── ...

Wichtige Bereiche:

Bereich	Bedeutung
README.md	Übersicht und Beschreibung unseres Projekts
docs/	Dokumentation zur Einrichtung, Hardware und Fehlersuche
scripts/	Skripte der Phoniebox-Software
settings/	Konfigurationsdateien
playlists/	Bereich für Audioinhalte bzw. Zuordnungen
requirements.txt	benötigte Software-Abhängigkeiten
packages.txt	benötigte Systempakete

Aktueller Stand

Aktueller Projektstand:

* Raspberry Pi wurde eingerichtet
* Phoniebox-Software wurde heruntergeladen und installiert
* RFID-/NFC-Reader wurde angeschlossen
* Reader wurde vom System erkannt
* Audioausgabe wurde getestet
* Bluetooth-Verbindung wurde getestet
* Probleme bei der Audioausgabe wurden analysiert
* GitHub-Repository wurde erstellt und strukturiert

Geplante Erweiterungen

Im weiteren Projektverlauf sollen mögliche Erweiterungen geprüft und umgesetzt werden. Denkbare Erweiterungen sind:

* bessere Dokumentation der RFID-Karten-Zuordnung
* eigene Start-/Stop-Funktionen über RFID-Karten
* Lautstärkesteuerung über spezielle Karten
* übersichtlichere Projektstruktur
* genauere Fehlerdokumentation
* Erweiterung der README und zusätzlicher Dokumentationsdateien
* Test verschiedener Audioausgaben, z. B. Klinke und Bluetooth

Versionierung

Für die Versionierung verwenden wir GitHub. Änderungen am Projekt werden über Commits dokumentiert. Dadurch ist nachvollziehbar, welche Dateien verändert wurden und welche Arbeitsschritte im Projekt durchgeführt wurden.

Beispiele für sinnvolle Commit-Nachrichten:

docs: README mit Projektbeschreibung aktualisiert
docs: Hardware-Dokumentation ergänzt
docs: Fehlersuche dokumentiert
config: RFID-Reader-Einrichtung beschrieben

Lizenz und Hinweise

Dieses Projekt basiert auf einer bestehenden Open-Source-Software zur Phoniebox / RPi-Jukebox-RFID. Die ursprüngliche Software wurde nicht von uns entwickelt. Wir verwenden sie als Grundlage für unser App-Development-Projekt und dokumentieren unsere eigene Einrichtung, Konfiguration und Erweiterungsideen.

Projektteam

* Yassin
* Aziz
* Melina

Modul: App Development
Hochschule Niederrhein
Sommersemester 2026
