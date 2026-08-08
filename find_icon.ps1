$ErrorActionPreference = 'Stop'
$files = Get-ChildItem -Path "c:\Users\Farras\kanca-coffee\resources\views" -Recurse -Filter *.blade.php
foreach ($f in $files) {
    $lineNum = 0
    Get-Content $f.FullName -Encoding UTF8 | ForEach-Object {
        $lineNum++
        if ($_ -match '->icon|\.icon|data-lucide') {
            $rel = $f.FullName.Replace('C:\Users\Farras\kanca-coffee\','')
            Write-Output ($rel + ':LINE' + $lineNum + ': ' + $_.Trim())
        }
    }
}
