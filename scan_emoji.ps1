$files = Get-ChildItem -Path "resources\views" -Recurse -Filter *.blade.php
$pattern = '[\u2600-\u27BF\u2B00-\u2BFF\u1F000-\u1FAFF\uFE0F\u2190-\u21FF\u2700-\u27BF]'
foreach ($f in $files) {
    $lineNum = 0
    Get-Content $f.FullName | ForEach-Object {
        $lineNum++
        if ($_ -match $pattern) {
            $rel = $f.FullName.Replace('C:\Users\Farras\kanca-coffee\','')
            Write-Output ($rel + ':LINE' + $lineNum + ': ' + $_.Trim())
        }
    }
}

