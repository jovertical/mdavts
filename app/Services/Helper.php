<?php

/**
 * Define miscellaneous helper methods here.
 * This will be autoloaded, therefore it will be accessible globally.
 */

if (! function_exists('user_env')) {
    function user_env() {
        switch (request()->segment(1)) {
            case 'admin':
                    $user_env = 'root';
                break;

            default:
                    $user_env = 'front';
                break;
        }

        return $user_env;
    }
}

if (! function_exists('greet')) {
    function greet() {
        $date_time = date('H:i:s');

        if ($date_time >= '00:00:00' && $date_time < '12:00:00') {
            return 'Goodmorning! Goodluck for the day ahead.';
        } elseif ($date_time >= '12:00:00' && $date_time < '13:00:00') {
            return 'Hello! It is already lunch time.';
        } elseif ($date_time >= '13:00:00' && $date_time < '17:00:00') {
            return 'Goodafternoon!';
        } elseif ($date_time >= '17:00:00' && $date_time < '20:00:00') {
            return 'Hello! It is already dinner time.';
        } elseif ($date_time >= '17:00:00' && $date_time < '24:00:00') {
            return 'Goodevening! Do not forget your sleep.';
        } else {
            return 'Hello!';
        }
    }
}

if (! function_exists('active_menu')) {
    function active_menu($menu_item, $segment = null) {
        if ($segment == $menu_item) {
            return true;
        }

        return;
    }
}

if (! function_exists('create_username')) {
    function create_username($firstname) {
        return strtolower($firstname).'.'.mt_rand(00000, 99999);
    }
}

if (! function_exists('create_token')) {
    function create_token() {
        $base64_str = base64_encode(bin2hex(random_bytes(20)));

        return substr($base64_str, 0, -2);
    }
}

if (! function_exists('create_filename')) {
    function create_filename($ext) {
        $name = str_shuffle(
            str_random().date('YmdHis')
        );

        return $name.'.'.$ext;
    }
}

if (! function_exists('avatar_path')) {
    function avatar_path($model) {
        if (! empty($directory = $model->directory)) {
            return url("{$directory}/{$model->filename}");
        }

        return url('root/app/images/avatar.png');
    }
}

if (! function_exists('avatar_resized_path')) {
    function avatar_resized_path($model) {
        if (! empty($directory = $model->directory)) {
            return url("{$directory}/resized/{$model->filename}");
        }

        return url('root/app/images/avatar.png');
    }
}

if (! function_exists('avatar_thumbnail_path')) {
    function avatar_thumbnail_path($model) {
        if (! empty($directory = $model->directory)) {
            return url("{$directory}/thumbnails/{$model->filename}");
        }

        return url('root/app/images/avatar.png');
    }
}