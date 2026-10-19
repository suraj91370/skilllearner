@extends('layouts.app')

@section('title', 'Packages & Plans — CareerFixx')

@section('content')
<section class="container">
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="text-transform: uppercase; letter-spacing: 2.5px; color: var(--primary); font-size: 0.85rem; font-weight: 800; margin-bottom: 0.5rem;">Affiliate Business Model</div>
        <h2 style="font-size: 2.4rem; font-weight: 800; letter-spacing: -0.5px;">All Course Bundles & Commissions</h2>
        <p style="color: var(--text-body); max-width: 600px; margin: 0 auto;">Choose your starter bundle to access all training videos and unlock referral affiliate rights.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(270px, 1fr)); gap: 2rem;">
        @foreach ($packages as $pkg)
            <div class="glass" style="padding: 2.2rem; border-radius: var(--radius-lg); display: flex; flex-direction: column; position: relative; {{ $pkg['featured'] ? 'border: 2px solid #818cf8; background: linear-gradient(180deg, rgba(99, 102, 241, 0.16) 0%, rgba(15, 23, 42, 0.9) 100%);' : '' }}">
                <div style="position: absolute; top: -13px; right: 25px; background: var(--primary-gradient); color: #fff; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 800; letter-spacing: 0.5px;">
                    {{ $pkg['badge'] }}
                </div>
                <h3 style="font-size: 1.5rem;">{{ $pkg['name'] }}</h3>
                <div style="font-size: 2.5rem; font-weight: 800; margin: 0.8rem 0 1.2rem;">
                    ₹{{ number_format($pkg['price']) }} <s style="font-size: 1.1rem; color: #64748b; margin-left: 8px; font-weight: 600;">₹{{ number_format($pkg['old_price']) }}</s>
                </div>
                <div style="background: rgba(16, 185, 129, 0.08); border: 1px dashed rgba(16, 185, 129, 0.35); padding: 12px; border-radius: 10px; margin-bottom: 1.5rem; font-size: 0.88rem;">
                    <div>Direct Profit per sale: <strong style="color: var(--success);">₹{{ number_format($pkg['direct_comm']) }}</strong></div>
                    <div>Team Passive Profit: <strong style="color: var(--success);">₹{{ number_format($pkg['passive_comm']) }}</strong></div>
                </div>
                <ul style="list-style: none; margin-bottom: 2rem; flex-grow: 1;">
                    @foreach ($pkg['courses_included'] as $c)
                        <li style="padding: 0.45rem 0; color: var(--text-body); font-size: 0.92rem; display: flex; align-items: center; gap: 10px;">
                            <span style="color: var(--success); font-weight: bold;">✓</span> {{ $c }}
                        </li>
                    @endforeach
                </ul>
                <button onclick="openCheckout('{{ $pkg['name'] }}', {{ $pkg['price'] }})" class="btn {{ $pkg['featured'] ? 'btn-primary' : 'btn-secondary' }}">
                    Enroll in {{ $pkg['name'] }}
                </button>
            </div>
        @endforeach
    </div>
</section>
@endsection
