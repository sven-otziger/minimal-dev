<?php

namespace Exception;

class ShortPasswordException extends PasswordException
{
	protected $message = 'The chosen password is too short. It needs to be at least 8 characters long.';
}
