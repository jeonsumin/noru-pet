<?php
$_BB_PATH = path();
$member = array();
//$_SESSION = array();
//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0);    // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags",""); // 링크에 PHPSESSID가 따라다니는것을 무력화함
// @ini_set('session.save_path', _BB_SESSION_PATH);

//session_save_path(_BB_SESSION_PATH);

if (isset($SESSION_CACHE_LIMITER))
    @session_cache_limiter($SESSION_CACHE_LIMITER);
else
    @session_cache_limiter("no-cache, must-revalidate");

@ini_set("session.cache_expire", 3600); // 세션 캐쉬 보관시간 (분)
@ini_set("session.gc_maxlifetime", 10800); // session data의 garbage collection 존재 기간을 지정 (초)
@ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
@ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

if(!isset($_SESSION)){
    session_start();
}


if ($_BB_PATH['basename'] != "login.check.php"){// || $_BB_PATH['uri_dri'][2] != "api"
    if (isset($_SESSION['ss_auth'])) { // 로그인중이라면

        //echo print_r($member);
        // if ($member['mb_level'] == 10 ){
            // $is_admin = true;
        // }
    } else {
        if ($_BB_PATH['basename'] != "login.php"){
            $link = _BB_ADMIN_LOGIN_URL_PATH;
            goto_url($link);
        }
    }
}

function path(){
    $result['path'] = str_replace('\\', '/', dirname(__FILE__));
    $tilde_remove = preg_replace('/^\/\~[^\/]+(.*)$/', '$1', $_SERVER['SCRIPT_NAME']);
    $document_root = str_replace($tilde_remove, '', $_SERVER['SCRIPT_FILENAME']);
    $root = str_replace($document_root, '', $result['path']);
    $port = $_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '';
    $http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';
    $user = str_replace(str_replace($document_root, '', $_SERVER['SCRIPT_FILENAME']), '', $_SERVER['SCRIPT_NAME']);
    $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
    if(isset($_SERVER['HTTP_HOST']) && preg_match('/:[0-9]+$/', $host))
        $host = preg_replace('/:[0-9]+$/', '', $host);

    $host = preg_replace("/[\<\>\'\"\\\'\\\"\%\=\(\)\/\^\*]/", '', $host);
    $result['url'] = $http.$host.$port.$user.$root;
    $result['hostname'] = $_SERVER["HTTP_HOST"]; //도메인명(호스트)명을 구합니다.
    $result['uri'] = $_SERVER['REQUEST_URI']; //uri를 구합니다.
    $result['query_string'] = getenv("QUERY_STRING"); // Get값으로 넘어온 값들을 구합니다.
    $result['phpself'] = $_SERVER["PHP_SELF"]; //현재 실행되고 있는 페이지의 url을 구합니다.
    $result['basename'] = basename($_SERVER["PHP_SELF"]); //현재 실행되고 있는 페이지명만 구합니다.
    // $result['uri_dri'] = explode('/',$_BB_PATH['phpself']);
    return $result;
}