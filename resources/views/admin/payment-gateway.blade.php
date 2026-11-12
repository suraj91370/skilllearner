@extends('layouts.app')

@section('title', 'Cashfree Payment Gateway Settings — SkillLearner Admin')

@section('content')
<div class="student-portal-wrapper">
    <!-- Top Mobile Quick Tab Slider -->
    @include('portal.mobile-nav', ['active' => 'admin-payment-gateway'])

    <!-- Main Portal Grid -->
    <div class="portal-main-grid">
        <!-- Left Sidebar Card -->
        @include('portal.sidebar', ['active' => 'admin-payment-gateway'])

        <!-- Right Content Area -->
        <main class="portal-content-area">
            <!-- Header Banner -->
            <div class="portal-greeting-row" style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h2 class="welcome-heading" style="font-size: 1.6rem; margin-bottom: 0.25rem;">
                        ⚡ Cashfree Payment Gateway Settings
                    </h2>
                    <p style="font-size: 0.9rem; color: #64748b; margin: 0;">
                        Configure API credentials, sandbox/production environments, and copy Webhook endpoints for automated order verification.
                    </p>
                </div>
                <div>
                    <a href="{{ route('admin.orders') }}" style="background: #ffffff; border: 1.5px solid #cbd5e1; color: #334155; padding: 0.6rem 1.1rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                        <span>💳 View All Orders</span>
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #f0fdf4; border-left: 4px solid #05B396; color: #166534; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 0.9rem 1.2rem; border-radius: 8px; margin-bottom: 1.5rem; font-size: 0.92rem; font-weight: 600;">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            <!-- Live Gateway Status Pill -->
            <div style="background: {{ $isConfigured ? '#f0fdf4' : '#fffbeb' }}; border: 1.5px solid {{ $isConfigured ? '#a7f3d0' : '#fde68a' }}; border-radius: 14px; padding: 1.2rem 1.5rem; margin-bottom: 1.8rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 50%; background: {{ $isConfigured ? '#05B396' : '#f59e0b' }}; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">
                        {{ $isConfigured ? '⚡' : '⚠️' }}
                    </div>
                    <div>
                        <div style="font-weight: 800; color: #0f172a; font-size: 1.05rem;">
                            Gateway Status: <span style="color: {{ $isConfigured ? '#059669' : '#b45309' }};">{{ $isConfigured ? 'Active & Configured' : 'Credentials Missing or Incomplete' }}</span>
                        </div>
                        <div style="font-size: 0.85rem; color: #64748b;">
                            Current Environment: <strong>{{ strtoupper($env) }}</strong> ({{ $env === 'sandbox' ? 'Test payments simulated with mock numbers' : 'Live INR transactions with actual bank debit' }})
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 8px;">
                    <button type="button" id="btnTestConn" onclick="runLiveConnectionTest()" style="background: #0f172a; color: #ffffff; border: none; padding: 0.65rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.88rem; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                        <span id="testConnSpinner" style="display: none;">⏳</span>
                        <span>🔄 Test Gateway Connection</span>
                    </button>
                </div>
            </div>

            <div id="testConnResult" style="display: none; margin-bottom: 1.5rem; padding: 1rem 1.2rem; border-radius: 10px; font-size: 0.9rem; font-weight: 600;"></div>

            <!-- Two-Column Layout: Configuration Form + Integration URLs -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem;">
                
                <!-- Left Card: API Credentials Form -->
                <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9;">
                        <span style="font-size: 1.3rem;">🔑</span>
                        <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Cashfree PG Credentials</h3>
                    </div>

                    <form method="POST" action="{{ route('admin.payment-gateway.update') }}">
                        @csrf

                        <!-- Environment Switch -->
                        <div style="margin-bottom: 1.4rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.5rem;">
                                Environment Mode *
                            </label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <label style="display: flex; align-items: center; gap: 10px; border: 2px solid {{ $env === 'sandbox' ? '#05B396' : '#e2e8f0' }}; padding: 0.75rem 1rem; border-radius: 10px; cursor: pointer; background: {{ $env === 'sandbox' ? '#f0fdfa' : '#ffffff' }};">
                                    <input type="radio" name="cashfree_env" value="sandbox" {{ $env === 'sandbox' ? 'checked' : '' }} onchange="this.form.submit()">
                                    <div>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">🧪 Sandbox</div>
                                        <div style="font-size: 0.74rem; color: #64748b;">Testing &amp; QA</div>
                                    </div>
                                </label>
                                <label style="display: flex; align-items: center; gap: 10px; border: 2px solid {{ $env === 'production' ? '#05B396' : '#e2e8f0' }}; padding: 0.75rem 1rem; border-radius: 10px; cursor: pointer; background: {{ $env === 'production' ? '#f0fdfa' : '#ffffff' }};">
                                    <input type="radio" name="cashfree_env" value="production" {{ $env === 'production' ? 'checked' : '' }} onchange="this.form.submit()">
                                    <div>
                                        <div style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">🚀 Production</div>
                                        <div style="font-size: 0.74rem; color: #64748b;">Live Real Payments</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Cashfree App ID -->
                        <div style="margin-bottom: 1.2rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Cashfree App ID (Client ID) *
                            </label>
                            <input type="text" 
                                   name="cashfree_app_id" 
                                   id="inputAppId" 
                                   value="{{ old('cashfree_app_id', $appId) }}" 
                                   placeholder="e.g. TEST1038472910..." 
                                   required 
                                   style="width: 100%; padding: 0.7rem 0.95rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; font-family: monospace; outline: none;">
                            <small style="color: #64748b; font-size: 0.74rem; display: block; margin-top: 3px;">
                                Found in Cashfree Dashboard > Developers > API Keys.
                            </small>
                        </div>

                        <!-- Cashfree Secret Key -->
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-size: 0.82rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem;">
                                Cashfree Secret Key *
                            </label>
                            <div style="position: relative;">
                                <input type="password" 
                                       name="cashfree_secret_key" 
                                       id="inputSecretKey" 
                                       value="{{ old('cashfree_secret_key', $secretKey) }}" 
                                       placeholder="Enter secret key..." 
                                       required 
                                       style="width: 100%; padding: 0.7rem 2.8rem 0.7rem 0.95rem; border: 1.5px solid #cbd5e1; border-radius: 8px; font-size: 0.92rem; font-family: monospace; outline: none;">
                                <button type="button" 
                                        onclick="toggleSecretVisibility()" 
                                        style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: transparent; border: none; font-size: 1.1rem; cursor: pointer; color: #64748b;">
                                    👁️
                                </button>
                            </div>
                            <small style="color: #64748b; font-size: 0.74rem; display: block; margin-top: 3px;">
                                Keep this private. It is encrypted in database &amp; never exposed in client JS.
                            </small>
                        </div>

                        <button type="submit" style="width: 100%; background: #05B396; color: #ffffff; border: none; padding: 0.85rem; border-radius: 10px; font-weight: 800; font-size: 0.95rem; cursor: pointer; box-shadow: 0 4px 14px rgba(5, 179, 150, 0.35);">
                            💾 Save Payment Gateway Credentials
                        </button>
                    </form>
                </div>

                <!-- Right Card: Webhook & Return URLs + Integration Guide -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <!-- Webhook Endpoints Card -->
                    <div style="background: #ffffff; border: 1.5px solid #e2e8f0; border-radius: 16px; padding: 1.6rem; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.2rem; padding-bottom: 0.8rem; border-bottom: 1px solid #f1f5f9;">
                            <span style="font-size: 1.3rem;">🔗</span>
                            <h3 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;">Webhook &amp; Return URLs</h3>
                        </div>

                        <!-- Webhook URL -->
                        <div style="margin-bottom: 1.3rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                                <label style="font-size: 0.82rem; font-weight: 700; color: #334155;">
                                    Webhook Endpoint (Server-to-Server)
                                </label>
                                <span style="font-size: 0.72rem; color: #05B396; font-weight: 700;">POST Method</span>
                            </div>
                            <div style="display: flex; gap: 6px;">
                                <input type="text" id="webhookUrl" readonly value="{{ $webhookUrl }}" style="flex: 1; padding: 0.55rem 0.8rem; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.8rem; font-family: monospace; color: #334155;">
                                <button type="button" onclick="copyToClipboard('webhookUrl')" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 0.55rem 0.85rem; border-radius: 6px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
                                    Copy
                                </button>
                            </div>
                            <small style="color: #64748b; font-size: 0.74rem; margin-top: 3px; display: block;">
                                In Cashfree Dashboard > Webhooks, add this URL to receive real-time <code>ORDER.PAID</code> and <code>ORDER.FAILED</code> events.
                            </small>
                        </div>

                        <!-- Return / Callback URL -->
                        <div style="margin-bottom: 0.8rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.35rem;">
                                <label style="font-size: 0.82rem; font-weight: 700; color: #334155;">
                                    User Return URL (Client Redirect)
                                </label>
                                <span style="font-size: 0.72rem; color: #0284c7; font-weight: 700;">GET Method</span>
                            </div>
                            <div style="display: flex; gap: 6px;">
                                <input type="text" id="returnUrl" readonly value="{{ $returnUrl }}" style="flex: 1; padding: 0.55rem 0.8rem; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.8rem; font-family: monospace; color: #334155;">
                                <button type="button" onclick="copyToClipboard('returnUrl')" style="background: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 0.55rem 0.85rem; border-radius: 6px; font-size: 0.8rem; font-weight: 700; cursor: pointer;">
                                    Copy
                                </button>
                            </div>
                            <small style="color: #64748b; font-size: 0.74rem; margin-top: 3px; display: block;">
                                Automatically passed when initiating checkout sessions on Cashfree.
                            </small>
                        </div>
                    </div>

                    <!-- Setup Guide -->
                    <div style="background: linear-gradient(135deg, #f0fdfa, #ecfdf5); border: 1.5px solid #a7f3d0; border-radius: 16px; padding: 1.4rem;">
                        <h4 style="font-size: 0.95rem; font-weight: 800; color: #065f46; margin-bottom: 0.6rem; display: flex; align-items: center; gap: 6px;">
                            <span>📖 Quick Cashfree Integration Guide</span>
                        </h4>
                        <ol style="margin: 0; padding-left: 1.2rem; font-size: 0.82rem; color: #047857; line-height: 1.6;">
                            <li>Login to <a href="https://merchant.cashfree.com" target="_blank" style="color: #047857; font-weight: 800; text-decoration: underline;">Cashfree Merchant Dashboard</a>.</li>
                            <li>Go to <strong>Payment Gateway > Developers > API Keys</strong>.</li>
                            <li>Switch to <strong>Sandbox</strong> for mock testing or <strong>Production</strong> for live money.</li>
                            <li>Copy your <strong>App ID</strong> and <strong>Secret Key</strong> into the form on the left.</li>
                            <li>Click <strong>Test Gateway Connection</strong> to ensure authorization succeeds.</li>
                        </ol>
                    </div>

                </div>

            </div>

        </main>
    </div>
