# SkillLearner Platform: Roles, Permissions & Capabilities Specification

> **Official System Documentation**  
> *Target Audience:* Founders, Super Admins, Operations, Developers & Affiliate Partners  
> *Application:* SkillLearner (Laravel 11 / PHP 8.3 / MySQL / Cashfree Payment Gateway)

---

## 1. Role Hierarchy & Overview

SkillLearner operates with a 3-tier role architecture designed for high-scale affiliate marketing, e-learning, and administrative delegation:

```
                      ┌─────────────────────────┐
                      │       SUPER ADMIN       │  (Full System Ownership & Config)
                      └────────────┬────────────┘
                                   │
                      ┌────────────┴────────────┐
                      │          ADMIN          │  (Operations, Approvals & Content)
                      └────────────┬────────────┘
                                   │
                      ┌────────────┴────────────┐
                      │    STUDENT / AFFILIATE  │  (Learning, Promotion & Earnings)
                      └─────────────────────────┘
```

| Role | Role Identifier (`users.role`) | Primary Focus |
| :--- | :--- | :--- |
| **Student / Affiliate (User)** | `user` / `student` / `affiliate` | Purchases packages, watches courses, generates referral links, promotes marketing materials, joins webinars, earns commissions, and requests payouts. |
| **Admin** | `admin` | Manages operational day-to-day tasks: payout approval/rejection, mentor profiles, training lessons, marketing tools, live offers, webinars, and social links. |
| **Super Admin** | `super_admin` | Absolute system control: package pricing, commission matrices, payment gateways (Cashfree), manual free ID activations with invoices, coupons, staff RBAC, and audit logs. |

---

## 2. Master Capabilities Comparison Matrix

| Feature / Action | Student / User | Admin | Super Admin |
| :--- | :---: | :---: | :---: |
| **Browse Public Website & Course Catalogs** | ✅ | ✅ | ✅ |
| **Register Account (Direct or with Referral ID)** | ✅ | ✅ | ✅ |
| **Login Access** | *(Only if Paid or Activated)* | ✅ | ✅ |
| **Access Purchased Video Courses & Lessons** | ✅ | ✅ | ✅ |
| **Earn Course Completion Certificates** | ✅ | ❌ | ❌ |
| **Generate Personal Referral Link & QR Code** | ✅ | ❌ | ❌ |
| **Download Marketing Tools (Shorts / Reels / Posters)** | ✅ | ✅ | ✅ |
| **Watch Affiliate Training Masterclasses** | ✅ | ✅ | ✅ |
| **Join Live Community Channels (WhatsApp, IG, etc.)** | ✅ | ✅ | ✅ |
| **View Live Contests & Download Offer Posters** | ✅ | ✅ | ✅ |
| **Join Live Webinars (Zoom / Meet) & Download Posters**| ✅ | ✅ | ✅ |
| **View Earning Analytics (Today, 7D, 30D, All-Time)** | ✅ *(Own)* | ✅ *(Platform)* | ✅ *(Platform)* |
| **View Direct & Passive Referral Team Tree** | ✅ *(Own)* | ✅ *(All)* | ✅ *(All)* |
| **Submit KYC Documents & Bank Account / UPI** | ✅ | ❌ | ❌ |
| **Download Official Purchase Tax Invoice** | ✅ *(Own)* | ✅ *(All)* | ✅ *(All)* |
| **Review & Approve/Reject Affiliate Payouts** | ❌ | ✅ | ✅ |
| **Upload & Manage Mentors (Photo Upload)** | ❌ | ✅ | ✅ |
| **Upload & Manage Marketing Tools (Reels & Photos)** | ❌ | ✅ | ✅ |
| **Upload & Manage Affiliate Training (YouTube links)** | ❌ | ✅ | ✅ |
| **Manage Social Community Channels (Add/Edit Links)** | ❌ | ✅ | ✅ |
| **Manage Live Offers (Posters, Targets, Deadlines)** | ❌ | ✅ | ✅ |
| **Manage Webinars (Posters, Meeting Links, Schedules)**| ❌ | ✅ | ✅ |
| **Publish Blogs & Announcements CMS** | ❌ | ✅ | ✅ |
| **Manual User ID Activation Without Payment** | ❌ | ❌ | ✅ *(Free with Invoice & Email)* |
| **1-Click User Impersonation ("Login as User")** | ❌ | ❌ | ✅ |
| **Set Prices & Active/Passive Commissions for 5 Packages**| ❌ | ❌ | ✅ |
| **Course Show/Hide Control (Toggle Visibility)** | ❌ | ❌ | ✅ |
| **Create & Manage Discount Coupons & Flash Sales** | ❌ | ❌ | ✅ |
| **Configure Cashfree API Keys & Live/Sandbox Mode** | ❌ | ❌ | ✅ |
| **Manage Staff Roles & RBAC Granular Permissions** | ❌ | ❌ | ✅ |
| **Inspect System Audit Trail & Activity Logs** | ❌ | ❌ | ✅ |
| **Run Web Migrations & Clear System Cache** | ❌ | ❌ | ✅ |

