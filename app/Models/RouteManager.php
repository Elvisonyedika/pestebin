<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nette\Utils\Random;

class RouteManager extends Model
{
    use HasFactory;

    /**
     * Generate a shortUrl
     * @return string shortUrl
     */
    public function generate(): string
    {
        $this->hashed_url = hash("md5", $this->id . Carbon::now() . Random::generate());
        $this->save();
        return $this->hashed_url;
    }

    /**
     * Get the content based on 
     */
}
