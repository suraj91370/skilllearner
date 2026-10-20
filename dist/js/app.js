// CareerFixx Clone Core Interactive Logic
document.addEventListener('DOMContentLoaded', () => {
  initReferralCode();
  initWatermark();
});

// 1. Auto-fill Sponsor / Referral Code from URL
function initReferralCode() {
  const urlParams = new URLSearchParams(window.location.search);
  const refCode = urlParams.get('ref') || 'CFX-ADMIN';
  
  const sponsorInput = document.getElementById('sponsor_id');
  if (sponsorInput) {
    sponsorInput.value = refCode;
  }
}

// 2. Anti-Piracy Dynamic Watermark (Moves randomly across screen like Gumlet)
function initWatermark() {
  const watermark = document.getElementById('drm-watermark');
  const container = document.querySelector('.video-wrapper');
  
  if (watermark && container) {
    setInterval(() => {
      const maxX = container.clientWidth - watermark.clientWidth - 40;
      const maxY = container.clientHeight - watermark.clientHeight - 40;
      
      const randomX = Math.max(10, Math.floor(Math.random() * maxX));
      const randomY = Math.max(10, Math.floor(Math.random() * maxY));
      
      watermark.style.left = `${randomX}px`;
      watermark.style.top = `${randomY}px`;
    }, 4000);
  }
}

// 3. Copy Referral Link
function copyAffiliateLink() {
  const input = document.getElementById('affiliateLinkInput');
  if (!input) return;
  
  input.select();
  input.setSelectionRange(0, 99999);
  navigator.clipboard.writeText(input.value).then(() => {
    alert("✅ Affiliate Link Copied to Clipboard!\nShare it to earn direct commissions!");
  });
}

// 4. Modal Handlers
function openModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.classList.add('active');
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.classList.remove('active');
}

// 5. Open Checkout Modal with selected Package
function selectPackage(packageName, price, directCommission) {
  const pkgNameEl = document.getElementById('modal-package-name');
  const pkgPriceEl = document.getElementById('modal-package-price');
  const hiddenPkg = document.getElementById('checkout-package-input');
  
  if (pkgNameEl) pkgNameEl.innerText = packageName;
  if (pkgPriceEl) pkgPriceEl.innerText = '₹' + price;
  if (hiddenPkg) hiddenPkg.value = packageName;
  
  openModal('checkoutModal');
}

// 6. Simulate Razorpay Checkout Execution
function processMockPayment(e) {
  e.preventDefault();
  
  const btn = document.getElementById('pay-btn');
  btn.innerText = 'Processing via Razorpay...';
  btn.disabled = true;
  
  setTimeout(() => {
    alert("🎉 Payment Successful!\nYour package has been activated and your sponsor commission has been credited.");
    closeModal('checkoutModal');
    btn.innerText = 'Pay & Activate Course';
    btn.disabled = false;
    window.location.href = '?page=dashboard&activated=true';
  }, 1600);
}

// 7. Course Lesson Switcher
function playLesson(title, videoUrl) {
  const titleEl = document.getElementById('active-lesson-title');
  const videoEl = document.getElementById('main-video-player');
  
  if (titleEl) titleEl.innerText = title;
  if (videoEl) {
    videoEl.src = videoUrl;
    videoEl.play();
  }
}
