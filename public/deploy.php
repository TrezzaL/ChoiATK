<?php
/**
 * deploy.php — Hook ekstraksi deployment. Dipanggil GitHub Actions.
 */
function envValue(string $key): ?string {
    $envPath = __DIR__ . '/../.env';
    if (!is_readable($envPath)) return null;
    foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;
        if (str_starts_with($line, $key . '=')) {
            return trim(substr($line, strlen($key) + 1), " \t\"'");
        }
    }
    return null;
}

header('Content-Type: text/plain; charset=utf-8');

$expectedToken = envValue('DEPLOY_TOKEN');
$providedToken = $_GET['token'] ?? '';

if (empty($expectedToken)) { http_response_code(500); exit('ERROR: DEPLOY_TOKEN belum diset di .env server.'); }
if (!is_string($providedToken) || !hash_equals($expectedToken, $providedToken)) { http_response_code(403); exit('ERROR: Token tidak valid.'); }

$zipPath     = __DIR__ . '/../deploy.zip';
$extractPath = realpath(__DIR__ . '/..');

if (!file_exists($zipPath)) { http_response_code(404); exit('ERROR: deploy.zip tidak ditemukan.'); }

$zip = new ZipArchive;
if ($zip->open($zipPath) !== true) { http_response_code(500); exit('ERROR: Gagal membuka deploy.zip.'); }
if (!$zip->extractTo($extractPath)) { $zip->close(); http_response_code(500); exit('ERROR: Gagal mengekstrak.'); }
$fileCount = $zip->numFiles;
$zip->close();
@unlink($zipPath);

// Bersihkan cache Laravel (WAJIB — agar perubahan kode & tampilan langsung terbaca)
$cacheGlobs = [
    __DIR__ . '/../bootstrap/cache/*.php',
    __DIR__ . '/../storage/framework/views/*.php',
    __DIR__ . '/../storage/framework/cache/data/*',
];
$cleared = 0;
foreach ($cacheGlobs as $pattern) {
    foreach (glob($pattern) ?: [] as $f) {
        if (is_file($f) && @unlink($f)) $cleared++;
    }
}

http_response_code(200);
echo 'OK: Deploy berhasil (' . $fileCount . ' file, ' . $cleared . ' cache dibersihkan) pada ' . date('Y-m-d H:i:s');
