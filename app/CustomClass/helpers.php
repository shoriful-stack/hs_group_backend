<?php

use App\Models\Branch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;


if (!function_exists('get_first_word')) {
    function get_first_word($name)
    {
        preg_match('/(?:\w+\. )?(\w+).*?(\w+)(?: \w+\.)?$/', $name, $result);
        return strtoupper($result[1][0] . $result[2][0]);
    }
}

if (!function_exists('rand_secure')) {
    function rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int)($log / 8) + 1; // length in bytes
        $bits = (int)$log + 1; // length in bits
        $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }
}

if (!function_exists('get_token')) {
    function get_token($length)
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[rand_secure(0, $max - 1)];
        }

        return $token;
    }
}
if (!function_exists('getIp')) {
    function getIp()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }
}


if (!function_exists('get_Client_Ip_adr')) {
    function get_Client_Ip_adr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        $response = \Illuminate\Support\Facades\Http::get('https://api.ipify.org/?format=json');
        if ($response->successful()) {
            $getIp = $response->json();
            return $getIp['ip'];
        }
        return '207.180.249.59';
    }
}


function getHourName($hour)
{
    if ($hour == 0) {
        $hour = '12:00 AM';
    } elseif ($hour == 1) {
        $hour = '01:00 AM';
    } elseif ($hour == 2) {
        $hour = '02:00 AM';
    } elseif ($hour == 2) {
        $hour = '02:00 AM';
    } elseif ($hour == 3) {
        $hour = '03:00 AM';
    } elseif ($hour == 4) {
        $hour = '04:00 AM';
    } elseif ($hour == 5) {
        $hour = '05:00 AM';
    } elseif ($hour == 6) {
        $hour = '06:00 AM';
    } elseif ($hour == 7) {
        $hour = '07:00 AM';
    } elseif ($hour == 8) {
        $hour = '08:00 AM';
    } elseif ($hour == 9) {
        $hour = '09:00 AM';
    } elseif ($hour == 10) {
        $hour = '10:00 AM';
    } elseif ($hour == 11) {
        $hour = '11:00 AM';
    } elseif ($hour == 12) {
        $hour = '12:00 PM';
    } elseif ($hour == 13) {
        $hour = '01:00 PM';
    } elseif ($hour == 14) {
        $hour = '02:00 PM';
    } elseif ($hour == 15) {
        $hour = '03:00 PM';
    } elseif ($hour == 16) {
        $hour = '04:00 PM';
    } elseif ($hour == 17) {
        $hour = '05:00 PM';
    } elseif ($hour == 18) {
        $hour = '06:00 PM';
    } elseif ($hour == 19) {
        $hour = '07:00 PM';
    } elseif ($hour == 20) {
        $hour = '08:00 PM';
    } elseif ($hour == 21) {
        $hour = '09:00 PM';
    } elseif ($hour == 22) {
        $hour = '10:00 PM';
    } elseif ($hour == 23) {
        $hour = '11:00 PM';
    }
    return $hour;
}

function getMonth($index)
{

    $value = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'Jun',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );
    return @$value[$index];
}

function getMonthSort($index)
{

    $value = array(
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec'
    );
    return @$value[$index];
}

function monthList()
{
    return [
        [
            'id' => '01',
            'sort_name' => 'JAN',
            'full_name' => 'January',
        ],
        [
            'id' => '02',
            'sort_name' => 'FEB',
            'full_name' => 'February',
        ],
        [
            'id' => '03',
            'sort_name' => 'MAR',
            'full_name' => 'March',
        ],
        [
            'id' => '04',
            'sort_name' => 'APR',
            'full_name' => 'April',
        ],
        [
            'id' => '05',
            'sort_name' => 'MAY',
            'full_name' => 'May',
        ],
        [
            'id' => '06',
            'sort_name' => 'JUN',
            'full_name' => 'Jun',
        ],
        [
            'id' => '07',
            'sort_name' => 'JULY',
            'full_name' => 'July',
        ],
        [
            'id' => '08',
            'sort_name' => 'AUG',
            'full_name' => 'August',
        ],
        [
            'id' => '09',
            'sort_name' => 'SEP',
            'full_name' => 'September',
        ],
        [
            'id' => '10',
            'sort_name' => 'OCT',
            'full_name' => 'October',
        ],
        [
            'id' => '11',
            'sort_name' => 'NOV',
            'full_name' => 'November',
        ],
        [
            'id' => '12',
            'sort_name' => 'DEC',
            'full_name' => 'December',
        ],
    ];
}

function dateRangeArray($strDateFrom, $strDateTo)
{

    $aryRange = array();
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}



function strigToBinary($string)
{
    $characters = str_split($string);

    $binary = [];
    foreach ($characters as $character) {
        $data = unpack('H*', $character);
        $binary[] = base_convert($data[1], 16, 2);
    }

    return implode(' ', $binary);
}

function binaryToString($binary)
{
    $binaries = explode(' ', $binary);

    $string = null;
    foreach ($binaries as $binary) {
        $string .= pack('H*', dechex(bindec($binary)));
    }

    return $string;
}



if (!function_exists('send_push_notification')) {
    function send_push_notification($firebaseToken, $request)
    {
        $SERVER_API_KEY = env('FIREBASE_SERVER_KEY');
        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request['title'],
                "body" => $request['body'],
                "icon" => '/logo/',
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $server_output = curl_exec($ch);
        curl_close($ch);
        Log::alert($server_output);
    }
}

if (!function_exists('folder_size')) {
    function folder_size()
    {
        $file_size = 0;

        foreach (\Illuminate\Support\Facades\File::allFiles(public_path('uploads')) as $file) {
            $file_size += $file->getSize();
        }
        echo $file_size;
        //  echo $file_size = number_format($file_size / 1048576, 2);
    }
}

if (!function_exists('formatSize')) {
    function formatSize($bytes)
    {

        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;
        if (($bytes >= 0) && ($bytes < $kb)) {
            return ceil($bytes / $kb) . ' KB';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb) . ' TB';
        }
    }
}
if (!function_exists('folderSize')) {
    function folderSize($dir)
    {
        $total_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach ($dir_array as $key => $filename) {
            if ($filename != ".." && $filename != ".") {
                if (is_dir($dir . "/" . $filename)) {
                    $new_foldersize = foldersize($dir . "/" . $filename);
                    $total_size = $total_size + $new_foldersize;
                } else if (is_file($dir . "/" . $filename)) {
                    $total_size = $total_size + filesize($dir . "/" . $filename);
                    $count++;
                }
            }
        }
        return $total_size;
    }
}

