<?php

namespace Enum;

enum Login: string
{
    case LoginFailed = 'The username or password is incorrect.';
    case Logout = 'You have been logged out.';
}
