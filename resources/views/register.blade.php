@extends('layouts.app')

@section('title', 'Enroll in CareerFixx')

@section('content')
<section class="container" style="max-width: 540px;">
    <div class="glass" style="padding: 2.5rem; border-radius: var(--radius-lg); text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; margin-bottom: 0.4rem;">Enroll in CareerFixx</h2>
        <p style="color: var(--text-body); font-size: 0.9rem; margin-bottom: 2rem;">Activate lifetime access to video courses, community calls, and direct commission earning rights.</p>

        <form method="POST" action="{{ url('/register-user') }}">
            @csrf
            <div class="form-group" style="text-align: left;">
                <label>Sponsor / Referral ID (Auto-Locked)</label>
                <input type="text" name="sponsor_id" class="form-control" value="{{ request('ref', session('user.affiliate_id', 'CFX-ADMIN')) }}" readonly style="background: rgba(99, 102, 241, 0.12); color: #818cf8; font-weight: 700;">
            </div>
            <div class="form-group" style="text-align: left;">
                <label>Select Your Learning Package</label>
                <select name="package" class="form-control">
                    <option value="Prime Package" selected>Prime Package (₹3,499) — Most Popular</option>
                    <option value="Standard Package">Standard Package (₹1,999)</option>
                    <option value="Legacy Package">Legacy Package (₹6,999)</option>
                    <option value="Mini Package">Mini Package (₹999)</option>
                </select>
            </div>
            <div class="form-group" style="text-align: left;">
                <label>Your Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="Suraj Kumar" required>
            </div>
            <div class="form-group" style="text-align: left;">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="suraj@example.com" required>
            </div>
            <div class="form-group" style="text-align: left;">
                <label>WhatsApp Number</label>
                <input type="tel" name="phone" class="form-control" placeholder="9876543210" required>
            </div>
            <div class="form-group" style="text-align: left;">
                <label>Create Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.9rem; margin-top: 1rem;">
                Pay via Razorpay & Activate Account
            </button>
        </form>
    </div>
</section>
@endsection
