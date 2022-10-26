<?php

namespace Enum;

enum SessionStatus: string
{
    case NotLoggedIn = 'Please log in to visit this page.';
    case Expired = 'You have been logged out due to inactivity.';
    case Discontinued = 'Your account seems to be discontinued.';
    case LoggedIn = 'Your session is active at the moment';
}
