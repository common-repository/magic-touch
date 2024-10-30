<?php

if(!defined('MagicTouchModuleCoreClassLoaded')) {

    define('MagicTouchModuleCoreClassLoaded', true);

    require_once(dirname(__FILE__) . '/magictoolbox.params.class.php');

    class MagicTouchModuleCoreClass {
        var $uri;
        var $jsPath;
        var $cssPath;
        var $imgPath;
        var $params;
        var $general;//initial parameters
        var $id;
        var $type = 'standard';

        function MagicTouchModuleCoreClass() {
            $this->params = new MagicToolboxParamsClass();
            $this->general = new MagicToolboxParamsClass();
            $this->_paramDefaults();
        }

        function headers($jsPath = '', $cssPath = null, $notCheck = false) {

            //to prevent multiple displaying of headers
            if(!defined('MagicTouchModuleHeaders')) {
                define('MagicTouchModuleHeaders', true);
            } else {
                return '';
            }
            if($cssPath == null) $cssPath = $jsPath;
            $headers = array();
            $headers[] = '<!-- Magic Touch WordPress module version v5.11.12 [v1.4.6:v4.2.1] -->';
            $headers[] = '<link type="text/css" href="' . $cssPath . '/magictouch.css" rel="stylesheet" media="screen" />';
            if(!$this->params->checkValue('unique-code', '')) {
                $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] && strtolower($_SERVER['HTTPS'])!='off' || isset($_SERVER['SSL_PROTOCOL']) && $_SERVER['SSL_PROTOCOL'])?'https':'http';
                $headers[] = '<script type="text/javascript" src="'.$protocol.'://www.magictoolbox.com/mt/' . $this->params->getValue('unique-code') . '/magictouch.js"></script>';
                //$this->params->set("stylesheet", $cssPath.'/desktop.css');
                //$this->params->set("stylesheetMobile", $cssPath.'/mobile.css');
                $headers[] = "<script type=\"text/javascript\">\nMagicTouch.options = {\n\t\t".implode(",\n\t\t", $this->options($notCheck))."\n\t}\n</script>\n";
            }
            return implode("\r\n", $headers);

        }

        function options($notCheck = false) {

            $conf = Array(
                "'levels': " . $this->params->getValue("levels"),
                "'border-width': " . $this->params->getValue("border-width"),
                "'border-color': '" . $this->params->getValue("border-color") . "'",
                "'progress-height': " . $this->params->getValue("progress-height"),
                "'progress-color': '" . $this->params->getValue("progress-color") . "'",
                "'fullscreen-btn-scale': " . $this->params->getValue("fullscreen-btn-scale"),
                "'button-position-y': '" . $this->params->getValue("button-position-y") . "'",
                "'button-position-x': '" . $this->params->getValue("button-position-x") . "'",
                "'button-margin': " . $this->params->getValue("button-margin"),
                "'button-alpha': " . $this->params->getValue("button-alpha"),
                "'button-alpha-hover': " . $this->params->getValue("button-alpha-hover"),
                "'button-orientation': '" . $this->params->getValue("button-orientation") . "'",
                "'button-padding': " . $this->params->getValue("button-padding"),
                "'nav-alpha': " . $this->params->getValue("nav-alpha"),
                "'preview-size': " . $this->params->getValue("preview-size"),
                "'preview-alpha': " . $this->params->getValue("preview-alpha"),
                "'preview-position-y': '" . $this->params->getValue("preview-position-y") . "'",
                "'preview-position-x': '" . $this->params->getValue("preview-position-x") . "'",
                "'preview-selection-alpha': '" . $this->params->getValue("preview-selection-alpha") . "'",
                "'arrow-move': " . $this->params->getValue("arrow-move"),
                "'arrow-position-x': '" . $this->params->getValue("arrow-position-x") . "'",
                "'arrow-position-y': '" . $this->params->getValue("arrow-position-y") . "'",
                "'arrow-alpha': " . $this->params->getValue("arrow-alpha"),
                "'arrow-alpha-hover': " . $this->params->getValue("arrow-alpha-hover"),
                "'arrow-background-alpha': " . $this->params->getValue("arrow-background-alpha"),
                "'arrow-background-offset-x': " . $this->params->getValue("arrow-background-offset-x"),
                "'arrow-background-offset-y': " . $this->params->getValue("arrow-background-offset-y"),
                "'smoothing': '" . $this->params->getValue("smoothing") . "'",
                "'background-color': '" . $this->params->getValue("background-color") . "'",
                "'theme-url': '" . $this->params->getValue("theme-url") . "'",
                "'thumbnails-position': '" . $this->params->getValue("thumbnails-position") . "'",
                "'thumbnails-alpha': " . $this->params->getValue("thumbnails-alpha"),
                "'thumbnails-alpha-hover': " . $this->params->getValue("thumbnails-alpha-hover"),
                "'thumbnails-padding': " . $this->params->getValue("thumbnails-padding"),
                "'thumbnails-border-color': '" . $this->params->getValue("thumbnails-border-color") . "'",
                "'thumbnails-border-width': " . $this->params->getValue("thumbnails-border-width"),
                "'thumbnails-max-height': " . $this->params->getValue("thumbnails-max-height"),
                "'thumbnails-max-width': " . $this->params->getValue("thumbnails-max-width"),
            );

            if($this->params->checkValue('print', 'no')) {
                $conf[] = "'print': '" . $this->params->getValue("print") . "'";
            }
            //not need this,  used imagehelper watermark
            //if($this->params->getValue('watermark') != '') {
            //    $conf = array_merge($conf, array(
            //        "'watermark': '" . $this->params->getValue('watermark') . "'",
            //        "'watermark-alpha': " . $this->params->getValue('watermark-alpha'),
            //    ));
            //}

            if($this->params->getValue('custom-logo') != '') {
                $conf = array_merge($conf, array(
                    "'custom-logo': '" . $this->params->getValue('custom-logo') . "'",
                    "'custom-logo-position-x': '" . $this->params->getValue('custom-logo-position-x'). "'",
                    "'custom-logo-position-y': '" . $this->params->getValue('custom-logo-position-y') . "'",
                ));
            }

            /*if(substr($this->params->getValue("custom-theme-link"), -1) != '/') {
                $this->params->set("custom-theme-link", $this->params->getValue("custom-theme-link") . '/');
            }

            if($this->params->checkValue('use-custom-theme', 'Yes')) {
                $conf = array_merge($conf, array(
                    "'arrow-top': '" . $this->params->getValue("custom-theme-link") . "top.png'",
                    "'arrow-right': '" . $this->params->getValue("custom-theme-link") . "right.png'",
                    "'arrow-bottom': '" . $this->params->getValue("custom-theme-link") . "bottom.png'",
                    "'arrow-left': '" . $this->params->getValue("custom-theme-link") . "left.png'",
                    "'arrow-reset': '" . $this->params->getValue("custom-theme-link") . "reset.png'",
                    "'plus-url': '" . $this->params->getValue("custom-theme-link") . "plus.png'",
                    "'minus-url': '" . $this->params->getValue("custom-theme-link") . "minus.png'",
                    "'nav-url': '" . $this->params->getValue("custom-theme-link") . "nav.png'",
                ));
            }*/
            if($this->params->getValue('fullscreen-only-image') != ''){
                $conf[] = "'fullscreen-only-image': '" . $this->params->getValue("fullscreen-only-image") . "'";
            }
            if($this->params->getValue('btn-fullscreen') != ''){
                $conf[] = "'btn-fullscreen': '" . $this->params->getValue("btn-fullscreen") . "'";
            }
            if($this->params->getValue('btn-close') != ''){
                $conf[] = "'btn-close': '" . $this->params->getValue("btn-close") . "'";
            }
            if($this->params->getValue('arrow-top') != ''){
                $conf[] = "'arrow-top': '" . $this->params->getValue("arrow-top") . "'";
            }
            if($this->params->getValue('arrow-bottom') != ''){
                $conf[] = "'arrow-bottom': '" . $this->params->getValue("arrow-bottom") . "'";
            }
            if($this->params->getValue('arrow-left') != ''){
                $conf[] = "'arrow-left': '" . $this->params->getValue("arrow-left") . "'";
            }
            if($this->params->getValue('arrow-right') != ''){
                $conf[] = "'arrow-right': '" . $this->params->getValue("arrow-right") . "'";
            }
            if($this->params->getValue('arrow-reset') != ''){
                $conf[] = "'arrow-reset': '" . $this->params->getValue("arrow-reset") . "'";
            }
            if($this->params->getValue('plus-url') != ''){
                $conf[] = "'plus-url': '" . $this->params->getValue("plus-url") . "'";
            }
            if($this->params->getValue('minus-url') != ''){
                $conf[] = "'minus-url': '" . $this->params->getValue("minus-url") . "'";
            }
            if($this->params->getValue('nav-url') != ''){
                $conf[] = "'nav-url': '" . $this->params->getValue("nav-url") . "'";
            }
            if($this->params->getValue('loader') != ''){
                $conf[] = "'loader': '" . $this->params->getValue("loader") . "'";
            }
            if($this->params->getValue('btn-close-big') != ''){
                $conf[] = "'btn-close-big': '" . $this->params->getValue("btn-close-big") . "'";
            }
            if($this->params->getValue('arrow-background') != ''){
                $conf[] = "'arrow-background': '" . $this->params->getValue("arrow-background") . "'";
            }
            if($this->params->getValue('btn-print') != ''){
                $conf[] = "'btn-print': '" . $this->params->getValue("btn-print") . "'";
            }

            if($notCheck) {
                $conf = array_merge($conf, array(
                    "'thumbnails-skip-default': " . $this->params->getValue("thumbnails-skip-default"),
                    "'save': " . $this->params->getValue("save"),
                    "'fullscreen': " . $this->params->getValue("fullscreen"),
                    "'fullscreen-only': " . $this->params->getValue("fullscreen-only"),
                    "'nav-show': " . $this->params->getValue("nav-show"),
                    "'arrow-show': " . $this->params->getValue("arrow-show")
                ));
                //if($this->params->getValue('watermark') != '') {
                //    $conf = array_merge($conf, array(
                //        "'watermark-normal': " . $this->params->getValue('watermark-normal'),
                //        "'watermark-fullscreen': " . $this->params->getValue('watermark-fullscreen'),
                //    ));
                //}
            } else {
                $conf = array_merge($conf, array(
                    "'thumbnails-skip-default': " . ($this->params->checkValue('thumbnails-skip-default', 'Yes')?'true':'false'),
                    "'save': " . ($this->params->checkValue('save', 'Yes')?'true':'false'),
                    "'fullscreen': " . ($this->params->checkValue('fullscreen', 'Yes')?'true':'false'),
                    "'fullscreen-only': " . ($this->params->checkValue('fullscreen-only', 'Yes')?'true':'false'),
                    "'nav-show': " . ($this->params->checkValue('nav-show', 'Yes')?'true':'false'),
                    "'arrow-show': " . ($this->params->checkValue('arrow-show', 'Yes')?'true':'false')
                ));
                //if($this->params->getValue('watermark') != '') {
                //    $conf = array_merge($conf, array(
                //        "'watermark-normal': " . ($this->params->checkValue('watermark-normal', 'Yes')?'true':'false'),
                //        "'watermark-fullscreen': " . ($this->params->checkValue('watermark-fullscreen', 'Yes')?'true':'false'),
                //    ));
                //}
            }

            $conf[] = "'engine': '" . $this->params->getValue("engine") . "'";
            if($this->params->getValue('stylesheet') != '') {
                $conf[] = "'stylesheet': '" . $this->params->getValue("stylesheet") . "'";
            }
            if($this->params->getValue('stylesheetMobile') != '') {
                $conf[] = "'stylesheetMobile': '" . $this->params->getValue("stylesheetMobile") . "'";
            }
            $conf[] = "'autostart': " . ($this->params->checkValue('autostart', 'Yes')?'true':'false');
            $conf[] = "'fullscreenHideControlsTimeout': " . $this->params->getValue("fullscreenHideControlsTimeout");
            $conf[] = "'fullscreenHideSelectorsTimeout': " . $this->params->getValue("fullscreenHideSelectorsTimeout");

            return $conf;

        }

        function template($params) {
            extract($params);

            if(!isset($alt) || empty($alt)) {
                $alt = '';
            } else {
                $alt = htmlspecialchars(htmlspecialchars_decode($alt, ENT_QUOTES));
            }
            if(!isset($title) || empty($title)) $title = '';
            if(empty($alt) && !empty($title)) $alt = htmlspecialchars(htmlspecialchars_decode($title, ENT_QUOTES));

            if(!isset($img) || empty($img)) return false;
            if(!isset($thumb) || empty($thumb)) $thumb = $img;
            if(!isset($id) || empty($id)) $id = md5($img);

            $this->id = $id;

            if(!isset($width) || empty($width)) $width = "";
            else $width = " width=\"{$width}\"";
            if(!isset($height) || empty($height)) $height = "";
            else $height = " height=\"{$height}\"";

            if($this->params->checkValue('show-message', 'Yes')) {
                $message = '<div class="MagicToolboxMessage">' . $this->params->getValue('message') . '</div>';
            } else $message = '';

            if($this->params->checkValue('unique-code', '')) {
                $message .= '<br /><b style="color:red">Please enter your unique code for JS file!</b>';
            }

            if(!empty($message)) $message = "<div style=\"text-align:center;\">{$message}</div>";

            $rel = $this->getRel();
            if(!empty($rel)) $rel = 'rel="'.$rel.'"';

            return "<a class=\"MagicTouch\" id=\"MagicTouchImage{$id}\" onclick=\"return false;\" href=\"{$img}\" {$rel}><img itemprop=\"image\"{$width}{$height} src=\"{$thumb}\" alt=\"{$alt}\" /></a><br />{$message}";
        }

        function subTemplate($params) {
            if($this->params->checkValue('use-selectors', 'No')) {
                $this->params->checkValue('show-message', 'No');
                return $this->template($params);
            } else {
                extract($params);

                if(!isset($alt) || empty($alt)) {
                    $alt = '';
                } else {
                    $alt = htmlspecialchars(htmlspecialchars_decode($alt, ENT_QUOTES));
                }
                if(!isset($title) || empty($title)) $title = '';
                if(empty($alt) && !empty($title)) $alt = htmlspecialchars(htmlspecialchars_decode($title, ENT_QUOTES));

                if(!isset($img) || empty($img)) return false;
                if(!isset($medium) || empty($medium)) $medium = $img;
                if(!isset($thumb) || empty($thumb)) $thumb = $img;
                if(!isset($id) || empty($id)) $id = $this->id;

                if(!isset($width) || empty($width)) $width = "";
                else $width = " width=\"{$width}\"";
                if(!isset($height) || empty($height)) $height = "";
                else $height = " height=\"{$height}\"";

                return "<a href=\"{$img}\" rel=\"MagicTouchImage{$id}\" rev=\"$medium\"><img{$width}{$height} src=\"{$thumb}\" alt=\"{$alt}\" /></a>";
            }
        }

        function getRel() {
            $rel = array();
            if(count($this->general->params)) {
                foreach($this->general->params as $name => $param) {
                    if($this->params->checkValue($name, $param['value'])) continue;
                    switch($name) {
                        case 'levels':
                            $rel[] = 'levels: ' . $this->params->getValue('levels');
                            break;
                        case 'border-width':
                            $rel[] = 'border-width: ' . $this->params->getValue('border-width');
                            break;
                        case 'border-color':
                            $rel[] = 'border-color: ' . $this->params->getValue('border-color');
                            break;
                        case 'progress-height':
                            $rel[] = 'progress-height: ' . $this->params->getValue('progress-height');
                            break;
                        case 'progress-color':
                            $rel[] = 'progress-color: ' . $this->params->getValue('progress-color');
                            break;
                        case 'fullscreen-btn-scale':
                            $rel[] = 'fullscreen-btn-scale: ' . $this->params->getValue('fullscreen-btn-scale');
                            break;
                        case 'button-position-y':
                            $rel[] = 'button-position-y: ' . $this->params->getValue('button-position-y');
                            break;
                        case 'button-position-x':
                            $rel[] = 'button-position-x: ' . $this->params->getValue('button-position-x');
                            break;
                        case 'button-margin':
                            $rel[] = 'button-margin: ' . $this->params->getValue('button-margin');
                            break;
                        case 'button-alpha':
                            $rel[] = 'button-alpha: ' . $this->params->getValue('button-alpha');
                            break;
                        case 'button-alpha-hover':
                            $rel[] = 'button-alpha-hover: ' . $this->params->getValue('button-alpha-hover');
                            break;
                        case 'button-orientation':
                            $rel[] = 'button-orientation: ' . $this->params->getValue('button-orientation');
                            break;
                        case 'button-padding':
                            $rel[] = 'button-padding: ' . $this->params->getValue('button-padding');
                            break;
                        case 'nav-alpha':
                            $rel[] = 'nav-alpha: ' . $this->params->getValue('nav-alpha');
                            break;
                        case 'preview-size':
                            $rel[] = 'preview-size: ' . $this->params->getValue('preview-size');
                            break;
                        case 'preview-alpha':
                            $rel[] = 'preview-alpha: ' . $this->params->getValue('preview-alpha');
                            break;
                        case 'preview-position-y':
                            $rel[] = 'preview-position-y: ' . $this->params->getValue('preview-position-y');
                            break;
                        case 'preview-position-x':
                            $rel[] = 'preview-position-x: ' . $this->params->getValue('preview-position-x');
                            break;
                        case 'preview-selection-alpha':
                            $rel[] = 'preview-selection-alpha: ' . $this->params->getValue('preview-selection-alpha');
                            break;
                        case 'arrow-move':
                            $rel[] = 'arrow-move: ' . $this->params->getValue('arrow-move');
                            break;
                        case 'arrow-position-x':
                            $rel[] = 'arrow-position-x: ' . $this->params->getValue('arrow-position-x');
                            break;
                        case 'arrow-position-y':
                            $rel[] = 'arrow-position-y: ' . $this->params->getValue('arrow-position-y');
                            break;
                        case 'arrow-alpha':
                            $rel[] = 'arrow-alpha: ' . $this->params->getValue('arrow-alpha');
                            break;
                        case 'arrow-alpha-hover':
                            $rel[] = 'arrow-alpha-hover: ' . $this->params->getValue('arrow-alpha-hover');
                            break;
                        case 'arrow-background-alpha':
                            $rel[] = 'arrow-background-alpha: ' . $this->params->getValue('arrow-background-alpha');
                            break;
                        case 'arrow-background-offset-x':
                            $rel[] = 'arrow-background-offset-x: ' . $this->params->getValue('arrow-background-offset-x');
                            break;
                        case 'arrow-background-offset-y':
                            $rel[] = 'arrow-background-offset-y: ' . $this->params->getValue('arrow-background-offset-y');
                            break;
                        case 'smoothing':
                            $rel[] = 'smoothing: ' . $this->params->getValue('smoothing');
                            break;
                        case 'background-color':
                            $rel[] = 'background-color: ' . $this->params->getValue('background-color');
                            break;
                        case 'theme-url':
                            $rel[] = 'theme-url: ' . $this->params->getValue('theme-url');
                            break;
                        case 'thumbnails-position':
                            $rel[] = 'thumbnails-position: ' . $this->params->getValue('thumbnails-position');
                            break;
                        case 'thumbnails-alpha':
                            $rel[] = 'thumbnails-alpha: ' . $this->params->getValue('thumbnails-alpha');
                            break;
                        case 'thumbnails-alpha-hover':
                            $rel[] = 'thumbnails-alpha-hover: ' . $this->params->getValue('thumbnails-alpha-hover');
                            break;
                        case 'thumbnails-padding':
                            $rel[] = 'thumbnails-padding: ' . $this->params->getValue('thumbnails-padding');
                            break;
                        case 'thumbnails-border-color':
                            $rel[] = 'thumbnails-border-color: ' . $this->params->getValue('thumbnails-border-color');
                            break;
                        case 'thumbnails-border-width':
                            $rel[] = 'thumbnails-border-width: ' . $this->params->getValue('thumbnails-border-width');
                            break;
                        case 'thumbnails-max-height':
                            $rel[] = 'thumbnails-max-height: ' . $this->params->getValue('thumbnails-max-height');
                            break;
                        case 'thumbnails-max-width':
                            $rel[] = 'thumbnails-max-width: ' . $this->params->getValue('thumbnails-max-width');
                            break;
                        case 'print':
                            if($this->params->checkValue('print', 'no')) {
                                $rel[] = 'print: ' . $this->params->getValue('print');
                            }
                            break;
                        //case 'watermark':
                        //    if($this->params->getValue('watermark') != '') {
                        //        $rel[] = 'watermark: ' . $this->params->getValue('watermark');
                        //    }
                        //    break;
                        //case 'watermark-alpha':
                        //    if($this->params->getValue('watermark') != '') {
                        //        $rel[] = 'watermark-alpha: ' . $this->params->getValue('watermark-alpha');
                        //    }
                        //    break;
                        case 'custom-logo':
                            if($this->params->getValue('custom-logo') != '') {
                                $rel[] = 'custom-logo: ' . $this->params->getValue('custom-logo');
                            }
                            break;
                        case 'custom-logo-position-x':
                            if($this->params->getValue('custom-logo') != '') {
                                $rel[] = 'custom-logo-position-x: ' . $this->params->getValue('custom-logo-position-x');
                            }
                            break;
                        case 'custom-logo-position-y':
                            if($this->params->getValue('custom-logo') != '') {
                                $rel[] = 'custom-logo-position-y: ' . $this->params->getValue('custom-logo-position-y');
                            }
                            break;
                        case 'fullscreen-only-image':
                            if($this->params->getValue('fullscreen-only-image') != ''){
                                $rel[] = 'fullscreen-only-image: ' . $this->params->getValue('fullscreen-only-image');
                            }
                            break;
                        case 'btn-fullscreen':
                            if($this->params->getValue('btn-fullscreen') != ''){
                                $rel[] = 'btn-fullscreen: ' . $this->params->getValue('btn-fullscreen');
                            }
                            break;
                        case 'btn-close':
                            if($this->params->getValue('btn-close') != ''){
                                $rel[] = 'btn-close: ' . $this->params->getValue('btn-close');
                            }
                            break;
                        case 'arrow-top':
                            if($this->params->getValue('arrow-top') != ''){
                                $rel[] = 'arrow-top: ' . $this->params->getValue('arrow-top');
                            }
                            break;
                        case 'arrow-bottom':
                            if($this->params->getValue('arrow-bottom') != ''){
                                $rel[] = 'arrow-bottom: ' . $this->params->getValue('arrow-bottom');
                            }
                            break;
                        case 'arrow-left':
                            if($this->params->getValue('arrow-left') != ''){
                                $rel[] = 'arrow-left: ' . $this->params->getValue('arrow-left');
                            }
                            break;
                        case 'arrow-right':
                            if($this->params->getValue('arrow-right') != ''){
                                $rel[] = 'arrow-right: ' . $this->params->getValue('arrow-right');
                            }
                            break;
                        case 'arrow-reset':
                            if($this->params->getValue('arrow-reset') != ''){
                                $rel[] = 'arrow-reset: ' . $this->params->getValue('arrow-reset');
                            }
                            break;
                        case 'plus-url':
                            if($this->params->getValue('plus-url') != ''){
                                $rel[] = 'plus-url: ' . $this->params->getValue('plus-url');
                            }
                            break;
                        case 'minus-url':
                            if($this->params->getValue('minus-url') != ''){
                                $rel[] = 'minus-url: ' . $this->params->getValue('minus-url');
                            }
                            break;
                        case 'nav-url':
                            if($this->params->getValue('nav-url') != ''){
                                $rel[] = 'nav-url: ' . $this->params->getValue('nav-url');
                            }
                            break;
                        case 'loader':
                            if($this->params->getValue('loader') != ''){
                                $rel[] = 'loader: ' . $this->params->getValue('loader');
                            }
                            break;
                        case 'btn-close-big':
                            if($this->params->getValue('btn-close-big') != ''){
                                $rel[] = 'btn-close-big: ' . $this->params->getValue('btn-close-big');
                            }
                            break;
                        case 'arrow-background':
                            if($this->params->getValue('arrow-background') != ''){
                                $rel[] = 'arrow-background: ' . $this->params->getValue('arrow-background');
                            }
                            break;
                        case 'btn-print':
                            if($this->params->getValue('btn-print') != ''){
                                $rel[] = 'btn-print: ' . $this->params->getValue('btn-print');
                            }
                            break;
                        case 'thumbnails-skip-default':
                            $rel[] = 'thumbnails-skip-default: ' . ($this->params->checkValue('thumbnails-skip-default', 'Yes')?'true':'false');
                            break;
                        case 'save':
                            $rel[] = 'save: ' . ($this->params->checkValue('save', 'Yes')?'true':'false');
                            break;
                        case 'fullscreen':
                            $rel[] = 'fullscreen: ' . ($this->params->checkValue('fullscreen', 'Yes')?'true':'false');
                            break;
                        case 'fullscreen-only':
                            $rel[] = 'fullscreen-only: ' . ($this->params->checkValue('fullscreen-only', 'Yes')?'true':'false');
                            break;
                        case 'nav-show':
                            $rel[] = 'nav-show: ' . ($this->params->checkValue('nav-show', 'Yes')?'true':'false');
                            break;
                        case 'arrow-show':
                            $rel[] = 'arrow-show: ' . ($this->params->checkValue('arrow-show', 'Yes')?'true':'false');
                            break;
                        //case 'watermark-normal':
                        //    if($this->params->getValue('watermark') != '') {
                        //        $rel[] = 'watermark-normal: ' . ($this->params->checkValue('watermark-normal', 'Yes')?'true':'false');
                        //    }
                        //    break;
                        //case 'watermark-fullscreen':
                        //    if($this->params->getValue('watermark') != '') {
                        //        $rel[] = 'watermark-fullscreen: ' . ($this->params->checkValue('watermark-fullscreen', 'Yes')?'true':'false');
                        //    }
                        //    break;
                        case 'autostart':
                            $rel[] = 'autostart: ' . ($this->params->checkValue('autostart', 'Yes')?'true':'false');
                            break;
                        case 'fullscreenHideControlsTimeout':
                            $rel[] = 'fullscreenHideControlsTimeout: ' . $this->params->getValue('fullscreenHideControlsTimeout');
                            break;
                        case 'fullscreenHideSelectorsTimeout':
                            $rel[] = 'fullscreenHideSelectorsTimeout: ' . $this->params->getValue('fullscreenHideSelectorsTimeout');
                            break;
                    }
                }
            }
            if(count($rel)) {
                $rel = implode(';',$rel) . ';';
            } else {
                $rel = '';
            }
            return $rel;
        }