if (!function_exists('folder_files')) {
    function folder_files($dir)
    {
        $filecount = 0;
        $files = \Illuminate\Support\Facades\File::allFiles($dir);
        if (!isset($files)) {
            return $filecount;
        }

        if ($files !== false) {
            $filecount = count($files);
        }
        return $filecount;
    }
}

if (!function_exists('removeImages')) {
    function removeImages($dir)
    {
        \Illuminate\Support\Facades\File::cleanDirectory($dir);
        return back();
    }
}

if (!function_exists('removeLastFiles')) {
    function removeLastFiles($dir)
    {
        \Illuminate\Support\Facades\File::cleanDirectory($dir);
        return back();
    }
}

// An example of how to use:
//$dir = "/my/backups";
// Delete backups older than 7 days
//$deleted = delete_older_than($dir, 3600*24*7);
if (!function_exists('delete_older_than')) {
    function delete_older_than($dir, $max_age)
    {
        $list = array();

        $limit = time() - $max_age;

        $dir = realpath($dir);

        if (!is_dir($dir)) {
            return;
        }

        $dh = opendir($dir);
        if ($dh === false) {
            return;
        }

        while (($file = readdir($dh)) !== false) {
            $file = $dir . '/' . $file;
            if (!is_file($file)) {
                continue;
            }

            if (filemtime($file) < $limit) {
                $list[] = $file;
                unlink($file);
            }
        }
        closedir($dh);
        return $list;
    }
}




function countries()
{
    return array('af' => 'Afghanistan', 'ax' => 'Aland Islands', 'al' => 'Albania', 'dz' => 'Algeria', 'as' => 'American Samoa', 'ad' => 'Andorra', 'ao' => 'Angola', 'ai' => 'Anguilla', 'aq' => 'Antarctica', 'ag' => 'Antigua and Barbuda', 'ar' => 'Argentina', 'am' => 'Armenia', 'aw' => 'Aruba', 'au' => 'Australia', 'at' => 'Austria', 'az' => 'Azerbaijan', 'bs' => 'Bahamas', 'bh' => 'Bahrain', 'bd' => 'Bangladesh', 'bb' => 'Barbados', 'by' => 'Belarus', 'be' => 'Belgium', 'bz' => 'Belize', 'bj' => 'Benin', 'bm' => 'Bermuda', 'bt' => 'Bhutan', 'bo' => 'Bolivia', 'bq' => 'Bonaire, Sint Eustatius and Saba', 'ba' => 'Bosnia and Herzegovina', 'bw' => 'Botswana', 'bv' => 'Bouvet Island', 'br' => 'Brazil', 'io' => 'British Indian Ocean Territory', 'bn' => 'Brunei Darussalam', 'bg' => 'Bulgaria', 'bf' => 'Burkina Faso', 'bi' => 'Burundi', 'kh' => 'Cambodia', 'cm' => 'Cameroon', 'ca' => 'Canada', 'cv' => 'Cape Verde', 'ky' => 'Cayman Islands', 'cf' => 'Central African Republic', 'td' => 'Chad', 'cl' => 'Chile', 'cn' => 'China', 'cx' => 'Christmas Island', 'cc' => 'Cocos (Keeling) Islands', 'co' => 'Colombia', 'km' => 'Comoros', 'cg' => 'Congo', 'cd' => 'Congo, the Democratic Republic of the', 'ck' => 'Cook Islands', 'cr' => 'Costa Rica', 'ci' => 'Cote D\'Ivoire', 'hr' => 'Croatia', 'cu' => 'Cuba', 'cw' => 'Curacao', 'cy' => 'Cyprus', 'cz' => 'Czech Republic', 'dk' => 'Denmark', 'dj' => 'Djibouti', 'dm' => 'Dominica', 'do' => 'Dominican Republic', 'ec' => 'Ecuador', 'eg' => 'Egypt', 'sv' => 'El Salvador', 'gq' => 'Equatorial Guinea', 'er' => 'Eritrea', 'ee' => 'Estonia', 'et' => 'Ethiopia', 'fk' => 'Falkland Islands (Malvinas)', 'fo' => 'Faroe Islands', 'fj' => 'Fiji', 'fi' => 'Finland', 'fr' => 'France', 'gf' => 'French Guiana', 'pf' => 'French Polynesia', 'tf' => 'French Southern Territories', 'ga' => 'Gabon', 'gm' => 'Gambia', 'ge' => 'Georgia', 'de' => 'Germany', 'gh' => 'Ghana', 'gi' => 'Gibraltar', 'gr' => 'Greece', 'gl' => 'Greenland', 'gd' => 'Grenada', 'gp' => 'Guadeloupe', 'gu' => 'Guam', 'gt' => 'Guatemala', 'gg' => 'Guernsey', 'gn' => 'Guinea', 'gw' => 'Guinea-Bissau', 'gy' => 'Guyana', 'ht' => 'Haiti', 'hm' => 'Heard Island and Mcdonald Islands', 'va' => 'Holy See (Vatican City State)', 'hn' => 'Honduras', 'hk' => 'Hong Kong', 'hu' => 'Hungary', 'is' => 'Iceland', 'in' => 'India', 'id' => 'Indonesia', 'ir' => 'Iran, Islamic Republic of', 'iq' => 'Iraq', 'ie' => 'Ireland', 'im' => 'Isle of Man', 'il' => 'Israel', 'it' => 'Italy', 'jm' => 'Jamaica', 'jp' => 'Japan', 'je' => 'Jersey', 'jo' => 'Jordan', 'kz' => 'Kazakhstan', 'ke' => 'Kenya', 'ki' => 'Kiribati', 'kp' => 'Korea, Democratic People\'s Republic of', 'kr' => 'Korea, Republic of', 'xk' => 'Kosovo', 'kw' => 'Kuwait', 'kg' => 'Kyrgyzstan', 'la' => 'Lao People\'s Democratic Republic', 'lv' => 'Latvia', 'lb' => 'Lebanon', 'ls' => 'Lesotho', 'lr' => 'Liberia', 'ly' => 'Libyan Arab Jamahiriya', 'li' => 'Liechtenstein', 'lt' => 'Lithuania', 'lu' => 'Luxembourg', 'mo' => 'Macao', 'mk' => 'Macedonia, the Former Yugoslav Republic of', 'mg' => 'Madagascar', 'mw' => 'Malawi', 'my' => 'Malaysia', 'mv' => 'Maldives', 'ml' => 'Mali', 'mt' => 'Malta', 'mh' => 'Marshall Islands', 'mq' => 'Martinique', 'mr' => 'Mauritania', 'mu' => 'Mauritius', 'yt' => 'Mayotte', 'mx' => 'Mexico', 'fm' => 'Micronesia, Federated States of', 'md' => 'Moldova, Republic of', 'mc' => 'Monaco', 'mn' => 'Mongolia', 'me' => 'Montenegro', 'ms' => 'Montserrat', 'ma' => 'Morocco', 'mz' => 'Mozambique', 'mm' => 'Myanmar', 'na' => 'Namibia', 'nr' => 'Nauru', 'np' => 'Nepal', 'nl' => 'Netherlands', 'an' => 'Netherlands Antilles', 'nc' => 'New Caledonia', 'nz' => 'New Zealand', 'ni' => 'Nicaragua', 'ne' => 'Niger', 'ng' => 'Nigeria', 'nu' => 'Niue', 'nf' => 'Norfolk Island', 'mp' => 'Northern Mariana Islands', 'no' => 'Norway', 'om' => 'Oman', 'pk' => 'Pakistan', 'pw' => 'Palau', 'ps' => 'Palestinian Territory, Occupied', 'pa' => 'Panama', 'pg' => 'Papua New Guinea', 'py' => 'Paraguay', 'pe' => 'Peru', 'ph' => 'Philippines', 'pn' => 'Pitcairn', 'pl' => 'Poland', 'pt' => 'Portugal', 'pr' => 'Puerto Rico', 'qa' => 'Qatar', 're' => 'Reunion', 'ro' => 'Romania', 'ru' => 'Russian Federation', 'rw' => 'Rwanda', 'bl' => 'Saint Barthelemy', 'sh' => 'Saint Helena', 'kn' => 'Saint Kitts and Nevis', 'lc' => 'Saint Lucia', 'mf' => 'Saint Martin', 'pm' => 'Saint Pierre and Miquelon', 'vc' => 'Saint Vincent and the Grenadines', 'ws' => 'Samoa', 'sm' => 'San Marino', 'st' => 'Sao Tome and Principe', 'sa' => 'Saudi Arabia', 'sn' => 'Senegal', 'rs' => 'Serbia', 'cs' => 'Serbia and Montenegro', 'sc' => 'Seychelles', 'sl' => 'Sierra Leone', 'sg' => 'Singapore', 'sx' => 'Sint Maarten', 'sk' => 'Slovakia', 'si' => 'Slovenia', 'sb' => 'Solomon Islands', 'so' => 'Somalia', 'za' => 'South Africa', 'gs' => 'South Georgia and the South Sandwich Islands', 'ss' => 'South Sudan', 'es' => 'Spain', 'lk' => 'Sri Lanka', 'sd' => 'Sudan', 'sr' => 'Suriname', 'sj' => 'Svalbard and Jan Mayen', 'sz' => 'Swaziland', 'se' => 'Sweden', 'ch' => 'Switzerland', 'sy' => 'Syrian Arab Republic', 'tw' => 'Taiwan, Province of China', 'tj' => 'Tajikistan', 'tz' => 'Tanzania, United Republic of', 'th' => 'Thailand', 'tl' => 'Timor-Leste', 'tg' => 'Togo', 'tk' => 'Tokelau', 'to' => 'Tonga', 'tt' => 'Trinidad and Tobago', 'tn' => 'Tunisia', 'tr' => 'Turkey', 'tm' => 'Turkmenistan', 'tc' => 'Turks and Caicos Islands', 'tv' => 'Tuvalu', 'ug' => 'Uganda', 'ua' => 'Ukraine', 'ae' => 'United Arab Emirates', 'gb' => 'United Kingdom', 'us' => 'United States', 'um' => 'United States Minor Outlying Islands', 'uy' => 'Uruguay', 'uz' => 'Uzbekistan', 'vu' => 'Vanuatu', 've' => 'Venezuela', 'vn' => 'Viet Nam', 'vg' => 'Virgin Islands, British', 'vi' => 'Virgin Islands, U.s.', 'wf' => 'Wallis and Futuna', 'eh' => 'Western Sahara', 'ye' => 'Yemen', 'zm' => 'Zambia', 'zw' => 'Zimbabwe');
}

