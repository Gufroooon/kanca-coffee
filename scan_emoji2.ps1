$ErrorActionPreference = 'Stop'
$files = Get-ChildItem -Path "resources\views" -Recurse -Filter *.blade.php
# Emoji ranges (actual pictographs/emoji), excluding typographic symbols
$pattern = '[\uD83C-\uDBFF][\uDC00-\uDFFF]|\uD83D[\uDE00-\uDE4F]|\u2705|\u274C|\u2B50|\uFE0F'
foreach ($f in $files) {
    $lineNum = 0
    Get-Content $f.FullName -Encoding UTF8 | ForEach-Object {
        $lineNum++
        if ($_ -match $pattern) {
            $rel = $f.FullName.Replace('C:\Users\Farras\kanca-coffee\','')
            Write-Output ($rel + ':LINE' + $lineNum + ': ' + $_.Trim())
        }
    }
}
