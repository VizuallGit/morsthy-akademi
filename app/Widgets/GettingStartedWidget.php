<?php

namespace App\Widgets;

use Statamic\Widgets\Widget;

class GettingStartedWidget extends Widget
{
    public static $handle = 'getting_started_vizuall';

    public function html(): string
    {
        $items = [
            [
                'title'       => 'Indstillinger',
                'description' => 'Sæt klubbens grundlæggende oplysninger op – navn, adresse, kontaktmail, telefon, logo og links til sociale medier.',
                'url'         => cp_route('globals.variables.edit', ['global_set' => 'site_settings']),
                'icon'        => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            ],
            [
                'title'       => 'Spillere',
                'description' => 'Opret og opdatér spillerprofiler med foto, trøjenummer, position og øvrige detaljer.',
                'url'         => cp_route('collections.show', ['collection' => 'players']),
                'icon'        => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
            ],
            [
                'title'       => 'Nyheder',
                'description' => 'Skriv artikler og nyheder om klubben – kampresultater, begivenheder eller andre opdateringer.',
                'url'         => cp_route('collections.show', ['collection' => 'news']),
                'icon'        => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>',
            ],
            [
                'title'       => 'Sponsorer',
                'description' => 'Tilføj klubbens sponsorer med logo, navn og link til deres hjemmeside.',
                'url'         => cp_route('collections.show', ['collection' => 'sponsor']),
                'icon'        => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
            ],
            [
                'title'       => 'Medarbejdere',
                'description' => 'Præsentér klubbens trænere, ledere og øvrige medarbejdere med foto, titel og kontaktoplysninger.',
                'url'         => cp_route('collections.show', ['collection' => 'employees']),
                'icon'        => '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            ],
        ];

        $videos = [
            [
                'title'       => 'Dashboard',
                'description' => 'Intro til dit dashboard',
                'url'         => 'https://www.loom.com/share/651f5f78ca4d46319364e3ebc461e51f'
            ],
            [
                'title'       => 'Billede arkiv',
                'description' => 'Opret billede og sorter dem',
                'url'         => cp_route('collections.show', ['collection' => 'players'])
            ],
            [
                'title'       => 'Samlinger',
                'description' => 'Guide til collectioner og sider',
                'url'         => cp_route('collections.show', ['collection' => 'players'])
            ],
        ];

        return view('widgets.getting_started', ['items' => $items, 'videos' => $videos])->render();
    }
}
