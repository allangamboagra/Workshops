<?php

class DashboardController extends Controller
{
    public function __construct()
    {
        Auth::requireLogin();
    }

    // GET dashboard
    public function index(): void
    {
        $this->render('dashboard/index', [
            'title' => 'Dashboard',
            'user' => Auth::user(),
        ]);
    }
}
