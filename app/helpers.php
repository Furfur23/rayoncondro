<?php

if (!function_exists('dashboard_route')) {
    function dashboard_route(): string
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        } elseif ($user->hasRole('warga')) {
            return route('warga.dashboard');
        }

        return route('siswa.dashboard');
    }
}