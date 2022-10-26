<?php

namespace Enum;

enum Account: string
{
    case Deleted = 'Your account has been successfully deleted.';
    case DeletedForeign = 'The selected account has been deleted.';
}