//         function getRel($notCheck = false) {
//             return '';
//         }

        function addonsTemplate() {
            return '';
        }

        function _paramDefaults() {
            $params = array("unique-code"=>array("id"=>"unique-code","group"=>"General","order"=>"1","default"=>"","label"=>"Unique ID for Magic Touch™","type"=>"text"),"engine"=>array("id"=>"engine","group"=>"General","order"=>"2","default"=>"Flash","label"=>"Magic Touch engine","type"=>"array","subType"=>"radio","values"=>array("Flash","JS"),"scope"=>"tool"),"stylesheet"=>array("id"=>"stylesheet","group"=>"General","order"=>"3","default"=>"","label"=>"URL of stylesheet file for desktop browsers","type"=>"text","scope"=>"tool"),"stylesheetMobile"=>array("id"=>"stylesheetMobile","group"=>"General","order"=>"4","default"=>"","label"=>"URL of stylesheet file for mobile browsers","type"=>"text","scope"=>"tool"),"smoothing"=>array("id"=>"smoothing","group"=>"Effects","order"=>"170","default"=>"8","label"=>"Smooth the movement when dragging image","type"=>"num","scope"=>"tool"),"use-selectors"=>array("id"=>"use-selectors","group"=>"Multiple images","order"=>"100","default"=>"Yes","label"=>"Use additional images as selectors?","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),"thumbnails-skip-default"=>array("id"=>"thumbnails-skip-default","group"=>"Thumbnails","order"=>"70","default"=>"No","label"=>"Don't create thumbnail for main image","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"thumbnails-position"=>array("id"=>"thumbnails-position","group"=>"Thumbnails","order"=>"80","default"=>"bottom","label"=>"Position of thumbnails in full-screen view","type"=>"array","subType"=>"select","values"=>array("top","bottom","right","left"),"scope"=>"tool"),"thumbnails-max-width"=>array("id"=>"thumbnails-max-width","group"=>"Thumbnails","order"=>"90","default"=>"0","label"=>"Max width of thumbnails in full-screen view (0 = none)","type"=>"num","scope"=>"tool"),"thumbnails-max-height"=>array("id"=>"thumbnails-max-height","group"=>"Thumbnails","order"=>"100","default"=>"0","label"=>"Max height of thumbnails in full-screen view (0 = none)","type"=>"num","scope"=>"tool"),"thumbnails-border-width"=>array("id"=>"thumbnails-border-width","group"=>"Thumbnails","order"=>"110","default"=>"1","label"=>"Thumbnail border width","type"=>"num","scope"=>"tool"),"thumbnails-border-color"=>array("id"=>"thumbnails-border-color","group"=>"Thumbnails","order"=>"120","default"=>"#c2c2c2","label"=>"Thumbnail border color","type"=>"text","scope"=>"tool"),"thumbnails-padding"=>array("id"=>"thumbnails-padding","group"=>"Thumbnails","order"=>"130","default"=>"10","label"=>"Padding of thumbnails","type"=>"num","scope"=>"tool"),"thumbnails-alpha"=>array("id"=>"thumbnails-alpha","group"=>"Thumbnails","order"=>"140","default"=>"70","label"=>"Opacity of thumbnails in full-screen view","type"=>"num","scope"=>"tool"),"thumbnails-alpha-hover"=>array("id"=>"thumbnails-alpha-hover","group"=>"Thumbnails","order"=>"150","default"=>"100","label"=>"Hover-opacity of thumbnails","type"=>"num","scope"=>"tool"),"levels"=>array("id"=>"levels","group"=>"Zoom","order"=>"10","default"=>"4","label"=>"Quantity of zoom levels (2-9)","type"=>"num","scope"=>"tool"),"class"=>array("id"=>"class","group"=>"Miscellaneous","order"=>"20","default"=>"MagicTouch","label"=>"Class Name","type"=>"array","subType"=>"select","values"=>array("all","MagicTouch")),"nextgen-gallery"=>array("id"=>"nextgen-gallery","group"=>"Miscellaneous","order"=>"24","default"=>"No","label"=>"Apply effect to NextGen gallery images","type"=>"array","subType"=>"select","values"=>array("Yes","No")),"show-message"=>array("id"=>"show-message","group"=>"Miscellaneous","order"=>"270","default"=>"Yes","label"=>"Show message under image?","type"=>"array","subType"=>"radio","values"=>array("Yes","No")),"message"=>array("id"=>"message","group"=>"Miscellaneous","order"=>"280","default"=>"Click to zoom in.","label"=>"Message under images","type"=>"text"),"loader"=>array("id"=>"loader","group"=>"Miscellaneous","order"=>"300","default"=>"","label"=>"Loader image","description"=>"Choose your own image (e.g. http://www.example.com/loader.png)","type"=>"text","scope"=>"tool"),"save"=>array("id"=>"save","group"=>"Miscellaneous","order"=>"310","default"=>"No","label"=>"Right click option to 'Save image'","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"btn-print"=>array("id"=>"btn-print","group"=>"Miscellaneous","order"=>"320","default"=>"","label"=>"Print button","description"=>"Choose your own image (e.g. http://www.example.com/print.png)","type"=>"text","scope"=>"tool"),"print"=>array("id"=>"print","group"=>"Miscellaneous","order"=>"330","default"=>"no","label"=>"Shows a button to print the image","type"=>"array","subType"=>"select","values"=>array("no","entire","part"),"scope"=>"tool"),"theme-url"=>array("id"=>"theme-url","group"=>"Miscellaneous","order"=>"340","default"=>"","label"=>"Choose a different theme for buttons","description"=>"(8 more themes you can found here: http://www.magictoolbox.com/magictouch_integration/#themes)","type"=>"text","scope"=>"tool"),"autostart"=>array("id"=>"autostart","group"=>"Miscellaneous","order"=>"350","default"=>"Yes","label"=>"Should Magic Touch start on domready?","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"background-color"=>array("id"=>"background-color","group"=>"Background, borders and progress bar","order"=>"10","default"=>"#FFFFFF","label"=>"Background colour for full-screen mode (RGB)","type"=>"text","scope"=>"tool"),"border-color"=>array("id"=>"border-color","group"=>"Background, borders and progress bar","order"=>"20","default"=>"#c2c2c2","label"=>"Border color (RGB)","type"=>"text","scope"=>"tool"),"border-width"=>array("id"=>"border-width","group"=>"Background, borders and progress bar","order"=>"30","default"=>"0","label"=>"Border width in pixels (0=none)","type"=>"num","scope"=>"tool"),"progress-height"=>array("id"=>"progress-height","group"=>"Background, borders and progress bar","order"=>"40","default"=>"10","label"=>"Progress bar height in pixels (0=off)","type"=>"num","scope"=>"tool"),"progress-color"=>array("id"=>"progress-color","group"=>"Background, borders and progress bar","order"=>"50","default"=>"#c2c2c2","label"=>"Progress bar color (RGB)","type"=>"text","scope"=>"tool"),"nav-show"=>array("id"=>"nav-show","group"=>"Buttons","order"=>"35","default"=>"Yes","label"=>"Show navigation buttons","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"nav-alpha"=>array("id"=>"nav-alpha","group"=>"Buttons","order"=>"40","default"=>"30","label"=>"Nav button transparency (0-100)","type"=>"num","scope"=>"tool"),"plus-url"=>array("id"=>"plus-url","group"=>"Buttons","order"=>"50","default"=>"","label"=>"Plus button","description"=>"Choose your own image (e.g. http://www.example.com/plus.png)","type"=>"text","scope"=>"tool"),"minus-url"=>array("id"=>"minus-url","group"=>"Buttons","order"=>"60","default"=>"","label"=>"Minus button","description"=>"Choose your own image (e.g. http://www.example.com/minus.png)","type"=>"text","scope"=>"tool"),"nav-url"=>array("id"=>"nav-url","group"=>"Buttons","order"=>"70","default"=>"","label"=>"Navigation button","description"=>"Choose your own image (e.g. http://www.example.com/nav.png)","type"=>"text","scope"=>"tool"),"button-orientation"=>array("id"=>"button-orientation","group"=>"Buttons","order"=>"75","default"=>"vertical","label"=>"Buttons in a row (vertical or horizontal)","type"=>"array","subType"=>"select","values"=>array("vertical","horizontal"),"scope"=>"tool"),"button-position-x"=>array("id"=>"button-position-x","group"=>"Buttons","order"=>"80","default"=>"left","label"=>"Position of the +/- buttons (left or right)","type"=>"array","subType"=>"select","values"=>array("left","right"),"scope"=>"tool"),"button-position-y"=>array("id"=>"button-position-y","group"=>"Buttons","order"=>"90","default"=>"top","label"=>"Position of the +/- buttons (top or bottom)","type"=>"array","subType"=>"select","values"=>array("top","bottom"),"scope"=>"tool"),"button-padding"=>array("id"=>"button-padding","group"=>"Buttons","order"=>"100","default"=>"2","label"=>"Distance between + and - buttons, in pixels","type"=>"num","scope"=>"tool"),"button-margin"=>array("id"=>"button-margin","group"=>"Buttons","order"=>"110","default"=>"10","label"=>"Distance of buttons from edges, in pixels","type"=>"num","scope"=>"tool"),"button-alpha"=>array("id"=>"button-alpha","group"=>"Buttons","order"=>"130","default"=>"70","label"=>"Button transparency (0-100)","type"=>"num","scope"=>"tool"),"button-alpha-hover"=>array("id"=>"button-alpha-hover","group"=>"Buttons","order"=>"140","default"=>"100","label"=>"Button transparency on mouseover (0-100)","type"=>"num","scope"=>"tool"),"fullscreen"=>array("id"=>"fullscreen","group"=>"Full-screen","order"=>"10","default"=>"Yes","label"=>"Full-screen feature","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"btn-fullscreen"=>array("id"=>"btn-fullscreen","group"=>"Full-screen","order"=>"20","default"=>"","label"=>"Fullscreen button","description"=>"Choose your own image (e.g. http://www.example.com/fullscreen.png)","type"=>"text","scope"=>"tool"),"btn-close"=>array("id"=>"btn-close","group"=>"Full-screen","order"=>"30","default"=>"","label"=>"Close button","description"=>"Choose your own image (e.g. http://www.example.com/close.png)","type"=>"text","scope"=>"tool"),"btn-close-big"=>array("id"=>"btn-close-big","group"=>"Full-screen","order"=>"40","default"=>"","label"=>"Big close button","description"=>"Choose your own image (e.g. http://www.example.com/close-big.png)","type"=>"text","scope"=>"tool"),"fullscreen-btn-scale"=>array("id"=>"fullscreen-btn-scale","group"=>"Full-screen","order"=>"50","default"=>"1.3","label"=>"Size of buttons on full-screen (0-1)","type"=>"num","scope"=>"tool"),"fullscreen-only"=>array("id"=>"fullscreen-only","group"=>"Full-screen","order"=>"60","default"=>"No","label"=>"Click anywhere on image to activate fullscreen","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"fullscreen-only-image"=>array("id"=>"fullscreen-only-image","group"=>"Full-screen","order"=>"70","default"=>"","label"=>"Button for fullscreen-only","description"=>"Choose your own image (e.g. http://www.example.com/fullscreen-only.png)","type"=>"text","scope"=>"tool"),"fullscreenHideControlsTimeout"=>array("id"=>"fullscreenHideControlsTimeout","group"=>"Full-screen","order"=>"80","default"=>"4000","label"=>"Timeout to hide preview, arrows, etc in fullscreen mode (in milliseconds)","type"=>"num","scope"=>"tool"),"fullscreenHideSelectorsTimeout"=>array("id"=>"fullscreenHideSelectorsTimeout","group"=>"Full-screen","order"=>"90","default"=>"3000","label"=>"Timeout to hide thumbnails in fullscreen mode (in milliseconds)","type"=>"num","scope"=>"tool"),"preview-size"=>array("id"=>"preview-size","group"=>"Preview area","order"=>"10","default"=>"25","label"=>" Size of the preview area as a ratio (0-100)","type"=>"num","scope"=>"tool"),"preview-position-x"=>array("id"=>"preview-position-x","group"=>"Preview area","order"=>"20","default"=>"left","label"=>"Horizontal position of preview (left or right)","type"=>"array","subType"=>"select","values"=>array("left","right"),"scope"=>"tool"),"preview-position-y"=>array("id"=>"preview-position-y","group"=>"Preview area","order"=>"30","default"=>"bottom","label"=>"Vertical position of preview (top or bottom)","type"=>"array","subType"=>"select","values"=>array("top","bottom"),"scope"=>"tool"),"preview-alpha"=>array("id"=>"preview-alpha","group"=>"Preview area","order"=>"40","default"=>"50","label"=>"Preview area transparency (0-100)","type"=>"num","scope"=>"tool"),"preview-selection-alpha"=>array("id"=>"preview-selection-alpha","group"=>"Preview area","order"=>"50","default"=>"75","label"=>"Opacity of rectangle within preview (0-100)","type"=>"num","scope"=>"tool"),"arrow-show"=>array("id"=>"arrow-show","group"=>"Arrows","order"=>"40","default"=>"Yes","label"=>"Show arrows","type"=>"array","subType"=>"radio","values"=>array("Yes","No"),"scope"=>"tool"),"arrow-position-x"=>array("id"=>"arrow-position-x","group"=>"Arrows","order"=>"50","default"=>"right","label"=>"Horizontal position of arrows (left or right)","type"=>"array","subType"=>"select","values"=>array("left","right"),"scope"=>"tool"),"arrow-position-y"=>array("id"=>"arrow-position-y","group"=>"Arrows","order"=>"60","default"=>"bottom","label"=>"Vertical position of arrows (top or bottom)","type"=>"array","subType"=>"select","values"=>array("top","bottom"),"scope"=>"tool"),"arrow-background"=>array("id"=>"arrow-background","group"=>"Arrows","order"=>"70","default"=>"","label"=>"Arrows background image","description"=>"Choose your own image (e.g. http://www.example.com/arrow-background.png)","type"=>"text","scope"=>"tool"),"arrow-background-offset-x"=>array("id"=>"arrow-background-offset-x","group"=>"Arrows","order"=>"80","default"=>"0","label"=>"Arrows background horizontal offset, in pixels","type"=>"num","scope"=>"tool"),"arrow-background-offset-y"=>array("id"=>"arrow-background-offset-y","group"=>"Arrows","order"=>"90","default"=>"0","label"=>"Arrows background horizontal offset, in pixels","type"=>"num","scope"=>"tool"),"arrow-alpha"=>array("id"=>"arrow-alpha","group"=>"Arrows","order"=>"100","default"=>"70","label"=>"Arrows transparency (0-100)","type"=>"num","scope"=>"tool"),"arrow-alpha-hover"=>array("id"=>"arrow-alpha-hover","group"=>"Arrows","order"=>"110","default"=>"100","label"=>"Arrows transparency on mouseover (0-100)","type"=>"num","scope"=>"tool"),"arrow-background-alpha"=>array("id"=>"arrow-background-alpha","group"=>"Arrows","order"=>"120","default"=>"70","label"=>"Arrows background transparency (0-100)","type"=>"num","scope"=>"tool"),"arrow-move"=>array("id"=>"arrow-move","group"=>"Arrows","order"=>"130","default"=>"40","label"=>"Amount of movement on arrow click, in pixels","type"=>"num","scope"=>"tool"),"arrow-top"=>array("id"=>"arrow-top","group"=>"Arrows","order"=>"140","default"=>"","label"=>"Arrow top","description"=>"Choose your own image (e.g. http://www.example.com/top.png)","type"=>"text","scope"=>"tool"),"arrow-right"=>array("id"=>"arrow-right","group"=>"Arrows","order"=>"150","default"=>"","label"=>"Arrow right","description"=>"Choose your own image (e.g. http://www.example.com/right.png)","type"=>"text","scope"=>"tool"),"arrow-bottom"=>array("id"=>"arrow-bottom","group"=>"Arrows","order"=>"160","default"=>"","label"=>"Arrow bottom","description"=>"Choose your own image (e.g. http://www.example.com/bottom.png)","type"=>"text","scope"=>"tool"),"arrow-left"=>array("id"=>"arrow-left","group"=>"Arrows","order"=>"170","default"=>"","label"=>"Arrow left","description"=>"Choose your own image (e.g. http://www.example.com/left.png)","type"=>"text","scope"=>"tool"),"arrow-reset"=>array("id"=>"arrow-reset","group"=>"Arrows","order"=>"180","default"=>"","label"=>"Reset button","description"=>"Choose your own image (e.g. http://www.example.com/reset.png)","type"=>"text","scope"=>"tool"),"custom-logo"=>array("id"=>"custom-logo","group"=>"Custom logo","order"=>"10","default"=>"","label"=>"Choose your own logo (paid users only)","description"=>"e.g. http://www.example.com/logo.png","type"=>"text","scope"=>"tool"),"custom-logo-position-x"=>array("id"=>"custom-logo-position-x","group"=>"Custom logo","order"=>"20","default"=>"right","label"=>"Your logo position","type"=>"array","subType"=>"select","values"=>array("left","right"),"scope"=>"tool"),"custom-logo-position-y"=>array("id"=>"custom-logo-position-y","group"=>"Custom logo","order"=>"30","default"=>"top","label"=>"Your logo position","type"=>"array","subType"=>"select","values"=>array("top","bottom"),"scope"=>"tool"));
            $this->params->appendArray($params);
        }
    }

}
?>
