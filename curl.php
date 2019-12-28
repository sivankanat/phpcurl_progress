<?php
if (isset($_POST)) {
    $url = $_POST["url"];
    CurlRun($url);
}
function CurlRun($url)
{
    $folder = "down/";
    if (!file_exists($folder)) {
        mkdir($folder, 777, true);
    }
    $fopen = fopen($folder . basename($url), "wb");
    $curl  = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL              => $url,
        CURLOPT_FILE             => $fopen,
        CURLOPT_RETURNTRANSFER   => true,
        CURLOPT_HEADER           => 0,
        CURLOPT_NOPROGRESS       => 0,
        CURLOPT_PROGRESSFUNCTION => 'Progress',
    ),
    );
    $res = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    fclose($fopen);
    if ($err) {
        echo $err;
    } elseif ($res) {
        echo "done.";
    }
} #curl($url)

function Progress($source, $downsize, $down, $upsize, $up)
{
    static $prev = 0;
    if ($downsize == 0) {
        $progress = 0;
    } else {
        $progress = round($down / $downsize * 100);
        if ($progress > $prev) {
            $prev = $progress;
            $fopen            = fopen('prog.txt', 'w+');
            fputs($fopen, "$progress\n");
            fclose($fopen);
        }
    }

} #Progress()
