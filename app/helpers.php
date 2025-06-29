<?php

if (!function_exists('getNavigationLinks')) {
    function getNavigationLinks($user) {
        if (!$user) {
            return [
                ['label' => 'Layanan', 'children' => [
                    ['label' => 'Live Tracking', 'url' => route('login')],
                    ['label' => 'Pengiriman', 'url' => route('login')],
                ]],
            ];
        }
        if ($user->isKurir()) {
            return [
                ['label' => 'Dashboard', 'url' => route('kurir.dashboard')],
                ['label' => 'Live Tracking', 'url' => route('kurir.dashboard')],
            ];
        }
        // Default: customer
        return [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Layanan', 'children' => [
                ['label' => 'Live Tracking', 'url' => route('login')],
                ['label' => 'Permintaan Pengiriman', 'url' => route('shipments.create.step1')],
                ['label' => 'Daftar Pengiriman', 'url' => route('active')],
                ['label' => 'History Pengiriman', 'url' => route('history')],
            ]],
        ];
    }
}