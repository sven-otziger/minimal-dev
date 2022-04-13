<?php

$movie1 = new \Retro\Serialization\Movie("The Shawshank Redemption", "Frank Darabont",
	["Morgan Freeman", "Tim Robbins", "Bob Gunton"], 1994, 144);
$movie2 = new \Retro\Serialization\Movie("The Green Mile", "Frank Darabont",
	["Tom Hanks", "Michael Clarke Duncan", "Sam Rockwell"], 1999, 189);

$serMovie1 = serialize($movie1);
$serMovie2 = serialize($movie2);

$unserMovie1 = unserialize($serMovie1);
$unserMovie2 = unserialize($serMovie2);

print("<pre>" . print_r($movie1, true) . "</pre><br><br>");
print("<pre>" . print_r($movie2, true) . "</pre><br><br>");
print("<pre>" . print_r($serMovie1, true) . "</pre><br><br>");
print("<pre>" . print_r($serMovie2, true) . "</pre><br><br>");
print("<pre>" . print_r($unserMovie1, true) . "</pre><br><br>");
print("<pre>" . print_r($unserMovie2, true) . "</pre><br><br>");