</div>

@include('portal.styles')

@push('scripts')
<script>
    function toggleSecretVisibility() {
        var input = document.getElementById('inputSecretKey');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function copyToClipboard(elementId) {
        var input = document.getElementById(elementId);
        input.select();
        input.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(input.value).then(function() {
            alert('Copied to clipboard: ' + input.value);
        });
    }

    function runLiveConnectionTest() {
        var appId = document.getElementById('inputAppId').value;
        var secret = document.getElementById('inputSecretKey').value;
        var env = document.querySelector('input[name="cashfree_env"]:checked').value;
        var spinner = document.getElementById('testConnSpinner');
        var resultBox = document.getElementById('testConnResult');

        spinner.style.display = 'inline';
        resultBox.style.display = 'none';

        fetch("{{ route('admin.payment-gateway.test') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                cashfree_app_id: appId,
                cashfree_secret_key: secret,
                cashfree_env: env
            })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            spinner.style.display = 'none';
            resultBox.style.display = 'block';

            if (data.success) {
                resultBox.style.background = '#f0fdf4';
                resultBox.style.border = '1.5px solid #a7f3d0';
                resultBox.style.color = '#166534';
                resultBox.innerHTML = '✅ <strong>Connection Successful!</strong> ' + data.message;
            } else {
                resultBox.style.background = '#fef2f2';
                resultBox.style.border = '1.5px solid #fecaca';
                resultBox.style.color = '#991b1b';
                resultBox.innerHTML = '⚠️ <strong>Connection Failed:</strong> ' + data.message;
            }
        })
        .catch(function(err) {
            spinner.style.display = 'none';
            resultBox.style.display = 'block';
            resultBox.style.background = '#fef2f2';
            resultBox.style.border = '1.5px solid #fecaca';
            resultBox.style.color = '#991b1b';
            resultBox.innerHTML = '⚠️ <strong>Network Error:</strong> Could not reach Cashfree API servers.';
        });
    }
</script>
@endpush
@endsection

