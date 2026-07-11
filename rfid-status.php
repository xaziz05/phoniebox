<?php
// rfid-status.php – kleine Live-Statusanzeige für den RFID-Leser
if (isset($_GET['check'])) {
    header('Content-Type: application/json');
    $state = trim(shell_exec('systemctl is-active phoniebox-rfid-reader.service 2>/dev/null'));
    echo json_encode(['ok' => ($state === 'active'), 'state' => ($state ?: 'unknown')]);
    exit;
}
?>
<!doctype html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>RFID-Leser Status</title>
<style>
  body{font-family:system-ui,sans-serif;background:#1c1c1c;color:#eee;margin:0;
       height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center}
  .dot{width:100px;height:100px;border-radius:50%;background:#666;margin-bottom:24px;
       transition:background .3s ease, box-shadow .3s ease}
  .ok{background:#22c55e;box-shadow:0 0 30px 8px rgba(34,197,94,.7);
      animation:pulse 1.6s ease-in-out infinite}
  .bad{background:#ef4444;box-shadow:0 0 30px 8px rgba(239,68,68,.7)}
  @keyframes pulse{0%,100%{transform:scale(1)}50%{transform:scale(1.08)}}
  .label{font-size:1.5rem;font-weight:700}
  .sub{color:#9aa0a6;margin-top:8px;font-size:.9rem}
  h1{font-size:1rem;color:#9aa0a6;font-weight:500;margin:0 0 40px}
</style>
</head>
<body>
  <h1>Phoniebox - RFID-Leser</h1>
  <div id="dot" class="dot"></div>
  <div id="label" class="label">Pruefe...</div>
  <div id="sub" class="sub"></div>
<script>
async function check(){
  const dot=document.getElementById('dot'),
        label=document.getElementById('label'),
        sub=document.getElementById('sub');
  try{
    const r=await fetch('rfid-status.php?check=1',{cache:'no-store'});
    const d=await r.json();
    if(d.ok){ dot.className='dot ok'; label.textContent='RFID-Leser laeuft einwandfrei'; }
    else    { dot.className='dot bad'; label.textContent='RFID-Leser reagiert nicht'; }
    sub.textContent='Status: '+d.state+' - aktualisiert '+new Date().toLocaleTimeString();
  }catch(e){
    dot.className='dot bad'; label.textContent='Statusseite nicht erreichbar';
  }
}
check();
setInterval(check,2000);
</script>
</body>
</html>
