# 🛠️ Fehlerbehebung – Probleme & Lösungen

Diese Datei sammelt die Probleme, die während des Projekts aufgetreten sind, und wie wir
sie gelöst haben. So sind die Schritte für uns (und andere) nachvollziehbar.

---

## 1. Bluetooth-Box verbunden, aber es kommt kein Ton

### Symptom
Die Bluetooth-Box (JBL Flip 6) war laut `bluetoothctl` verbunden, beim Auflegen einer
Karte lief die Musik laut Player (`mpc status` zeigte `[playing]`), es kam aber **kein Ton**
aus der Box.

### Ursache
Auf unserem Pi läuft **Mopidy** (nicht das klassische MPD), und der Ton läuft über
**PipeWire/PulseAudio**. In der Datei `/etc/mopidy/mopidy.conf` war aber eingestellt:

```ini
output = alsasink
```

`alsasink` schickt den Ton **direkt an die interne Soundkarte** und damit an PipeWire –
und somit auch an der Bluetooth-Box – **vorbei**. Deshalb tauchte die Wiedergabe gar nicht
erst in der PipeWire-Ausgabeliste (`pactl list sink-inputs`) auf.

Zusätzlich lief Mopidy als eigener Benutzer `mopidy`, der keinen Zugriff auf die
PipeWire-Sitzung des Benutzers `pi` (und damit auf die Bluetooth-Box) hatte.

### Lösung

Bluetooth-Box als Ausgang finden (Name merken, z. B. `bluez_output.2C_FD_B4_8D_3C_BA.1`):

```bash
pactl list sinks short
```

Mopidy auf PipeWire-Ausgabe umstellen:

```bash
sudo sed -i 's/^output = alsasink/output = pulsesink/' /etc/mopidy/mopidy.conf
```

Mopidy im Ton-Kontext von Benutzer `pi` laufen lassen (damit es die Box „sieht"):

```bash
PI_UID=$(id -u)
sudo mkdir -p /etc/systemd/system/mopidy.service.d
printf '[Service]\nUser=pi\nGroup=pi\nEnvironment=XDG_RUNTIME_DIR=/run/user/%s\nEnvironment=PULSE_SERVER=unix:/run/user/%s/pulse/native\n' "$PI_UID" "$PI_UID" | sudo tee /etc/systemd/system/mopidy.service.d/override.conf
```

Rechte anpassen, damit Benutzer `pi` die Konfiguration lesen und Daten schreiben darf:

```bash
sudo chown root:pi /etc/mopidy/mopidy.conf
sudo chmod 640 /etc/mopidy/mopidy.conf
sudo chown -R pi:pi /var/lib/mopidy /var/cache/mopidy
```

Bluetooth-Box dauerhaft als Standard-Ausgang setzen und die Ton-Sitzung auch ohne Login
aktiv halten:

```bash
pactl set-default-sink bluez_output.2C_FD_B4_8D_3C_BA.1
sudo loginctl enable-linger pi
```

Dienste neu laden und Mopidy neu starten:

```bash
sudo systemctl daemon-reload
sudo systemctl restart mopidy
```

### Kontrolle
Musik starten und prüfen, ob der Ton wirklich an der Box ankommt:

```bash
mpc play
pactl list sink-inputs
```

Erfolgreich, wenn bei `sink-inputs` ein Eintrag mit
`application.name = "Mopidy"` und `target.object = "bluez_output...."` erscheint.

---

## 2. RFID-Reader liest plötzlich keine Karten mehr

### Symptom
Der Reader hatte vorher Karten erkannt (im Log stand `Trigger Play Cardid=...`),
danach kam beim Auflegen **keine neue Zeile** mehr – obwohl der Dienst als
`active (running)` angezeigt wurde.

### Ursache
Der Reader-Prozess hatte sich „aufgehängt".

### Lösung

```bash
sudo systemctl restart phoniebox-rfid-reader.service
```

### Live prüfen, was der Reader erkennt

```bash
sudo journalctl -u phoniebox-rfid-reader.service -f
```

Dann Karte auflegen – es sollte eine Zeile `Trigger Play Cardid=<Nummer>` erscheinen.
Beenden mit `Strg+C`.

> ⚠️ Beim mehrfachen Auflegen **derselben** Karte gibt es eine kurze Sperre
> (Zweit-Auflege-Pause). Zwischen zwei Versuchen mit derselben Karte ein paar Sekunden
> warten.

### Reader direkt im Vordergrund testen (zeigt auch Fehlermeldungen)

```bash
sudo systemctl stop phoniebox-rfid-reader.service
cd /home/pi/RPi-Jukebox-RFID/scripts
python3 daemon_rfid_reader.py
# Karte auflegen -> ID oder Fehler erscheint, danach Strg+C
sudo systemctl start phoniebox-rfid-reader.service
```

---

## 3. Audio zwischen Lautsprecher und Bluetooth umschalten

Aktuelle Ausgänge des Players anzeigen:

```bash
mpc outputs
```

Verfügbare PipeWire-Ausgänge (Sinks) anzeigen:

```bash
pactl list sinks short
```

Bluetooth-Box als Standard-Ausgang setzen:

```bash
pactl set-default-sink bluez_output.2C_FD_B4_8D_3C_BA.1
```

Lautstärke des Players setzen (0–100):

```bash
mpc volume 90
```

---

## 4. `git push` scheitert mit „Authentication failed"

GitHub akzeptiert seit 2021 **kein Passwort** mehr für Git-Operationen. Stattdessen wird
ein **Personal Access Token** benötigt:

1. Token erstellen unter <https://github.com/settings/tokens/new?scopes=repo>
   (Häkchen bei `repo` setzen, Token kopieren).
2. Beim `git push` als **Passwort** den Token einfügen (Benutzername = GitHub-Name).
3. Damit der Token gespeichert wird und man ihn nicht jedes Mal eingeben muss:

```bash
git config --global credential.helper store
```
