<?php
use Illuminate\Support\Facades\DB;


DB::listen(function($sql, $bindings, $time)
{
file_put_contents('php://stdout', "[SQL] {$sql} \n" .
"      bindings:\t".json_encode($bindings)."\n".
"      time:\t{$time} milliseconds\n");
});


