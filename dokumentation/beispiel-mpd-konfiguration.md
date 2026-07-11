# 🔊 Beispiel: Audio-/MPD-Konfiguration

Kurze Referenz zur Audio-Konfiguration der Phoniebox.

---

## Klassische Phoniebox (MPD)

Beim Einrichten der klassischen Phoniebox wird eine `mpd.conf` aus einer Vorlage erzeugt
und mit den gewählten Werten (Audio-Interface, Musikordner) gefüllt. Vereinfacht sieht
das so aus:

```bash
mpd_conf="/etc/mpd.conf"

# MPD-Dienst vorbereiten
sudo systemctl enable mpd
sudo systemctl stop mpd

# Vorlage kopieren
sudo cp "${jukebox_dir}/misc/sampleconfigs/mpd.conf.sample" "${mpd_conf}"

# Platzhalter in der Vorlage durch die echten Werte ersetzen
sudo sed -i "s|%AUDIOiFace%|${AUDIOiFace}|" "${mpd_conf}"
sudo sed -i "s|%DIRaudioFolders%|${DIRaudioFolders}|" "${mpd_conf}"
```

Ein MPD-Audio-Ausgang wird in der `mpd.conf` als Block definiert:

```ini
audio_output {
    type    "alsa"
    name    "My ALSA Device"
    device  "default"
    mixer_type "software"
}
```

---

## Unsere Phoniebox (Mopidy + PipeWire/Bluetooth)

Auf unserem Pi läuft **Mopidy** statt MPD, und der Ton läuft über **PipeWire**. Für die
Ausgabe über die **Bluetooth-Box** ist in `/etc/mopidy/mopidy.conf` entscheidend:

```ini
[audio]
output = pulsesink
```

Wichtig: `pulsesink` (nicht `alsasink`), damit der Ton über PipeWire läuft und die
Bluetooth-Box erreichen kann. Die vollständige Erklärung und alle nötigen Schritte
stehen in [`fehlerbehebung.md`](fehlerbehebung.md), Punkt 1.
