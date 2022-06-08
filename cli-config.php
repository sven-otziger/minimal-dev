<?php

// cli-config.php
require_once "public/index.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($em);