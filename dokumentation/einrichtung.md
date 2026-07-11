# ⚙️ Einrichtung & nützliche Befehle

Diese Datei sammelt die wichtigsten Schritte und Terminal-Befehle rund um unsere
Phoniebox.

---

## Überblick der Software auf dem Pi

| Dienst | Aufgabe | Nützliche Befehle |
|--------|---------|-------------------|
| `mopidy` | Musik-Player (Wiedergabe) | `sudo systemctl status mopidy` |
| `phoniebox-rfid-reader.service` | liest die RFID-Karten | `sudo systemctl status phoniebox-rfid-reader.service` |
| `phoniebox-gpio-control.service` | Tasten/GPIO | `sudo systemctl status phoniebox-gpio-control.service` |

Der Player wird über `mpc` gesteuert (funktioniert auch mit Mopidy):

```bash
mpc status          # Was läuft gerade?
mpc play            # Wiedergabe starten
mpc pause           # Pause
mpc volume 90       # Lautstärke setzen (0-100)
mpc lsplaylists     # vorhandene Playlists anzeigen
mpc load musik      # Playlist "musik" laden
```

---

## Karte → Playlist testen (Swipe simulieren)

Man kann einen Karten-„Swipe" von Hand auslösen, ohne die Karte aufzulegen:

```bash
cd /home/pi/RPi-Jukebox-RFID/scripts
./rfid_trigger_play.sh --cardid=<KARTEN-ID>
mpc status
```

Die Karten-IDs sieht man live mit:

```bash
sudo journalctl -u phoniebox-rfid-reader.service -f
```

(→ Details in [`fehlerbehebung.md`](fehlerbehebung.md).)

---

## Messdaten aus dem Terminal auf GitHub hochladen

Diesen Ablauf nutzen wir, um z. B. Messwerte zu sichern.

**1. Einmalig – Git einrichten und Repo holen:**

```bash
git config --global user.name "DEIN-GITHUB-NAME"
git config --global user.email "DEINE-EMAIL"
cd ~
git clone https://github.com/xaziz05/phoniebox.git
cd phoniebox
```

**2. Messwerte in eine Datei schreiben** (Ausgabe eines Befehls speichern **und**
anzeigen):

```bash
DEIN_MESSBEFEHL | tee -a messdaten/messung.txt
```

Oder Werte von Hand eintragen:

```bash
cat >> messdaten/messung.txt << 'EOF'
Reaktionszeit: 0.018 Sekunden
EOF
```

**3. Hochladen:**

```bash
git add .
git commit -m "Neue Messdaten"
git push
```

> ⚠️ Git-Befehle immer **innerhalb** des Repo-Ordners (`~/phoniebox`) ausführen, sonst
> kommt „not a git repository". Beim ersten `git push` wird ein **Personal Access Token**
> als Passwort benötigt (siehe [`fehlerbehebung.md`](fehlerbehebung.md), Punkt 4).

---

## Wichtige Pfade

| Pfad | Bedeutung |
|------|-----------|
| `/home/pi/RPi-Jukebox-RFID/` | Installierte Phoniebox-Software (läuft) |
| `/home/pi/phoniebox/` | Dieses GitHub-Repo (Dokumentation) |
| `/etc/mopidy/mopidy.conf` | Konfiguration des Players (Audio-Ausgabe) |
| `/home/pi/RPi-Jukebox-RFID/scripts/` | Reader- und Steuer-Skripte |