function get_country($index)
{
    $array = array('af' => 'Afghanistan', 'ax' => 'Aland Islands', 'al' => 'Albania', 'dz' => 'Algeria', 'as' => 'American Samoa', 'ad' => 'Andorra', 'ao' => 'Angola', 'ai' => 'Anguilla', 'aq' => 'Antarctica', 'ag' => 'Antigua and Barbuda', 'ar' => 'Argentina', 'am' => 'Armenia', 'aw' => 'Aruba', 'au' => 'Australia', 'at' => 'Austria', 'az' => 'Azerbaijan', 'bs' => 'Bahamas', 'bh' => 'Bahrain', 'bd' => 'Bangladesh', 'bb' => 'Barbados', 'by' => 'Belarus', 'be' => 'Belgium', 'bz' => 'Belize', 'bj' => 'Benin', 'bm' => 'Bermuda', 'bt' => 'Bhutan', 'bo' => 'Bolivia', 'bq' => 'Bonaire, Sint Eustatius and Saba', 'ba' => 'Bosnia and Herzegovina', 'bw' => 'Botswana', 'bv' => 'Bouvet Island', 'br' => 'Brazil', 'io' => 'British Indian Ocean Territory', 'bn' => 'Brunei Darussalam', 'bg' => 'Bulgaria', 'bf' => 'Burkina Faso', 'bi' => 'Burundi', 'kh' => 'Cambodia', 'cm' => 'Cameroon', 'ca' => 'Canada', 'cv' => 'Cape Verde', 'ky' => 'Cayman Islands', 'cf' => 'Central African Republic', 'td' => 'Chad', 'cl' => 'Chile', 'cn' => 'China', 'cx' => 'Christmas Island', 'cc' => 'Cocos (Keeling) Islands', 'co' => 'Colombia', 'km' => 'Comoros', 'cg' => 'Congo', 'cd' => 'Congo, the Democratic Republic of the', 'ck' => 'Cook Islands', 'cr' => 'Costa Rica', 'ci' => 'Cote D\'Ivoire', 'hr' => 'Croatia', 'cu' => 'Cuba', 'cw' => 'Curacao', 'cy' => 'Cyprus', 'cz' => 'Czech Republic', 'dk' => 'Denmark', 'dj' => 'Djibouti', 'dm' => 'Dominica', 'do' => 'Dominican Republic', 'ec' => 'Ecuador', 'eg' => 'Egypt', 'sv' => 'El Salvador', 'gq' => 'Equatorial Guinea', 'er' => 'Eritrea', 'ee' => 'Estonia', 'et' => 'Ethiopia', 'fk' => 'Falkland Islands (Malvinas)', 'fo' => 'Faroe Islands', 'fj' => 'Fiji', 'fi' => 'Finland', 'fr' => 'France', 'gf' => 'French Guiana', 'pf' => 'French Polynesia', 'tf' => 'French Southern Territories', 'ga' => 'Gabon', 'gm' => 'Gambia', 'ge' => 'Georgia', 'de' => 'Germany', 'gh' => 'Ghana', 'gi' => 'Gibraltar', 'gr' => 'Greece', 'gl' => 'Greenland', 'gd' => 'Grenada', 'gp' => 'Guadeloupe', 'gu' => 'Guam', 'gt' => 'Guatemala', 'gg' => 'Guernsey', 'gn' => 'Guinea', 'gw' => 'Guinea-Bissau', 'gy' => 'Guyana', 'ht' => 'Haiti', 'hm' => 'Heard Island and Mcdonald Islands', 'va' => 'Holy See (Vatican City State)', 'hn' => 'Honduras', 'hk' => 'Hong Kong', 'hu' => 'Hungary', 'is' => 'Iceland', 'in' => 'India', 'id' => 'Indonesia', 'ir' => 'Iran, Islamic Republic of', 'iq' => 'Iraq', 'ie' => 'Ireland', 'im' => 'Isle of Man', 'il' => 'Israel', 'it' => 'Italy', 'jm' => 'Jamaica', 'jp' => 'Japan', 'je' => 'Jersey', 'jo' => 'Jordan', 'kz' => 'Kazakhstan', 'ke' => 'Kenya', 'ki' => 'Kiribati', 'kp' => 'Korea, Democratic People\'s Republic of', 'kr' => 'Korea, Republic of', 'xk' => 'Kosovo', 'kw' => 'Kuwait', 'kg' => 'Kyrgyzstan', 'la' => 'Lao People\'s Democratic Republic', 'lv' => 'Latvia', 'lb' => 'Lebanon', 'ls' => 'Lesotho', 'lr' => 'Liberia', 'ly' => 'Libyan Arab Jamahiriya', 'li' => 'Liechtenstein', 'lt' => 'Lithuania', 'lu' => 'Luxembourg', 'mo' => 'Macao', 'mk' => 'Macedonia, the Former Yugoslav Republic of', 'mg' => 'Madagascar', 'mw' => 'Malawi', 'my' => 'Malaysia', 'mv' => 'Maldives', 'ml' => 'Mali', 'mt' => 'Malta', 'mh' => 'Marshall Islands', 'mq' => 'Martinique', 'mr' => 'Mauritania', 'mu' => 'Mauritius', 'yt' => 'Mayotte', 'mx' => 'Mexico', 'fm' => 'Micronesia, Federated States of', 'md' => 'Moldova, Republic of', 'mc' => 'Monaco', 'mn' => 'Mongolia', 'me' => 'Montenegro', 'ms' => 'Montserrat', 'ma' => 'Morocco', 'mz' => 'Mozambique', 'mm' => 'Myanmar', 'na' => 'Namibia', 'nr' => 'Nauru', 'np' => 'Nepal', 'nl' => 'Netherlands', 'an' => 'Netherlands Antilles', 'nc' => 'New Caledonia', 'nz' => 'New Zealand', 'ni' => 'Nicaragua', 'ne' => 'Niger', 'ng' => 'Nigeria', 'nu' => 'Niue', 'nf' => 'Norfolk Island', 'mp' => 'Northern Mariana Islands', 'no' => 'Norway', 'om' => 'Oman', 'pk' => 'Pakistan', 'pw' => 'Palau', 'ps' => 'Palestinian Territory, Occupied', 'pa' => 'Panama', 'pg' => 'Papua New Guinea', 'py' => 'Paraguay', 'pe' => 'Peru', 'ph' => 'Philippines', 'pn' => 'Pitcairn', 'pl' => 'Poland', 'pt' => 'Portugal', 'pr' => 'Puerto Rico', 'qa' => 'Qatar', 're' => 'Reunion', 'ro' => 'Romania', 'ru' => 'Russian Federation', 'rw' => 'Rwanda', 'bl' => 'Saint Barthelemy', 'sh' => 'Saint Helena', 'kn' => 'Saint Kitts and Nevis', 'lc' => 'Saint Lucia', 'mf' => 'Saint Martin', 'pm' => 'Saint Pierre and Miquelon', 'vc' => 'Saint Vincent and the Grenadines', 'ws' => 'Samoa', 'sm' => 'San Marino', 'st' => 'Sao Tome and Principe', 'sa' => 'Saudi Arabia', 'sn' => 'Senegal', 'rs' => 'Serbia', 'cs' => 'Serbia and Montenegro', 'sc' => 'Seychelles', 'sl' => 'Sierra Leone', 'sg' => 'Singapore', 'sx' => 'Sint Maarten', 'sk' => 'Slovakia', 'si' => 'Slovenia', 'sb' => 'Solomon Islands', 'so' => 'Somalia', 'za' => 'South Africa', 'gs' => 'South Georgia and the South Sandwich Islands', 'ss' => 'South Sudan', 'es' => 'Spain', 'lk' => 'Sri Lanka', 'sd' => 'Sudan', 'sr' => 'Suriname', 'sj' => 'Svalbard and Jan Mayen', 'sz' => 'Swaziland', 'se' => 'Sweden', 'ch' => 'Switzerland', 'sy' => 'Syrian Arab Republic', 'tw' => 'Taiwan, Province of China', 'tj' => 'Tajikistan', 'tz' => 'Tanzania, United Republic of', 'th' => 'Thailand', 'tl' => 'Timor-Leste', 'tg' => 'Togo', 'tk' => 'Tokelau', 'to' => 'Tonga', 'tt' => 'Trinidad and Tobago', 'tn' => 'Tunisia', 'tr' => 'Turkey', 'tm' => 'Turkmenistan', 'tc' => 'Turks and Caicos Islands', 'tv' => 'Tuvalu', 'ug' => 'Uganda', 'ua' => 'Ukraine', 'ae' => 'United Arab Emirates', 'gb' => 'United Kingdom', 'us' => 'United States', 'um' => 'United States Minor Outlying Islands', 'uy' => 'Uruguay', 'uz' => 'Uzbekistan', 'vu' => 'Vanuatu', 've' => 'Venezuela', 'vn' => 'Viet Nam', 'vg' => 'Virgin Islands, British', 'vi' => 'Virgin Islands, U.s.', 'wf' => 'Wallis and Futuna', 'eh' => 'Western Sahara', 'ye' => 'Yemen', 'zm' => 'Zambia', 'zw' => 'Zimbabwe');
    return @$array[$index];
}

