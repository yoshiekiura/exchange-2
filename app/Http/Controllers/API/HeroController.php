<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\HeroResource;
use App\Models\Hero;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HeroController extends Controller
{
    public function getHero()
    {
        $hero = Hero::firstOrCreate([]);
        return new HeroResource($hero);
    }
}
