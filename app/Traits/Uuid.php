<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid as UuidUuid;
trait Uuid
{
    public static function getByUUID($uuid)
    {
        $result = null;
        if(UuidUuid::isValid($uuid)){
            $result = self::where('uuid', $uuid)->first();
            if(empty($result)){
                $result = null;
            }
        }
        return $result;
    }
    
    public static function getIdByUUID($uuid)
    {
        $result = self::where('uuid', $uuid)->first();
        $id = null;
        if ($result) 
            $id = $result->id;

        return $id;
    }

}