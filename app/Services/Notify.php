<?php

namespace App\Services;

class Notify
{
    public static function notification()
    {
        if (! session()->has('notification')) {
            return;
        }

        return '
            <script>
                $.toast({
                    heading: "'.session()->get('notification.title').'",
                    text: "'.session()->get('notification.body').'",
                    position: "'.config('notify.position').'",
                    loaderBg: "'.config('notify.loader_bg').'",
                    icon: "'.session()->get('notification.type').'",
                    hideAfter: "'.config('notify.hide_after').'",
                    stack: "'.config('notify.stack').'"
                })
            </script>
        ';
    }

    public static function success($body, $title = '')
    {
        session()->flash('notification', [
            'type' => 'success',
            'body' => $body,
            'title' => $title
        ]);
    }

    public static function warning($body, $title = '')
    {
        session()->flash('notification', [
            'type' => 'warning',
            'body' => $body,
            'title' => $title
        ]);
    }

    public static function error($body, $title = '')
    {
        session()->flash('notification', [
            'type' => 'danger',
            'body' => $body,
            'title' => $title
        ]);
    }
}