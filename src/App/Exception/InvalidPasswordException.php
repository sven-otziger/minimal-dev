<?php

namespace Exception;

class InvalidPasswordException extends UserException
{
	protected $message = 'The password needs to contain at least one lowercase letter, one uppercase letter, one number and one special character.';
}
