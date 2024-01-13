<?php

if (! function_exists('layoutConfig')) {
    function layoutConfig()
    {

        if (Request::is('modern-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');

        } elseif (Request::is('modern-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vdm');

        } elseif (Request::is('collapsible-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.cm');

        } elseif (Request::is('horizontal-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm');

        } elseif (Request::is('horizontal-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm');

        }

        // RTL

        elseif (Request::is('rtl/modern-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vlm-rtl');

        } elseif (Request::is('rtl/modern-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.vdm-rtl');

        } elseif (Request::is('rtl/collapsible-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.cm-rtl');

        } elseif (Request::is('rtl/horizontal-light-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hlm-rtl');

        } elseif (Request::is('rtl/horizontal-dark-menu/*')) {

            $__getConfiguration = Config::get('app-config.layout.hdm-rtl');

        }

        // Login

        elseif (Request::is('login')) {

            $__getConfiguration = Config::get('app-config.layout.vlm');

        } else {
            $__getConfiguration = Config::get('barebone-config.layout.bb');
        }

        return $__getConfiguration;
    }
}

if (! function_exists('getRouterValue')) {
    function getRouterValue()
    {

        if (Request::is('modern-light-menu/*')) {

            $__getRoutingValue = '/modern-light-menu';

        } elseif (Request::is('modern-dark-menu/*')) {

            $__getRoutingValue = '/modern-dark-menu';

        } elseif (Request::is('collapsible-menu/*')) {

            $__getRoutingValue = '/collapsible-menu';

        } elseif (Request::is('horizontal-light-menu/*')) {

            $__getRoutingValue = '/horizontal-light-menu';

        } elseif (Request::is('horizontal-dark-menu/*')) {

            $__getRoutingValue = '/horizontal-dark-menu';

        }

        // RTL

        elseif (Request::is('rtl/modern-light-menu/*')) {

            $__getRoutingValue = '/rtl/modern-light-menu';

        } elseif (Request::is('rtl/modern-dark-menu/*')) {

            $__getRoutingValue = '/rtl/modern-dark-menu';

        } elseif (Request::is('rtl/collapsible-menu/*')) {

            $__getRoutingValue = '/rtl/collapsible-menu';

        } elseif (Request::is('rtl/horizontal-light-menu/*')) {

            $__getRoutingValue = '/rtl/horizontal-light-menu';

        } elseif (Request::is('rtl/horizontal-dark-menu/*')) {

            $__getRoutingValue = '/rtl/horizontal-dark-menu';

        }

        // Login

        elseif (Request::is('login')) {

            $__getRoutingValue = '/modern-light-menu';

        } else {
            $__getRoutingValue = '';
        }

        return $__getRoutingValue;
    }
}
