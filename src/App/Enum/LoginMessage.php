<?php

namespace Enum;

enum LoginMessage: string
{
    case None = '';
    case LoginFailed = 'The username or password is incorrect.';
    case Logout = 'You have been logged out.';
}