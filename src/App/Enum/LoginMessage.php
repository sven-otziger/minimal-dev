<?php

namespace Enum;

enum LoginMessage: string
{
    case None = '';
    case LoginFailed = 'The username or password is incorrect.';
    case Logout = 'You have been logged out.';
    case NotLoggedIn = 'Please log in to visit this page.';
    case Inactivity = 'You have been logged out due to inactivity.';
    case Deleted = 'Your account has been successfully deleted.';
}