function timeZoneList()
{
    return array(
        '(UTC-11:00) Midway Island' => 'Pacific/Midway',
        '(UTC-11:00) Samoa' => 'Pacific/Samoa',
        '(UTC-10:00) Hawaii' => 'Pacific/Honolulu',
        '(UTC-09:00) Alaska' => 'US/Alaska',
        '(UTC-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
        '(UTC-08:00) Tijuana' => 'America/Tijuana',
        '(UTC-07:00) Arizona' => 'US/Arizona',
        '(UTC-07:00) Chihuahua' => 'America/Chihuahua',
        '(UTC-07:00) La Paz' => 'America/Chihuahua',
        '(UTC-07:00) Mazatlan' => 'America/Mazatlan',
        '(UTC-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
        '(UTC-06:00) Central America' => 'America/Managua',
        '(UTC-06:00) Central Time (US &amp; Canada)' => 'US/Central',
        '(UTC-06:00) Guadalajara' => 'America/Mexico_City',
        '(UTC-06:00) Mexico City' => 'America/Mexico_City',
        '(UTC-06:00) Monterrey' => 'America/Monterrey',
        '(UTC-06:00) Saskatchewan' => 'Canada/Saskatchewan',
        '(UTC-05:00) Bogota' => 'America/Bogota',
        '(UTC-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
        '(UTC-05:00) Indiana (East)' => 'US/East-Indiana',
        '(UTC-05:00) Lima' => 'America/Lima',
        '(UTC-05:00) Quito' => 'America/Bogota',
        '(UTC-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
        '(UTC-04:30) Caracas' => 'America/Caracas',
        '(UTC-04:00) La Paz' => 'America/La_Paz',
        '(UTC-04:00) Santiago' => 'America/Santiago',
        '(UTC-03:30) Newfoundland' => 'Canada/Newfoundland',
        '(UTC-03:00) Brasilia' => 'America/Sao_Paulo',
        '(UTC-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
        '(UTC-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
        '(UTC-03:00) Greenland' => 'America/Godthab',
        '(UTC-02:00) Mid-Atlantic' => 'America/Noronha',
        '(UTC-01:00) Azores' => 'Atlantic/Azores',
        '(UTC-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
        '(UTC+00:00) Casablanca' => 'Africa/Casablanca',
        '(UTC+00:00) Edinburgh' => 'Europe/London',
        '(UTC+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
        '(UTC+00:00) Lisbon' => 'Europe/Lisbon',
        '(UTC+00:00) London' => 'Europe/London',
        '(UTC+00:00) Monrovia' => 'Africa/Monrovia',
        '(UTC+00:00) UTC' => 'UTC',
        '(UTC+01:00) Amsterdam' => 'Europe/Amsterdam',
        '(UTC+01:00) Belgrade' => 'Europe/Belgrade',
        '(UTC+01:00) Berlin' => 'Europe/Berlin',
        '(UTC+01:00) Bern' => 'Europe/Berlin',
        '(UTC+01:00) Bratislava' => 'Europe/Bratislava',
        '(UTC+01:00) Brussels' => 'Europe/Brussels',
        '(UTC+01:00) Budapest' => 'Europe/Budapest',
        '(UTC+01:00) Copenhagen' => 'Europe/Copenhagen',
        '(UTC+01:00) Ljubljana' => 'Europe/Ljubljana',
        '(UTC+01:00) Madrid' => 'Europe/Madrid',
        '(UTC+01:00) Paris' => 'Europe/Paris',
        '(UTC+01:00) Prague' => 'Europe/Prague',
        '(UTC+01:00) Rome' => 'Europe/Rome',
        '(UTC+01:00) Sarajevo' => 'Europe/Sarajevo',
        '(UTC+01:00) Skopje' => 'Europe/Skopje',
        '(UTC+01:00) Stockholm' => 'Europe/Stockholm',
        '(UTC+01:00) Vienna' => 'Europe/Vienna',
        '(UTC+01:00) Warsaw' => 'Europe/Warsaw',
        '(UTC+01:00) West Central Africa' => 'Africa/Lagos',
        '(UTC+01:00) Zagreb' => 'Europe/Zagreb',
        '(UTC+02:00) Athens' => 'Europe/Athens',
        '(UTC+02:00) Bucharest' => 'Europe/Bucharest',
        '(UTC+02:00) Cairo' => 'Africa/Cairo',
        '(UTC+02:00) Harare' => 'Africa/Harare',
        '(UTC+02:00) Helsinki' => 'Europe/Helsinki',
        '(UTC+02:00) Istanbul' => 'Europe/Istanbul',
        '(UTC+02:00) Jerusalem' => 'Asia/Jerusalem',
        '(UTC+02:00) Kyiv' => 'Europe/Helsinki',
        '(UTC+02:00) Pretoria' => 'Africa/Johannesburg',
        '(UTC+02:00) Riga' => 'Europe/Riga',
        '(UTC+02:00) Sofia' => 'Europe/Sofia',
        '(UTC+02:00) Tallinn' => 'Europe/Tallinn',
        '(UTC+02:00) Vilnius' => 'Europe/Vilnius',
        '(UTC+03:00) Baghdad' => 'Asia/Baghdad',
        '(UTC+03:00) Kuwait' => 'Asia/Kuwait',
        '(UTC+03:00) Minsk' => 'Europe/Minsk',
        '(UTC+03:00) Nairobi' => 'Africa/Nairobi',
        '(UTC+03:00) Riyadh' => 'Asia/Riyadh',
        '(UTC+03:00) Volgograd' => 'Europe/Volgograd',
        '(UTC+03:30) Tehran' => 'Asia/Tehran',
        '(UTC+04:00) Abu Dhabi' => 'Asia/Muscat',
        '(UTC+04:00) Baku' => 'Asia/Baku',
        '(UTC+04:00) Moscow' => 'Europe/Moscow',
        '(UTC+04:00) Muscat' => 'Asia/Muscat',
        '(UTC+04:00) St. Petersburg' => 'Europe/Moscow',
        '(UTC+04:00) Tbilisi' => 'Asia/Tbilisi',
        '(UTC+04:00) Yerevan' => 'Asia/Yerevan',
        '(UTC+04:30) Kabul' => 'Asia/Kabul',
        '(UTC+05:00) Islamabad' => 'Asia/Karachi',
        '(UTC+05:00) Karachi' => 'Asia/Karachi',
        '(UTC+05:00) Tashkent' => 'Asia/Tashkent',
        '(UTC+05:30) Chennai' => 'Asia/Calcutta',
        '(UTC+05:30) Kolkata' => 'Asia/Kolkata',
        '(UTC+05:30) Mumbai' => 'Asia/Calcutta',
        '(UTC+05:30) New Delhi' => 'Asia/Calcutta',
        '(UTC+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
        '(UTC+05:45) Kathmandu' => 'Asia/Katmandu',
        '(UTC+06:00) Almaty' => 'Asia/Almaty',
        '(UTC+06:00) Astana' => 'Asia/Dhaka',
        '(UTC+06:00) Dhaka' => 'Asia/Dhaka',
        '(UTC+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
        '(UTC+06:30) Rangoon' => 'Asia/Rangoon',
        '(UTC+07:00) Bangkok' => 'Asia/Bangkok',
        '(UTC+07:00) Hanoi' => 'Asia/Bangkok',
        '(UTC+07:00) Jakarta' => 'Asia/Jakarta',
        '(UTC+07:00) Novosibirsk' => 'Asia/Novosibirsk',
        '(UTC+08:00) Beijing' => 'Asia/Hong_Kong',
        '(UTC+08:00) Chongqing' => 'Asia/Chongqing',
        '(UTC+08:00) Hong Kong' => 'Asia/Hong_Kong',
        '(UTC+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
        '(UTC+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
        '(UTC+08:00) Perth' => 'Australia/Perth',
        '(UTC+08:00) Singapore' => 'Asia/Singapore',
        '(UTC+08:00) Taipei' => 'Asia/Taipei',
        '(UTC+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
        '(UTC+08:00) Urumqi' => 'Asia/Urumqi',
        '(UTC+09:00) Irkutsk' => 'Asia/Irkutsk',
        '(UTC+09:00) Osaka' => 'Asia/Tokyo',
        '(UTC+09:00) Sapporo' => 'Asia/Tokyo',
        '(UTC+09:00) Seoul' => 'Asia/Seoul',
        '(UTC+09:00) Tokyo' => 'Asia/Tokyo',
        '(UTC+09:30) Adelaide' => 'Australia/Adelaide',
        '(UTC+09:30) Darwin' => 'Australia/Darwin',
        '(UTC+10:00) Brisbane' => 'Australia/Brisbane',
        '(UTC+10:00) Canberra' => 'Australia/Canberra',
        '(UTC+10:00) Guam' => 'Pacific/Guam',
        '(UTC+10:00) Hobart' => 'Australia/Hobart',
        '(UTC+10:00) Melbourne' => 'Australia/Melbourne',
        '(UTC+10:00) Port Moresby' => 'Pacific/Port_Moresby',
        '(UTC+10:00) Sydney' => 'Australia/Sydney',
        '(UTC+10:00) Yakutsk' => 'Asia/Yakutsk',
        '(UTC+11:00) Vladivostok' => 'Asia/Vladivostok',
        '(UTC+12:00) Auckland' => 'Pacific/Auckland',
        '(UTC+12:00) Fiji' => 'Pacific/Fiji',
        '(UTC+12:00) International Date Line West' => 'Pacific/Kwajalein',
        '(UTC+12:00) Kamchatka' => 'Asia/Kamchatka',
        '(UTC+12:00) Magadan' => 'Asia/Magadan',
        '(UTC+12:00) Marshall Is.' => 'Pacific/Fiji',
        '(UTC+12:00) New Caledonia' => 'Asia/Magadan',
        '(UTC+12:00) Solomon Is.' => 'Asia/Magadan',
        '(UTC+12:00) Wellington' => 'Pacific/Auckland',
        '(UTC+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
    );
}

