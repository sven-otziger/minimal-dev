<?php

namespace Controller;

enum MessageType
{
    case None;
    case LoginFailed;
    case Logout;
}