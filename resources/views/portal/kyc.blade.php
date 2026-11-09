@extends('layouts.app')

@section('title', 'Your Bank Details — SkillLearner')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'kyc'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'kyc'])

        <!-- Right Content Area -->
        <main class="portal-content-area" style="display: flex; justify-content: center;">
            <div class="portal-box-card" style="width: 100%; max-width: 540px; padding: 2rem 1.8rem; border-radius: 18px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);">
                
                <!-- Card Header (Matches Image 1) -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.8rem; padding-bottom: 0.85rem; border-bottom: 1px solid #f1f5f9;">
                    <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0;">Your Bank Details</h3>
                    <a href="{{ url('/dashboard') }}" style="color: #94a3b8; font-size: 1.35rem; text-decoration: none; line-height: 1; transition: color 0.15s;" onmouseover="this.style.color='#0f172a';" onmouseout="this.style.color='#94a3b8';" title="Close">&times;</a>
                </div>

                @if(session('success'))
                    <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.85rem 1rem; border-radius: 8px; margin-bottom: 1.4rem; font-size: 0.9rem; font-weight: 700;">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Bank Details Form -->
                <form action="{{ route('portal.kyc.update') }}" method="POST">
                    @csrf

                    <!-- Bank Name -->
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Bank Name</label>
                        <input type="text" name="bank_name" class="clean-bank-input" value="{{ old('bank_name', $kyc->bank_name ?? session('user.bank_name', '')) }}" placeholder="Enter Bank Name">
                    </div>

                    <!-- Holder Name -->
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Holder Name</label>
                        <input type="text" name="holder_name" class="clean-bank-input" value="{{ old('holder_name', $kyc->holder_name ?? session('user.holder_name', '')) }}" placeholder="Enter Account Holder Name">
                    </div>

                    <!-- Account Number -->
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">Account Number</label>
                        <input type="text" name="account_number" class="clean-bank-input" value="{{ old('account_number', $kyc->account_number ?? session('user.account_number', '')) }}" placeholder="Enter Account Number">
                    </div>

                    <!-- IFSC Code -->
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">IFSC Code</label>
                        <input type="text" name="ifsc_code" class="clean-bank-input" value="{{ old('ifsc_code', $kyc->ifsc_code ?? session('user.ifsc_code', '')) }}" placeholder="Enter IFSC Code">
                    </div>

                    <!-- UPI Id -->
                    <div style="margin-bottom: 1.8rem;">
                        <label style="display: block; font-size: 0.88rem; font-weight: 600; color: #64748b; margin-bottom: 6px;">UPI Id</label>
                        <input type="text" name="upi_id" class="clean-bank-input" value="{{ old('upi_id', $kyc->upi_id ?? session('user.upi_id', '')) }}" placeholder="Enter UPI ID">
                    </div>

                    <button type="submit" class="btn" style="width: 100%; background: #05B396; color: #ffffff; padding: 0.85rem 1.4rem; border-radius: 14px; font-weight: 700; font-size: 0.95rem; border: none; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.25);" onmouseover="this.style.background='#038a74';" onmouseout="this.style.background='#05B396';">
                        Save Bank Details
                    </button>
                </form>

            </div>
        </main>
    </div>
</div>

<style>
    .clean-bank-input {
        width: 100%;
        background: #eef2f6;
        border: 1.5px solid transparent;
        border-radius: 12px;
        padding: 0.85rem 1.15rem;
        font-size: 0.95rem;
        font-weight: 600;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
        transition: all 0.2s ease;
    }
    .clean-bank-input:focus {
        background: #ffffff;
        border-color: #05B396;
        box-shadow: 0 0 0 3px rgba(5, 179, 150, 0.15);
    }
</style>

@include('portal.styles')
@endsection
