<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CNRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $cn = new CNRequest();
        $nodeResponse = $cn->get('/cluster');
        $tasksResponse = $cn->get('/task');
        $serviceResponse = $cn->get('/service');
        return view('dashboard', compact('nodeResponse', 'tasksResponse', 'serviceResponse'));
    }
}
