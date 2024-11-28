<?php

class Flasher {
    
    public static function setFlash($icon, $title, $text)
    {
        $_SESSION['flash'] = [
            'icon' => $icon,
            'title' => $title,
            'text' => $text
        ];
    }

    public static function flash()
    {
        if (isset($_SESSION['flash'])) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: '{$_SESSION['flash']['icon']}',
                        title: '{$_SESSION['flash']['title']}',
                        text: '{$_SESSION['flash']['text']}',
                        confirmButtonText: 'OK'
                    })
                });
            </script>";
            unset($_SESSION['flash']); 
        }
    }
    
}