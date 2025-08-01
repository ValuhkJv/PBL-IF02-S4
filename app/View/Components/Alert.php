<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    /**
     * Tipe notifikasi: success, warning, error, atau info.
     *
     * @var string
     */
    public string $type;

    /**
     * Buat instance komponen baru.
     *
     * @param  string  $type
     * @return void
     */
    public function __construct(string $type = 'info')
    {
        $this->type = $type;
    }

    /**
     * Menentukan kelas CSS berdasarkan tipe.
     *
     * @return string
     */
    public function alertClasses(): string
    {
        return [
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'error'   => 'alert-error',
            'info'    => 'alert-info',
        ][$this->type] ?? 'alert-info';
    }

    /**
     * Menentukan path data untuk ikon SVG berdasarkan tipe.
     *
     * @return string
     */
    public function iconPath(): string
    {
        return match ($this->type) {
            'success' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            'warning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
            'error'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
            default   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
        };
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.alert');
    }
}