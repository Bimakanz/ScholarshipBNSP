@props([
    'name',
    'id' => null,
    'label' => '',
    'placeholder' => 'Pilih opsi...',
    'subtitle' => '',
    'required' => false,
    'options' => [],
    'value' => null,
    'disabled' => false,
    'columns' => 1,
])

@php
    $elementId = $id ?? $name;
    $currentValue = old($name, $value);
    
    // Cari opsi yang sedang terpilih
    $selectedOption = null;
    foreach ($options as $opt) {
        if ((string)$opt['value'] === (string)$currentValue) {
            $selectedOption = $opt;
            break;
        }
    }

    // Mode kompak: grid multi-kolom (tanpa subtitle & badge di dalam item)
    $isCompact = $columns > 1;
@endphp

<!--
    Component: custom-dropdown
    Deskripsi: Reusable custom dropdown component berstandar Portal Akademik Resmi.
               Mendukung ikon dinamis, badge, layout multi-kolom kompak (grid), keyboard handling,
               serta integrasi native form submission & auto-focus BNSP.
    Author: Sena
    Unit Kompetensi: J.620100.015.01 & J.620100.019.02
-->
<div class="space-y-1.5 custom-dropdown-wrapper" data-dropdown-id="{{ $elementId }}">
    @if($label)
        <label for="trigger-{{ $elementId }}" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
            {{ $label }} @if($required) <span class="text-rose-500">*</span> @endif
        </label>
    @endif

    <!-- Hidden Native Select untuk Memastikan Form Submission & Validasi Laravel 100% Aman -->
    <select name="{{ $name }}" 
            id="{{ $elementId }}" 
            class="sr-only" 
            tabindex="-1"
            aria-hidden="true"
            {{ $required ? 'required' : '' }}>
        <option value="" disabled {{ empty($currentValue) ? 'selected' : '' }}>{{ $placeholder }}</option>
        @foreach($options as $opt)
            <option value="{{ $opt['value'] }}" {{ (string)$currentValue === (string)$opt['value'] ? 'selected' : '' }}>
                {{ $opt['title'] ?? $opt['label'] }}
            </option>
        @endforeach
    </select>

    <!-- Custom Dropdown Container -->
    <div class="relative" id="container-{{ $elementId }}">
        
        <!-- Trigger Button -->
        <button type="button" 
                id="trigger-{{ $elementId }}" 
                aria-haspopup="listbox" 
                aria-expanded="false"
                {{ $disabled ? 'disabled' : '' }}
                class="w-full h-[58px] flex items-center justify-between px-4 rounded-xl border {{ $errors->has($name) ? 'border-rose-400 bg-rose-50/20' : 'border-slate-300 bg-white' }} hover:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-700 disabled:bg-slate-100 disabled:text-slate-400 disabled:cursor-not-allowed disabled:border-slate-200 transition-all text-left shadow-2xs">
            
            <div class="flex items-center gap-3 min-w-0">
                <!-- Dynamic Icon Container -->
                <div id="icon-box-{{ $elementId }}" class="w-8 h-8 rounded-lg {{ $selectedOption ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center shrink-0 font-mono font-bold text-xs transition-colors">
                    @if($selectedOption && isset($selectedOption['icon']) && $selectedOption['icon'] === 'code')
                        <svg class="w-4 h-4 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                        </svg>
                    @elseif($selectedOption && isset($selectedOption['icon']) && $selectedOption['icon'] === 'briefcase')
                        <svg class="w-4 h-4 text-indigo-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    @elseif($selectedOption && is_numeric($selectedOption['value']))
                        <span>{{ $selectedOption['value'] }}</span>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    @endif
                </div>

                <!-- Label & Subtitle -->
                <div class="truncate">
                    <span id="label-title-{{ $elementId }}" class="block font-bold text-slate-900 text-xs sm:text-sm truncate">
                        {{ $selectedOption ? ($selectedOption['title'] ?? $selectedOption['label']) : $placeholder }}
                    </span>
                    <span id="label-subtitle-{{ $elementId }}" class="block text-[11px] text-slate-500 truncate">
                        {{ $selectedOption && isset($selectedOption['subtitle']) ? $selectedOption['subtitle'] : $subtitle }}
                    </span>
                </div>
            </div>

            <!-- Right Chevron & Badge (badge hanya tampil di mode 1 kolom) -->
            <div class="flex items-center gap-2 shrink-0 ml-2">
                @if(!$isCompact)
                    <span id="badge-{{ $elementId }}" class="{{ $selectedOption && !empty($selectedOption['badge']) ? 'inline-block' : 'hidden' }} px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-blue-50 text-blue-800 border border-blue-200">
                        {{ $selectedOption['badge'] ?? '' }}
                    </span>
                @endif
                <div class="w-6 h-6 rounded flex items-center justify-center text-slate-400">
                    <svg id="chevron-{{ $elementId }}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </button>

        <!-- Floating Dropdown Menu Panel -->
        <div id="menu-{{ $elementId }}" 
             role="listbox" 
             class="hidden absolute z-30 mt-2 w-full bg-white rounded-2xl border border-slate-200 shadow-xl p-2.5 ring-1 ring-black/5 max-h-80 overflow-y-auto">
            
            <div class="px-2.5 py-1.5 text-[10px] font-bold font-mono uppercase tracking-wider text-slate-400 border-b border-slate-100 mb-2 flex items-center justify-between">
                <span>PILIHAN TERSEDIA</span>
                <span>Portal Akademik</span>
            </div>

            @if($isCompact)
                {{-- Mode Grid Kompak: ikon angka/lambang besar, teks kecil, tanpa subtitle/badge --}}
                <div class="grid grid-cols-4 gap-1">
                    @foreach($options as $opt)
                        @php $isSelected = (string)$currentValue === (string)$opt['value']; @endphp
                        <div role="option"
                             data-value="{{ $opt['value'] }}"
                             data-title="{{ $opt['title'] ?? $opt['label'] }}"
                             data-subtitle="{{ $opt['subtitle'] ?? '' }}"
                             data-badge=""
                             data-icon="{{ $opt['icon'] ?? '' }}"
                             class="custom-dropdown-option relative group flex flex-col items-center justify-center text-center gap-1 py-2.5 px-1 rounded-xl hover:bg-blue-50 border {{ $isSelected ? 'border-blue-300 bg-blue-50' : 'border-transparent' }} cursor-pointer transition-all">
                            
                            <div class="w-8 h-8 rounded-lg {{ $isSelected ? 'bg-blue-700 text-white' : 'bg-slate-100 text-slate-700' }} group-hover:bg-blue-700 group-hover:text-white font-mono font-bold text-sm flex items-center justify-center shrink-0 transition-colors">
                                @if(is_numeric($opt['value']))
                                    <span>{{ $opt['value'] }}</span>
                                @elseif(isset($opt['icon']) && $opt['icon'] === 'code')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                @elseif(isset($opt['icon']) && $opt['icon'] === 'briefcase')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                @else
                                    <span class="text-xs">{{ $opt['value'] }}</span>
                                @endif
                            </div>
                            <span class="text-[10px] font-bold text-slate-700 group-hover:text-blue-900 leading-none">{{ $opt['title'] ?? $opt['label'] }}</span>

                            {{-- Checkmark pojok kanan atas saat dipilih --}}
                            @if($isSelected)
                                <span class="absolute top-1 right-1 w-3.5 h-3.5 bg-blue-700 rounded-sm flex items-center justify-center">
                                    <svg class="w-2 h-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/></svg>
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Mode List Normal: ikon + teks lengkap + subtitle + badge --}}
                <div class="space-y-1">
                    @foreach($options as $opt)
                        @php $isSelected = (string)$currentValue === (string)$opt['value']; @endphp
                        <div role="option"
                             data-value="{{ $opt['value'] }}"
                             data-title="{{ $opt['title'] ?? $opt['label'] }}"
                             data-subtitle="{{ $opt['subtitle'] ?? '' }}"
                             data-badge="{{ $opt['badge'] ?? '' }}"
                             data-icon="{{ $opt['icon'] ?? '' }}"
                             class="custom-dropdown-option group flex items-center justify-between p-2.5 rounded-xl hover:bg-blue-50/80 border {{ $isSelected ? 'border-blue-200 bg-blue-50/50' : 'border-transparent' }} cursor-pointer transition-all">
                            
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-lg {{ $isSelected ? 'bg-blue-700 text-white' : 'bg-slate-100 text-slate-700' }} group-hover:bg-blue-700 group-hover:text-white font-mono font-bold text-xs flex items-center justify-center shrink-0 transition-colors">
                                    @if(isset($opt['icon']) && $opt['icon'] === 'code')
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                                    @elseif(isset($opt['icon']) && $opt['icon'] === 'briefcase')
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    @elseif(is_numeric($opt['value']))
                                        <span>{{ $opt['value'] }}</span>
                                    @else
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    @endif
                                </div>
                                <div class="truncate">
                                    <span class="block font-bold text-slate-900 text-xs sm:text-sm group-hover:text-blue-900">{{ $opt['title'] ?? $opt['label'] }}</span>
                                    @if(isset($opt['subtitle']))
                                        <span class="block text-[11px] text-slate-500 truncate">{{ $opt['subtitle'] }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-1.5 shrink-0 ml-2">
                                @if(!empty($opt['badge']))
                                    <span class="text-[10px] font-mono font-bold uppercase px-2 py-0.5 rounded bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $opt['badge'] }}
                                    </span>
                                @endif
                                <svg class="option-check-icon w-4 h-4 text-blue-700 {{ $isSelected ? 'opacity-100' : 'opacity-0' }} group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

    @error($name)
        <p class="mt-1.5 text-xs text-rose-600 font-semibold flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $message }}
        </p>
    @enderror
</div>