---

## 3. What a Student / Affiliate (User) Can Do

### 3.1 Account Registration & Gated Login Security
- **Sponsor Validation:** Can register using an affiliate's referral link or sponsor ID. The system automatically attributes the registration to the referring user.
- **Strict Payment Wall:** Once registered, users **cannot log in** until they successfully complete the package payment via Cashfree OR receive a manual activation from Super Admin.
- **Account Recovery:** Self-service password reset using email verification.

### 3.2 Student Learning & Course Experience
- **Package Access:** Lifetime access to courses bundled under their purchased tier (e.g., Basic, Growth, Advance, Premium, or Infinity).
- **Curriculum Player:** Watch high-definition video modules, step-by-step masterclasses, and track completed lessons.
- **Certificates:** Earn automated completion certificates for finished course tracks.

### 3.3 Affiliate Promotion & Marketing Hub
- **Dynamic Referral Links:**
  - Standard personalized registration link.
  - Package-specific direct checkout links.
  - Custom QR code generator to download and print or share on social media.
- **Marketing Tools:**
  - High-converting 9:16 Short Videos / Reels ready to download and upload to Instagram Reels, YouTube Shorts, and WhatsApp Status.
  - Promotional graphic posters with direct download options.
- **Affiliate Training:**
  - Embedded video theater containing step-by-step masterclasses (mindset, organic lead generation, WhatsApp closing, script teleprompters).
- **Social Communities:**
  - Direct 1-click access to official company broadcast channels (WhatsApp, Instagram, YouTube, Facebook, Telegram, Discord).
- **Live Offers & Contests:**
  - View ongoing national contests (e.g., Goa Tour Contest, Cash Bonus Bonanza, Laptop Challenge).
  - Inspect contest targets (e.g., 50 package sales in November), rewards, and remaining days.
  - **Download Offer Posters** to post on WhatsApp status or share with leads.
- **Live Webinars & Workshops:**
  - View upcoming live workshops with speaker details, dates, and times.
  - **Join Meeting Button** — 1-click launch for Zoom, Google Meet, or YouTube Live.
  - **Download Webinar Posters** to invite prospective students.

### 3.4 Earnings, Referrals & Payouts
- **Financial Analytics Dashboard:**
  - Real-time display of Today's Earnings, Last 7 Days, Last 30 Days, and All-Time Earnings.
  - Split view between **Active Direct Income** and **Passive Tier-2 Income**.
- **Team Management:**
  - **Active Referrals:** List of all directly sponsored students, purchased package, and commission credited.
  - **Passive Referrals:** Second-level team overview.
- **Payout Tracking:**
  - History of bank payout transfers, status (Pending, Approved, Paid), transaction reference IDs, and dates.
- **Team Leaderboard:**
  - Public rankings showing Top Earners (Today, Weekly, Monthly, and All-Time).

### 3.5 Profile, KYC & Security
- **Profile Customizer:** Update display name, profile avatar photo, phone number, bio, and social handles.
- **KYC Verification:**
  - Enter Bank Account details (Account Number, Bank Name, IFSC Code).
  - Enter UPI ID for instant transfers.
  - Upload PAN / Aadhaar documents for tax compliance.
