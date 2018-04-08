<?php

namespace App\Http\Controllers;

/**
 * Class SiteController
 * @package App\Http\Controllers
 */
class SiteController extends Controller
{
    public function index()
    {
//        dd(
//            \Swap::latest('BTC/RUR')->getValue() . '    EUR/USD',
//            \Swap::latest('BTC/USD'),
//            \Swap::latest('USD/BTC')->getValue() . '    USD/EUR',
//            \Swap::latest('USD/BTC')
//        );
        return view('pages.index');
    }
}
