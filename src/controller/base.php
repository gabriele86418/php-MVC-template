<?php

    class BaseController
    {
        public static function renderPageAbout()
        {
            include __DIR__ . "/../view/pages/static/about.html";
        }

        public static function renderPageHome()
        {
            include __DIR__ . "/../view/pages/static/home.html";
        }

        public static function renderPageNotFound()
        {
            http_response_code(404);
            include __DIR__ . "/../view/pages/static/error404.html";
        }
    }
?>