- **Tax Invoices:** Download generated GST/tax invoices (`INV-SKL-YYYY-XXXXX`) for every purchase.

---

## 4. What an Admin Can Do

Admins handle day-to-day business operations and content curation without having access to core financial configurations or system keys.

### 4.1 Executive Dashboard
- View total platform gross turnover, total active commissions paid, total passive commissions paid, and net platform profit.
- Quick summary of pending payout requests and unverified KYC submissions.

### 4.2 Commission & Payout Management
- **Payout Approval Queue:** Inspect requested withdrawals, cross-check verified bank details, and mark payouts as **Approved** or **Rejected** with reason notes.
- Export payout batches to CSV/Excel for banking software.

### 4.3 Content & Training Management
- **Mentor Directory:** Add, edit, and organize mentor profiles with photo file upload, designations, and expertise tags.
- **Marketing Tools Library:**
  - Upload short video reels (`.mp4`, `.mov`) and graphic posters (`.png`, `.jpg`, `.webp`).
  - Categorize assets, set display sort order, and monitor download counts.
- **Affiliate Training Masterclasses:**
  - Create and edit curriculum lessons.
  - Provide YouTube video URLs (auto-embeds into the portal theater player).
  - Upload custom thumbnails or link external images.
  - Set lesson duration, step badges, and descriptions.
- **Social Community Links:**
  - Add and update community channels (WhatsApp, Telegram, Instagram, YouTube, etc.).
  - Customize button labels, theme colors, and sort orders.
  - 1-click toggle to show or hide channels.
- **Live Offers & Promotional Contests:**
  - Create promotional contests with uploaded posters.
  - Configure reward criteria, target milestones, and validity dates.
  - 1-click toggle to activate or hide offers from students.
- **Live Webinars:**
  - Schedule upcoming masterclasses.
  - Upload promotional poster creatives.
  - Configure live meeting URLs (Zoom, Google Meet, YouTube Live).
  - Set speaker information and schedules.
- **Blog & News CMS:** Author, edit, and publish announcement articles and blog posts.

### 4.4 Student Directory & Support
- Search students by name, email, phone number, or sponsor ID.
- Inspect student package status, KYC verification status, and commission earnings.

---

## 5. What a Super Admin Can Do (Master Ownership)

Super Admins hold supreme platform authority, governing system settings, financial rules, payment gateways, and staff delegation.

### 5.1 Manual User ID Activation (Without Payment)
- **Manual Free Activation:**
  - Activate any registered user ID directly from the admin panel without payment gateway processing.
  - Generates an auto-incremented, clash-free official invoice (`INV-SKL-YYYY-XXXXX`).
  - Sets order status as `paid` and activation method as `manual_admin`.
  - Automatically sends the official **Welcome / Account Activation Email** with login credentials.
- **User Moderation:** Block, suspend, or reactivate any student or affiliate.
- **1-Click User Impersonation:**
  - Super Admin can click "Login as User" on any account to immediately view the portal exactly as that student sees it, enabling instant troubleshooting.
  - An exit banner allows seamless return back to the Super Admin panel.

### 5.2 5 Packages Pricing & Commission Engine
- Manage the 5 core platform packages:
  1. **Basic Package**
  2. **Growth Package**
  3. **Advance Package**
  4. **Premium Package**
  5. **Infinity Package**
- **Dynamic Pricing:** Change package purchase price in real-time without editing database scripts.
- **Commission Rates:** Set exact **Direct Active Commission** and **Tier-2 Passive Commission** for each package.

### 5.3 Course Option & Visibility Control (Show / Hide)
- **Course Toggle:** Hide or unhide individual packages and courses from both the public homepage and student portal.
- Useful for scheduled launches, private cohort enrollment, or retired packages.

### 5.4 Offers, Coupons & Flash Sale Engine
- **Flash Sales & Timed Offers:**
  - Launch site-wide promotional banners with live countdown timers.
  - Apply instant percentage or flat discounts on package checkouts.
