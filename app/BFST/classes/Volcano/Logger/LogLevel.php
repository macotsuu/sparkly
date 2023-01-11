<?php

namespace Volcano\Logger;

enum LogLevel: int
{
    case DEBUG = 100;
    case INFO = 200;
    case WARNING = 300;
    case ERROR = 400;
    case CRITICAL = 500;
}
