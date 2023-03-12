<?php

namespace Sparkly\Framework\Foundation;

enum Path: string
{
    case BASE_PATH = '';
    case LOG_PATH = 'var/log/';
    case CACHE_PATH = 'var/cache/';
    case CONFIG_PATH = 'app/config/';
    case PLUGIN_PATH = 'app/custom/plugins/';
    case THEME_PATH = 'app/custom/theme/';
}