//$weekdays = getWeeklyDayNumbers('01-01-2021', '31-01-2021');
function number_of_days($days, $start, $end)
{
    $start = strtotime($start);
    $end = strtotime($end);
    $w = array(date('w', $start), date('w', $end));
    $x = floor(($end - $start) / 604800);
    $sum = 0;
    for ($day = 0; $day < 7; ++$day) {
        if ($days & pow(2, $day)) {
            $sum += $x + ($w[0] > $w[1] ? $w[0] <= $day || $day <= $w[1] : $w[0] <= $day && $day <= $w[1]);
        }
    }
    return $sum;
}

function createDateRangeArray($strDateFrom, $strDateTo)
{
    // takes two dates formatted as YYYY-MM-DD and creates an
    // inclusive array of the dates between the from and to dates.
    // could test validity of dates here but I'm already doing
    // that in the main script
    $aryRange = array();
    $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
    $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
    if ($iDateTo >= $iDateFrom) {
        array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
        while ($iDateFrom < $iDateTo) {
            $iDateFrom += 86400; // add 24 hours
            array_push($aryRange, date('Y-m-d', $iDateFrom));
        }
    }
    return $aryRange;
}


function weekdays()
{
    return [
        [
            'label' => 'Sunday',
            'value' => 'Sun',
        ],
        [
            'label' => 'Monday',
            'value' => 'Mon',
        ],
        [
            'label' => 'Tuesday',
            'value' => 'Tue',
        ],
        [
            'label' => 'Wednesday',
            'value' => 'Wed',
        ],
        [
            'label' => 'Thursday',
            'value' => 'Thu',
        ],
        [
            'label' => 'Friday',
            'value' => 'Fri',
        ],
        [
            'label' => 'Saturday',
            'value' => 'Sat',
        ]
    ];
}


