<?php
$all = $user->all();
foreach ($all as $item) {
    echo $item->first_name . ' ' . $item->last_name . '<br>';
}