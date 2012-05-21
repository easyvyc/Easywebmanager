<?php
function generatePassword($plength)
{

	// First we need to validate the argument that was given to this function
	// If need be, we will change it to a more appropriate value.
	if(!is_numeric($plength) || $plength <= 0)
    {
        $plength = 8;
    }
    if($plength > 32)
    {
        $plength = 32;
    }

	// This is the array of allowable characters.  The ones in this array
	// are restricted to alphanumeric.
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	
	// This is important:  we need to seed the random number generator
	mt_srand(microtime() * 1000000);

    // Now we simply generate a random string based on the length that was
    // requested in the function argument
    for($i = 0; $i < $plength; $i++)
    {
        $key = mt_rand(0,strlen($chars)-1);
        $pwd = $pwd . $chars{$key};
    }

    // Finally to make it a bit more random, we switch some characters around
    for($i = 0; $i < $plength; $i++)
    {
        $key1 = mt_rand(0,strlen($pwd)-1);
        $key2 = mt_rand(0,strlen($pwd)-1);

        $tmp = $pwd{$key1};
        $pwd{$key1} = $pwd{$key2};
        $pwd{$key2} = $tmp;
    }

    return $pwd;
}
?>