function distance($lat1, $lon1, $lat2, $lon2, $unit)
{

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function timeToSecond($time)
{
    $parsed = date_parse($time);
    return $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
}

function secondsToTime($seconds)
{
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    $hours = ($hours < 9) ? '0' . $hours : $hours;
    $minutes = ($minutes < 9) ? '0' . $minutes : $minutes;
    $seconds = ($seconds < 9) ? '0' . $seconds : $seconds;
    return "$hours:$minutes:$seconds";
}

function secondsToTime1($seconds)
{
    $hours = floor($seconds / 3600);
    $seconds -= $hours * 3600;
    $minutes = floor($seconds / 60);
    $seconds -= $minutes * 60;
    $hours = ($hours < 9) ? '0' . $hours : $hours;
    $minutes = ($minutes < 9) ? '0' . $minutes : $minutes;
    $seconds = ($seconds < 9) ? '0' . $seconds : $seconds;
    return "$hours:$minutes";
}

function dayCount($day, $startDate, $endDate, $counter)
{
    if ($startDate >= $endDate) {
        return $counter;
    } else {
        return dayCount($day, strtotime("next " . $day, $startDate), $endDate, ++$counter);
    }
}

function timeDiffPro($time1, $time2)
{
    $time1 = date_create("$time1");
    $time2 = date_create("$time2");
    if ($time1 == false || $time2 == false) {
        return "00:00:00";
    } else {
        $diff = date_diff($time2, $time1);
        $date = $diff->h . ':' . $diff->i . ':' . $diff->s;
        return date("H:i:s", strtotime($date));
    }
}

function totalHours($date_expire, $date_expire1)
{

    $date = new DateTime($date_expire);
    $now = new DateTime($date_expire1);
    $interval = date_diff($date, $now);
    $day = $interval->format('%a');
    $hours = $interval->format('%h');
    $minutes = $interval->format('%i');
    $second = $interval->format('%s');
    $total = ($day * 24) + $hours;
    return $total . ':' . $minutes . ':' . $second;
}

function countSpecificDays($year, $month, $days)
{
    $date = new DateTime("$year-$month-01");
    $counts = array();

    // Initialize counts for specified days
    foreach ($days as $day) {
        $counts[$day] = 0;
    }

    while ($date->format('Y-m') === "$year-$month") {
        $currentDay = $date->format('D');

        if (in_array($currentDay, $days)) {
            $counts[$currentDay]++;
        }

        $date->modify('+1 day');
    }

    return $counts;
}

function get_sundays($start_date, $end_date, $days)
{
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = new DateInterval('P1D'); // 1 day interval
    $period = new DatePeriod($start, $interval, $end);

    $counts = array();

    // Initialize counts for specified days
    foreach ($days as $day) {
        $counts[$day] = 0;
    }

    foreach ($period as $date) {
        $currentDay = $date->format('D');
        if (in_array($currentDay, $days)) {
            $counts[$currentDay]++;
        }
    }
    // while ($start->format('Y-m-d') === $end_date) {
    //     $currentDay = $start->format('D');

    //     if (in_array($currentDay, $days)) {
    //         $counts[$currentDay]++;
    //     }

    //     $start->modify('+1 day');
    // }

    return $counts;


    // $sundays = [];
    // foreach ($period as $date) {
    //     if ($date->format('l') === 'Sunday') {
    //         $sundays[] = $date->format('Y-m-d');
    //     }
    // }

    // return $sundays;
}


function getNextMonthAndYear($currentMonth)
{
    $date = DateTime::createFromFormat('Y-m', $currentMonth);
    $date->modify('+1 month');

    $nextMonth = $date->format('m');
    $nextYear = $date->format('Y');

    return [
        'nextMonth' => $nextMonth,
        'nextYear' => $nextYear
    ];
}

function get_total_days($start_date, $end_date)
{
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = $start->diff($end);
    return $interval->days;
}



function filterCallback($value)
{
    return $value !== "some" && $value !== "none";
}



function sanitizeFileName($fileName)
{
    // Remove any special characters and replace spaces with hyphens
    $sanitizedFileName = preg_replace('/[^A-Za-z0-9-]/', '', str_replace(' ', '-', $fileName));

    // Remove multiple consecutive hyphens
    $sanitizedFileName = preg_replace('/-{2,}/', '-', $sanitizedFileName);

    // Lowercase the file name
    $sanitizedFileName = strtolower($sanitizedFileName);

    return $sanitizedFileName;
}


function currencyList()
{
    $currency_list = array(
        "AFA" => "Afghan Afghani",
        "ALL" => "Albanian Lek",
        "DZD" => "Algerian Dinar",
        "AOA" => "Angolan Kwanza",
        "ARS" => "Argentine Peso",
        "AMD" => "Armenian Dram",
        "AWG" => "Aruban Florin",
        "AUD" => "Australian Dollar",
        "AZN" => "Azerbaijani Manat",
        "BSD" => "Bahamian Dollar",
        "BHD" => "Bahraini Dinar",
        "BDT" => "Bangladeshi Taka",
        "BBD" => "Barbadian Dollar",
        "BYR" => "Belarusian Ruble",
        "BEF" => "Belgian Franc",
        "BZD" => "Belize Dollar",
        "BMD" => "Bermudan Dollar",
        "BTN" => "Bhutanese Ngultrum",
        "BTC" => "Bitcoin",
        "BOB" => "Bolivian Boliviano",
        "BAM" => "Bosnia-Herzegovina Convertible Mark",
        "BWP" => "Botswanan Pula",
        "BRL" => "Brazilian Real",
        "GBP" => "British Pound Sterling",
        "BND" => "Brunei Dollar",
        "BGN" => "Bulgarian Lev",
        "BIF" => "Burundian Franc",
        "KHR" => "Cambodian Riel",
        "CAD" => "Canadian Dollar",
        "CVE" => "Cape Verdean Escudo",
        "KYD" => "Cayman Islands Dollar",
        "XOF" => "CFA Franc BCEAO",
        "XAF" => "CFA Franc BEAC",
        "XPF" => "CFP Franc",
        "CLP" => "Chilean Peso",
        "CLF" => "Chilean Unit of Account",
        "CNY" => "Chinese Yuan",
        "COP" => "Colombian Peso",
        "KMF" => "Comorian Franc",
        "CDF" => "Congolese Franc",
        "CRC" => "Costa Rican Colón",
        "HRK" => "Croatian Kuna",
        "CUC" => "Cuban Convertible Peso",
        "CZK" => "Czech Republic Koruna",
        "DKK" => "Danish Krone",
        "DJF" => "Djiboutian Franc",
        "DOP" => "Dominican Peso",
        "XCD" => "East Caribbean Dollar",
        "EGP" => "Egyptian Pound",
        "ERN" => "Eritrean Nakfa",
        "EEK" => "Estonian Kroon",
        "ETB" => "Ethiopian Birr",
        "EUR" => "Euro",
        "FKP" => "Falkland Islands Pound",
        "FJD" => "Fijian Dollar",
        "GMD" => "Gambian Dalasi",
        "GEL" => "Georgian Lari",
        "DEM" => "German Mark",
        "GHS" => "Ghanaian Cedi",
        "GIP" => "Gibraltar Pound",
        "GRD" => "Greek Drachma",
        "GTQ" => "Guatemalan Quetzal",
        "GNF" => "Guinean Franc",
        "GYD" => "Guyanaese Dollar",
        "HTG" => "Haitian Gourde",
        "HNL" => "Honduran Lempira",
        "HKD" => "Hong Kong Dollar",
        "HUF" => "Hungarian Forint",
        "ISK" => "Icelandic Króna",
        "INR" => "Indian Rupee",
        "IDR" => "Indonesian Rupiah",
        "IRR" => "Iranian Rial",
        "IQD" => "Iraqi Dinar",
        "ILS" => "Israeli New Sheqel",
        "ITL" => "Italian Lira",
        "JMD" => "Jamaican Dollar",
        "JPY" => "Japanese Yen",
        "JOD" => "Jordanian Dinar",
        "KZT" => "Kazakhstani Tenge",
        "KES" => "Kenyan Shilling",
        "KWD" => "Kuwaiti Dinar",
        "KGS" => "Kyrgystani Som",
        "LAK" => "Laotian Kip",
        "LVL" => "Latvian Lats",
        "LBP" => "Lebanese Pound",
        "LSL" => "Lesotho Loti",
        "LRD" => "Liberian Dollar",
        "LYD" => "Libyan Dinar",
        "LTC" => "Litecoin",
        "LTL" => "Lithuanian Litas",
        "MOP" => "Macanese Pataca",
        "MKD" => "Macedonian Denar",
        "MGA" => "Malagasy Ariary",
        "MWK" => "Malawian Kwacha",
        "MYR" => "Malaysian Ringgit",
        "MVR" => "Maldivian Rufiyaa",
        "MRO" => "Mauritanian Ouguiya",
        "MUR" => "Mauritian Rupee",
        "MXN" => "Mexican Peso",
        "MDL" => "Moldovan Leu",
        "MNT" => "Mongolian Tugrik",
        "MAD" => "Moroccan Dirham",
        "MZM" => "Mozambican Metical",
        "MMK" => "Myanmar Kyat",
        "NAD" => "Namibian Dollar",
        "NPR" => "Nepalese Rupee",
        "ANG" => "Netherlands Antillean Guilder",
        "TWD" => "New Taiwan Dollar",
        "NZD" => "New Zealand Dollar",
        "NIO" => "Nicaraguan Córdoba",
        "NGN" => "Nigerian Naira",
        "KPW" => "North Korean Won",
        "NOK" => "Norwegian Krone",
        "OMR" => "Omani Rial",
        "PKR" => "Pakistani Rupee",
        "PAB" => "Panamanian Balboa",
        "PGK" => "Papua New Guinean Kina",
        "PYG" => "Paraguayan Guarani",
        "PEN" => "Peruvian Nuevo Sol",
        "PHP" => "Philippine Peso",
        "PLN" => "Polish Zloty",
        "QAR" => "Qatari Rial",
        "RON" => "Romanian Leu",
        "RUB" => "Russian Ruble",
        "RWF" => "Rwandan Franc",
        "SVC" => "Salvadoran Colón",
        "WST" => "Samoan Tala",
        "STD" => "São Tomé and Príncipe Dobra",
        "SAR" => "Saudi Riyal",
        "RSD" => "Serbian Dinar",
        "SCR" => "Seychellois Rupee",
        "SLL" => "Sierra Leonean Leone",
        "SGD" => "Singapore Dollar",
        "SKK" => "Slovak Koruna",
        "SBD" => "Solomon Islands Dollar",
        "SOS" => "Somali Shilling",
        "ZAR" => "South African Rand",
        "KRW" => "South Korean Won",
        "SSP" => "South Sudanese Pound",
        "XDR" => "Special Drawing Rights",
        "LKR" => "Sri Lankan Rupee",
        "SHP" => "St. Helena Pound",
        "SDG" => "Sudanese Pound",
        "SRD" => "Surinamese Dollar",
        "SZL" => "Swazi Lilangeni",
        "SEK" => "Swedish Krona",
        "CHF" => "Swiss Franc",
        "SYP" => "Syrian Pound",
        "TJS" => "Tajikistani Somoni",
        "TZS" => "Tanzanian Shilling",
        "THB" => "Thai Baht",
        "TOP" => "Tongan Pa'anga",
        "TTD" => "Trinidad & Tobago Dollar",
        "TND" => "Tunisian Dinar",
        "TRY" => "Turkish Lira",
        "TMT" => "Turkmenistani Manat",
        "UGX" => "Ugandan Shilling",
        "UAH" => "Ukrainian Hryvnia",
        "AED" => "United Arab Emirates Dirham",
        "UYU" => "Uruguayan Peso",
        "USD" => "US Dollar",
        "UZS" => "Uzbekistan Som",
        "VUV" => "Vanuatu Vatu",
        "VEF" => "Venezuelan BolÃvar",
        "VND" => "Vietnamese Dong",
        "YER" => "Yemeni Rial",
        "ZMK" => "Zambian Kwacha",
        "ZWL" => "Zimbabwean dollar"
    );

    return $currency_list;
}

function envWrite($key, $value)
{
    $env = file_get_contents(isset($env_path) ? $env_path : base_path('.env')); //fet .env file
    $env = str_replace("$key=" . env($key), "$key=", $env); //replace value

    $value = preg_replace('/\s+/', '', $value); //replace special ch
    $key = strtoupper($key); //force upper for security
    $env = file_get_contents(isset($env_path) ? $env_path : base_path('.env')); //fet .env file
    $env = str_replace("$key=" . env($key), "$key=" . $value, $env); //replace value
    /** Save file eith new content */
    $env = file_put_contents(isset($env_path) ? $env_path : base_path('.env'), $env);
    return true;
}


function formatBytes($bytes, $precision = 2)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}


