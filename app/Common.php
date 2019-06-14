<?php

namespace App;

use App\Hash;
use Illuminate\Support\Facades\DB;

class Common {





    // Calling this method will return a 5-digit, alphanumeric (mixed-case) string "hash" that is unique to this
    // application. Can be used as an ID to identify each button/dome image
    public static function get_new_hash() {

        // Start with a clean slate
        $hash_id = null;

        // Define a universe of characters to be used
        $universe = "abcdef0123456789";

        // In the event a duplicate code is generated, this loop serves as a safety net.
        // (A 5-digit hash_id can support over 1 MILLION possibilities)
        for ($x = 0; $x < 100; $x++) {

            $new_hash = null;

            // Loop
            for ($y = 0; $y < 5; $y++) {

                // Grab a random number within the range
                $rand = mt_rand(0, 15);

                // Repeatedly append it, to form a new "hash"
                $new_hash .= $universe[$rand];
            }

            // Query DB to see if the new_hash has already been used
            // NOTE: utf8_bin collation and indexing should be set on this column
            $id = Hash::where('hash', '=', $new_hash)
                ->limit(1)
                ->get();

            // If no length to the return, it's unique. Bust out of this loop
            if (!count($id)) {
                break;
            }
        }

        // Insert this new hash into the DB so it can't get reused
        $unique_hash = new Hash;
        $unique_hash->hash = $new_hash;
        $unique_hash->save();

        // Return the newly generated hash_id
        return $new_hash;
    }





}
