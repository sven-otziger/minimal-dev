<?php

$pc = new Retro\Namespaces\PC\Screen("Dell", "28 XYZ", 400);
$tv = new Retro\Namespaces\TV\Screen("Samsung", "QE-50Q60A", 499);

echo "PC: {$pc->brand}<br><br>";
echo "PC: {$tv->brand}<br><br>";
