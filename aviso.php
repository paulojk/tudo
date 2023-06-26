<?php
if (file_exists(".ccaviso.php") != false) {
    $xoa = readline(
        "Chay cookies da nhap truoc do? (y/n) : "
    );
    if ($xoa == "n" or $xoa == "N") {
        unlink(".ccaviso.php");
    } elseif ($xoa == "y" or $xoa == "Y") {
        include ".ccaviso.php";
    }
}
if (file_exists(".ccaviso.php") != true) {
    $file = fopen(".ccaviso.php", "w");
    $cc = readline("Nhap cookie: ");
    $user = readline("Nhap user-agent: ");
    fwrite($file, "<?php\n");
    fwrite($file, "$" . "us='$user';\n");
    fwrite($file, "$" . "cookie='$cc';\n");
    fclose($file);
    include ".ccaviso.php";
}

$hd_av = [
    "sec-ch-ua-mobile:?1",
    "user-agent:$us",
    "accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
    "user-agent:$us",
    "sec-fetch-user:?1",
    "sec-fetch-dest:document",
    "cookie:$cookie",
];
$hd_post = [
    "Host:aviso.bz",
    "accept:application/json, text/javascript, */*; q=0.01",
    "content-type:application/x-www-form-urlencoded; charset=UTF-8",
    "x-requested-with:XMLHttpRequest",
    "sec-ch-ua-mobile:?1",
    "user-agent:$us",
    "sec-fetch-site:same-origin",
    "sec-fetch-mode:cors",
    "sec-fetch-dest:empty",
    "referer:https://aviso.bz/work-youtube",
    "cookie:$cookie",
];
$hd_nhan = [
    "Host:aviso.bz",
    "accept:application/json, text/javascript, */*; q=0.01",
    "content-type:application/x-www-form-urlencoded; charset=UTF-8",
    "x-requested-with:XMLHttpRequest",
    "sec-ch-ua-mobile:?1",
    "user-agent:$us",
    "sec-fetch-site:same-origin",
    "sec-fetch-mode:cors",
    "sec-fetch-dest:empty",
    "referer:https://skyhome.squarespace.com/",
    "cookie:$cookie",
];
error_reporting(0);
while (true) {
    while (true) {
        $mr = curl_init();
        curl_setopt_array($mr, [
            CURLOPT_PORT => "443",
            CURLOPT_URL => "https://aviso.bz/work-youtube",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTPHEADER => $hd_av,
        ]);
        $mr2 = curl_exec($mr);
        $get_httpcode = curl_getinfo($mr, CURLINFO_HTTP_CODE);
        curl_close($mr);
        if ($get_httpcode == 0) {
            echo "{$do}Mat Ket Noi Internet                 \r";
            break;
        } elseif ($get_httpcode == 302) {
            echo "{$do}Cookie die \n";
            unlink(".ccaviso.php");
            exit();
        }
		$user_html = explode('"', explode('id="user-block-info-username', $mr2)[1])[1];
		preg_match('/>(.*?)<\/span>/', $user_html, $matches);
		$username = $matches[1];
        $gethash = explode(
            ");",
            explode("funcjs['start_youtube'](", $mr2)[1]
        )[0];
        $hash = explode("',", explode("'", $gethash)[1])[0];
        if (explode('"', explode('<div id="start-ads-', $mr2)[1])[0] == true) {
            $id = explode('"', explode('<div id="start-ads-', $mr2)[1])[0];
            $mr = curl_init();
            curl_setopt_array($mr, [
                CURLOPT_PORT => "443",
                CURLOPT_URL => "https://aviso.bz/ajax/earnings/ajax-youtube.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>
                    "id=" .
                    $id .
                    "&hash=" .
                    $hash .
                    "&func=ads-start&user_response=&count_captcha_subscribe=&checkStepOneCaptchaSubscribe=false",
                CURLOPT_HTTPHEADER => $hd_post,
            ]);
            $mr2 = curl_exec($mr);
            curl_close($mr);
            $json = json_decode($mr2, true);
            $getlink = explode(
                '"',
                explode('data-meta="', $json["html"])[1]
            )[0];
            $id_video = explode("&", explode("video_id=", $json["html"])[1])[0];
            $time_video = explode(
                '"',
                explode('data-timer="', $json["html"])[1]
            )[0];
            $hash_video = explode('"', explode("hash=", $json["html"])[1])[0];
            $report_id = explode(
                "&",
                explode("report_id=", $json["html"])[1]
            )[0];
            $tm = 100000;
            for ($time = $time_video; $time--; $time - 1) {
                #echo "$time   \r";
                #usleep($tm);
				#sleep(1);
            }
            $mr = curl_init();
            curl_setopt_array($mr, [
                CURLOPT_PORT => "443",
                CURLOPT_URL => "https://aviso.bz/ajax/earnings/ajax-youtube-external.php",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS =>
                    "hash=" .
                    $hash_video .
                    "&report_id=" .
                    $report_id .
                    "&task_id=" .
                    $id .
                    "&timer=" .
                    $time_video .
                    "&player_time=" .
                    $time_video .
                    ".190681877929688&video_id=" .
                    $id_video .
                    "&stage=2",
                CURLOPT_HTTPHEADER => $hd_nhan,
            ]);
            $mr2 = curl_exec($mr);
            curl_close($mr);
            $nhan_tien = explode("<", explode("<b>", $mr2)[1])[0];
            if ($nhan_tien == true) {
                $mr = curl_init();
                curl_setopt_array($mr, [
                    CURLOPT_PORT => "443",
                    CURLOPT_URL => "https://aviso.bz/work-youtube",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_HTTPHEADER => $hd_av,
                ]);
                $mr2 = curl_exec($mr);
                curl_close($mr);
                $sdnhan = explode(
                    " ",
                    explode('id="new-money-ballans">', $mr2)[1]
                )[0];
				$rate_raw = explode('"', explode('id="reyt-user-block"', $mr2)[1])[5];
				preg_match('/\d+(\.\d+)?/', $rate_raw, $matches);
				$rate = $matches[0];
                date_default_timezone_set("Asia/Ho_Chi_Minh");
                $timetc = date("d/m/Y H:i:s");;
                echo "[$username]  ($timetc) | + $nhan_tien RUB | BALANCE : $sdnhan | RATE: $rate\n";
            } else {
                echo "ERROR => $id           		\r";
                sleep(1);
            }
        } else {
			date_default_timezone_set("Asia/Ho_Chi_Minh");
            $timetc = date("d/m/Y H:i:s");
            echo "TIME : $timetc => Het job! Nghi 10 phut!\r";
            sleep(600);
        }
    }
}
?>
