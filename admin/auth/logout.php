<?php
/**
 * Admin Logout
 */

require_once dirname(__DIR__, 2) . '/config/config.php';
require_once SRC_PATH . '/helpers/SessionHelper.php';
require_once SRC_PATH . '/helpers/SecurityHelper.php';

SessionHelper::logout();
SecurityHelper::redirect(BASE_URL . '/admin/auth/login.php');
