<?php
/**
 * SKR v4.0 - PHPStudy 专用版
 * 多文件架构 | 首页 + 论坛 + 游戏 + ZJO | 零配置安装
 */

require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/template.php';

require_once __DIR__ . '/modules/install.php';
require_once __DIR__ . '/modules/home.php';
require_once __DIR__ . '/modules/forum.php';
require_once __DIR__ . '/modules/game.php';
require_once __DIR__ . '/modules/zjo.php';
require_once __DIR__ . '/modules/notice.php';
require_once __DIR__ . '/modules/user.php';
require_once __DIR__ . '/modules/api.php';
require_once __DIR__ . '/modules/admin.php';

$a = $_GET['a'] ?? 'home';

if (!file_exists(CONFIG_FILE) && $a != 'install') {
    redirect('?a=install');
}

if (isLogin() && file_exists(CONFIG_FILE)) {
    try {
        $db = DB::get();
        if ($db->ready()) {
            $db->query("INSERT INTO online (user_id,updated_at) VALUES (?,?) ON DUPLICATE KEY UPDATE updated_at=?",
                [$_SESSION['user_id'], date('Y-m-d H:i:s'), date('Y-m-d H:i:s')]);
        }
    } catch(Exception $e){}
}

switch ($a) {
    case 'install': doInstall(); break;
    case 'login': doLogin(); break;
    case 'reg': doReg(); break;
    case 'logout': session_destroy(); redirect('./'); break;
    
    case 'home': showHome(); break;
    
    case 'forum': doForum(); break;
    case 'post': viewPost(); break;
    case 'newpost': newPost(); break;
    
    case 'game': doGame(); break;
    case 'play': playGame(); break;
    
    case 'zjo': doZJO(); break;
    case 'rain': doRain(); break;
    case 'particles': doParticles(); break;
    case 'hypercube': playHypercube(); break;
    case 'notice': doNotice(); break;
    
    case 'api': doApi(); break;
    
    case 'admin': doAdmin(); break;
    
    default: showHome();
}
