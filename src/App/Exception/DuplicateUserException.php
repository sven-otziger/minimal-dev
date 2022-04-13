<?php

namespace Exception;

class DuplicateUserException extends UserException
{
	protected $message = "This username has already been chosen. Please choose another one.";
}
