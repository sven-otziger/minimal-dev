<?php

namespace Exception;

class InexistentUserException extends UserException
{
	protected $message = "The user you would like to call does not exist.";

}