- **Coupon Code Management:**
  - Create custom coupon codes (e.g., `DIWALI20`, `SKILL10`).
  - Configure discount type (% or flat ₹), minimum order threshold, and maximum discount cap.
  - Set total usage limits, per-user limits, and expiry dates.

### 5.5 Cashfree Payment Gateway & API Integration
- Toggle between **Cashfree Sandbox (Test Mode)** and **Live Production Mode**.
- Enter and update `CASHFREE_APP_ID`, `CASHFREE_SECRET_KEY`, and `CASHFREE_WEBHOOK_SECRET` directly from the admin interface.
- Inspect real-time webhook logs and payment transaction traces.

### 5.6 Staff Management & Role-Based Access Control (RBAC)
- Create and manage administrative staff members (e.g., Support, Finance, Content Managers).
- Create custom roles and assign granular module permissions (View, Create, Edit, Delete).
- **System Audit Trail & Activity Logs:**
  - Comprehensive logging of every administrative action (e.g., who approved a payout, who changed package prices, who activated a user ID).
  - Logs capture user ID, role, action, target entity, IP address, and timestamp.

### 5.7 Website Customizer & Homepage CMS
- Edit hero headlines, subheadings, and video pitch presentations.
- Update social proof stats (active students, platform turnover, mentor counts).
- Manage student reviews, testimonials, and FAQ items.
- Control global top notification marquees.

### 5.8 Database & System Utilities
- Trigger web-based database migrations (`/admin/run-migrations`).
- Clear application, route, view, and config caches with one click.

---

## 6. Critical Business Rules & Workflows

### 6.1 Payment Gate Rule
```
[User Registers] ──> [Pending Payment State] ──> [Attempt to Log In]
                                                          │
                   ┌──────────────────────────────────────┴──────────────────────────────────────┐
                   ▼                                                                             ▼
           [Payment Not Done]                                                         [Payment Done OR]
                   │                                                             [Super Admin Manual Activation]
                   ▼                                                                             │
    [Access DENIED - Redirected to]                                                              ▼
    [Checkout / Payment Screen]                                                   [Access GRANTED - Dashboard]
```
- A user who abandons the payment screen **cannot bypass security** by directly hitting `/login`.
- Login requires `payment_status = 'paid'` OR explicit verification by Super Admin.

### 6.2 Invoice Generation Protocol
- Every successful order (Cashfree or Super Admin free override) automatically receives a strictly sequential, collision-free invoice number: `INV-SKL-{YEAR}-{SEQUENCE_ID}` (e.g., `INV-SKL-2026-00015`).
- Guaranteed uniqueness via database atomic locking and duplicate-entry retry handling.

### 6.3 Two-Tier Commission Logic
- **Direct Sponsor (Level 1):** Receives the configured **Active Commission** upon successful package purchase.
- **Sponsor's Sponsor (Level 2):** Receives the configured **Passive Commission**.
- System automatically detects self-referral attempts and disables unauthorized loops.

---

## 7. Quick Navigation Map

| Section | Student URL | Admin / Super Admin URL |
| :--- | :--- | :--- |
| **Dashboard** | `/dashboard` | `/admin/dashboard` |
| **Courses & Learning** | `/courses` | `/admin/courses` *(Super Admin)* |
| **Marketing Tools** | `/marketing-tool` | `/admin/marketing-tools` |
| **Affiliate Training** | `/affiliate-training` | `/admin/affiliate-training` |
| **Social Community** | `/social-community` | `/admin/social-communities` |
| **Live Offers** | `/live-offers` | `/admin/live-offers` |
| **Webinars** | `/webinars` | `/admin/webinars` |
| **Mentors** | *(Public Home)* | `/admin/mentors` |
| **Offers & Coupons** | *(Public Checkout)* | `/admin/offers` *(Super Admin)* |
| **Cashfree Settings** | *(Checkout)* | `/admin/payment-gateway` *(Super Admin)* |
| **Staff & RBAC** | ❌ | `/admin/roles` & `/admin/activity-logs` *(Super Admin)* |
| **Website CMS** | `/` | `/admin/content/homepage` *(Super Admin)* |
| **User Directory** | ❌ | `/admin/users` |