function custom_number_format($amount)
{
    return number_format($amount, config('generalsetting.decimal_places'), config('generalsetting.decimal_seperator'), config('generalsetting.thousand_seperator'));
}

function custom_date_format($date)
{
    return date(config('generalsetting.date_format'), strtotime($date));
}

function get_voucher_type()
{
    return [
        1 => 'Adjustments',
        2 => 'Admin Expense',
        3 => 'Contra Entry',
        4 => 'Invoice',
        5 => 'Payment',
        6 => 'Receipt',
    ];
}


if (!function_exists('get_otp')) {
    function get_otp($length)
    {
        $token = "";
        $codeAlphabet = "0123456789";
        $codeAlphabet .= "0123456789";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[rand_secure(0, $max - 1)];
        }

        return $token;
    }
}



function upload_attachment($fileName, $request, $inputName, $path)
{
    if ($request->hasFile($inputName)) {
        $file = $request->file($inputName);
        $fileName = $fileName . "." . $file->getClientOriginalExtension();
        $filePath = $file->storeAs($path, $fileName, 'public');
        return $filePath;
    }
}



function calculateDistance($lat1, $lon1, $lat2, $lon2)
{
    $earthRadius = 6371; // Earth radius in kilometers

    $latFrom = deg2rad($lat1);
    $lonFrom = deg2rad($lon1);
    $latTo = deg2rad($lat2);
    $lonTo = deg2rad($lon2);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    return $earthRadius * $angle; // Returns the distance in kilometers
}

function getDistance($lat1, $lon1, $lat2, $lon2)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344);
}


if (!function_exists('getRestaurantByDomain')) {
    function getBranchByDomain()
    {
        $origin = rtrim(request()->header('origin') ?? '', '/');
        $referer = rtrim(request()->header('x-domain') ?? '', '/');
        $domain = $origin ?: $referer;

        // Cache key domain অনুযায়ী সেট করা
        $cacheKey = 'branch_by_domain_' . md5($domain ?: 'default');

        // 1 hour cache (তুমি চাইলে সময় বাড়াতে পারো)
        return Cache::remember($cacheKey, now()->addHour(), function () use ($domain) {
            $branch = Branch::query()->where('domain', $domain)->first();
            return $branch ?: Branch::query()->first();
        });
    }
}
