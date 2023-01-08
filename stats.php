<?php
// Récupère l'utilisation de la mémoire
$memory_output = shell_exec("free -m | grep 'Mem'");
$memory_parts = explode(" ", preg_replace("/\s+/", " ", $memory_output));
$memory_total = $memory_parts[1];
$memory_used = $memory_parts[2];
$memory_usage = round(($memory_used / $memory_total) * 100, 2);

// Récupère l'utilisation du processeur
$cpu_output = shell_exec("top -bn2 | grep 'Cpu' | tail -n1");
$cpu_parts = explode(",", $cpu_output);
$cpu_usage = trim(explode(":", $cpu_parts[0])[1]);

// Récupère l'espace disque utilisé et disponible
$disk_output = shell_exec("df -h / | tail -n1");
$disk_parts = explode(" ", preg_replace("/\s+/", " ", $disk_output));
$disk_total = $disk_parts[1];
$disk_used = $disk_parts[2];
$disk_free = $disk_parts[3];

// Récupère le nombre de connexions actives à la base de données
$db_output = shell_exec("mysql -uroot -p -e 'SHOW PROCESSLIST' | wc -l");
$db_connections = intval($db_output) - 1;
?>

<!-- Affiche le panel de statistiques -->
<div id="stats-panel">
  <h2>Statistiques de la machine</h2>
  <ul>
    <li>Utilisation de la mémoire : <?php echo $memory_usage; ?> %</li>
    <li>Utilisation du processeur : <?php echo $cpu_usage; ?> %</li>
    <li>Espace disque utilisé : <?php echo $disk_used; ?></li>
    <li>Espace disque disponible : <?php echo $disk_free; ?></li>
    <li>Connexions actives à la base de données : <?php echo $db_connections; ?></li>
  </ul>
</div>
