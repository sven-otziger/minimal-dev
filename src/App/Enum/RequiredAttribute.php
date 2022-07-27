<?php

namespace Enum;

Enum RequiredAttribute: string
{
    case Username = "SELECT username FROM user WHERE id = :id";
    case Password = "SELECT password FROM user WHERE id = :id";
    case IsDeleted = "SELECT deleted FROM user WHERE id = :id";
}