@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-slate-300 focus:border-[#183e2b] focus:ring-[#183e2b]/20 rounded-lg shadow-sm text-sm py-2 px-3']) !!}>

