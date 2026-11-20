import os
import sys
sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from docx import Document
from docx.shared import Inches, Pt, RGBColor
from build_all_docx import (
    add_header_banner, add_h1, add_h2, add_h3, add_p, add_bullet, 
    add_callout, add_table_data
)

def build_master_doc(output_path):
    doc = Document()
    for s in doc.sections:
        s.top_margin = Inches(0.8)
        s.bottom_margin = Inches(0.8)
        s.left_margin = Inches(0.8)
        s.right_margin = Inches(0.8)

    add_header_banner(
        doc,
        title="SkillLearner: Complete Platform Documentation",
        subtitle="Comprehensive Master Manual covering Frontend User Journeys, Affiliate Workflows, and System Roles & Permissions.",
        badge_text="OFFICIAL MASTER DOCUMENTATION (DOCX)"
    )

    # PART 1: FRONTEND USER GUIDE
    add_h1(doc, "PART I: FRONTEND USER JOURNEY & HOW IT WORKS")
    add_p(doc, "This section explains how the entire platform operates from the user's perspective, without technical or backend code.")

    add_h2(doc, "1. What is SkillLearner?")
    add_p(doc, "SkillLearner combines High-Income Digital Skill Education with a structured Two-Tier Affiliate Earning Opportunity:")
    add_bullet(doc, "Learn career-ready digital skills (Video Editing, Social Media Growth, AI Tools, Sales Funnels) structured across 5 package tiers.", bold_prefix="For Students: ")
    add_bullet(doc, "Earn direct (Active) and team (Passive) income by sharing skill packages with others using ready-made marketing tools, live webinars, and training masterclasses.", bold_prefix="For Affiliates: ")

    add_callout(
        doc,
        title="Complete 6-Step Journey",
        text="1. Browse Courses -> 2. Register with Sponsor ID -> 3. Pay via Cashfree Gateway -> 4. Watch HD Courses & Earn Certificates -> 5. Download Ready-Made Reels & Posters to Promote -> 6. Submit KYC & Receive Weekly Direct Bank Payouts.",
        icon="🚀",
        color="05B396",
        bg_hex="F0FDF4"
    )

    add_h2(doc, "2. Public Website & Package Tiers")
    add_p(doc, "When visitors open the website, they explore:")
    add_bullet(doc, "Hero video pitch introducing the platform, student results, and available skills.", bold_prefix="Introductory Pitch: ")
    add_bullet(doc, "Active announcements, countdown flash sales, and discount coupons.", bold_prefix="Notification Marquee: ")
    add_bullet(doc, "Clear breakdown of the 5 educational tiers:", bold_prefix="5 Package Tiers: ")

    pkg_headers = ["Package Name", "Target Audience", "Key Skills Taught", "Affiliate Benefit"]
    pkg_rows = [
        ["Basic (e-Lite)", "Beginners", "Social media basics, digital starter pack", "Entry-level commissions"],
        ["Growth Package", "Active Creators", "Instagram reels mastery, organic lead generation", "Higher active commission"],
        ["Advance Package", "Video Creators", "Presentation skills, video sales letters, funnels", "Strong passive leverage"],
        ["Premium Package", "Entrepreneurs", "Automation funnels, ads, high-ticket closing", "High-tier commissions"],
        ["Infinity Package", "Elite Earners", "Full master bundle + personal branding secrets", "Maximum active & passive rates"],
    ]
    add_table_data(doc, pkg_headers, pkg_rows, [1.3, 1.4, 2.3, 1.5])

    add_h2(doc, "3. Registration, Payment & Security Gate")
    add_bullet(doc, "User registers with a sponsor referral link. Sponsor ID is locked in automatically.", bold_prefix="1. Sign Up: ")
    add_bullet(doc, "Redirected to Cashfree payment screen to pay via UPI, Cards, or NetBanking.", bold_prefix="2. Checkout: ")
    add_bullet(doc, "Instant account activation, invoice generation, and welcome email delivery.", bold_prefix="3. Activation: ")

    add_callout(
        doc,
        title="The Strict Security Gate Rule",
        text="If someone registers, enters the payment screen, and then presses 'Back' or closes the browser without paying, they CANNOT log into the website. The system blocks login access until either: (1) they complete the payment, or (2) a Super Admin manually activates their ID for free.",
        icon="🔒",
        color="DC2626",
        bg_hex="FEF2F2"
    )

    add_h2(doc, "4. Student Learning & Certification")
    add_bullet(doc, "All video courses included in their package appear as interactive cards.", bold_prefix="My Courses: ")
    add_bullet(doc, "HD video player with sequential modules, lessons, and progress tracking.", bold_prefix="Video Player: ")
    add_bullet(doc, "Automated completion certificate generated once all lessons in a course are completed.", bold_prefix="Certificates: ")

    add_h2(doc, "5. The Affiliate Earning Hub")
    add_bullet(doc, "Master referral link, package-specific direct checkout links, and QR Code.", bold_prefix="1. Referral Links & QR: ")
    add_bullet(doc, "Ready-made 9:16 vertical Short Videos/Reels and high-res promotional posters to post on WhatsApp and Instagram.", bold_prefix="2. Marketing Tools: ")
    add_bullet(doc, "Masterclass training videos on attracting leads, WhatsApp closing scripts, and handling objections.", bold_prefix="3. Affiliate Training: ")
    add_bullet(doc, "Company reward challenges (Goa Trip, ₹25,000 Cash, Laptop). View targets and download official offer posters.", bold_prefix="4. Live Contests: ")
    add_bullet(doc, "Weekly live workshops with mentors. 1-click 'Join Live Meeting' (Zoom/Meet) and download invitation posters.", bold_prefix="5. Live Webinars: ")
    add_bullet(doc, "Direct 1-click links to join WhatsApp, Telegram, Instagram, and YouTube groups.", bold_prefix="6. Social Communities: ")

    add_h2(doc, "6. Financials, KYC & Weekly Bank Payouts")
    add_bullet(doc, "Earned immediately on direct sales from your referral link.", bold_prefix="Active Direct Commission: ")
    add_bullet(doc, "Earned when a student referred by you makes a sale. Passive team leverage.", bold_prefix="Passive Tier-2 Commission: ")
    add_bullet(doc, "Submit Bank Account Number, IFSC Code, and UPI ID for weekly bank transfers.", bold_prefix="KYC Submission: ")
    add_bullet(doc, "Live rankings of top earners (Daily, Weekly, Monthly, and All-Time).", bold_prefix="Leaderboard: ")

    # PAGE BREAK FOR PART 2
    doc.add_page_break()

    # PART 2: ROLES & PERMISSIONS SPECIFICATION
    add_h1(doc, "PART II: ROLES, PERMISSIONS & ADMINISTRATIVE SPECIFICATION")
    add_p(doc, "This section defines the operational matrix and exact capabilities of Student Users, Operations Admins, and Super Admins.")

    matrix_headers = ["Platform Feature / Action", "Student", "Admin", "Super Admin"]
    matrix_rows = [
        ["Browse Public Website & Courses", "Full Access", "Full Access", "Full Access"],
        ["Register Account (Referral/Direct)", "Allowed", "N/A", "N/A"],
        ["Portal Login Access", "Paid Only", "Direct Login", "Direct Login"],
        ["Watch Enrolled Video Lessons", "Enrolled", "Preview", "Full Access"],
        ["Earn Completion Certificates", "Automated", "N/A", "N/A"],
        ["Referral Links & QR Code Generator", "Own Unique", "N/A", "N/A"],
        ["Download Marketing Tools (Reels/Posters)", "Free Download", "Upload & Track", "Full Control"],
        ["Watch Affiliate Training Masterclasses", "Theater View", "Manage Lessons", "Full Control"],
        ["Join Official Social Communities", "Direct Links", "Manage Channels", "Full Control"],
        ["View Live Contests & Download Posters", "Download", "Create/Upload", "Full Control"],
        ["Join Webinars & Download Posters", "Join & Save", "Schedule & Link", "Full Control"],
        ["Earning Analytics (Today/7D/30D/Total)", "Own Stats", "Platform Total", "Platform Total"],
        ["Referral Team Tree (Active/Passive)", "Own Team", "All Users", "All Users"],
        ["Submit KYC Documents & Bank/UPI", "Allowed", "N/A", "N/A"],
        ["Download Purchase Tax Invoices", "Own Invoices", "All Orders", "All Orders"],
        ["Review & Approve/Reject Payouts", "Blocked", "Actionable", "Actionable"],
        ["Manage Mentors (Photo Upload)", "Blocked", "Actionable", "Actionable"],
        ["Upload Marketing Reels & Posters", "Blocked", "Actionable", "Actionable"],
        ["Upload Training YouTube Masterclasses", "Blocked", "Actionable", "Actionable"],
        ["Manage Social Community Links", "Blocked", "Actionable", "Actionable"],
        ["Manage Live Offers & Contest Posters", "Blocked", "Actionable", "Actionable"],
        ["Manage Webinars (Posters & Meet Links)", "Blocked", "Actionable", "Actionable"],
        ["Publish Blog & Announcement CMS", "Blocked", "Actionable", "Actionable"],
        ["Manual Free User Activation", "Blocked", "Blocked", "Free + Email"],
        ["1-Click User Impersonation", "Blocked", "Blocked", "Full Access"],
        ["Set 5 Packages Prices & Commissions", "Blocked", "Blocked", "Dynamic Matrix"],
        ["Course Option (Show/Hide Visibility)", "Blocked", "Blocked", "1-Click Toggle"],
        ["Flash Sales & Coupon Code Engine", "Blocked", "Blocked", "Full Control"],
        ["Cashfree API Gateway & Webhook Keys", "Blocked", "Blocked", "Sandbox/Live"],
        ["Staff RBAC Delegation & Permissions", "Blocked", "Blocked", "Full Control"],
        ["System Audit Trail & Activity Logs", "Blocked", "Blocked", "Full Logs"],
        ["Run Web Migrations & Clear Cache", "Blocked", "Blocked", "Full Control"],
    ]
    add_table_data(doc, matrix_headers, matrix_rows, [2.5, 1.2, 1.3, 1.5])

    add_h2(doc, "7. Super Admin Visual Master Controls")
    add_callout(
        doc,
        title="Super Admin Powers",
        text="The Super Admin role possesses supreme platform authority, controlling package prices, commission matrices, Cashfree gateway credentials, staff RBAC, and manual free account activations.",
        icon="👑",
        color="2563EB",
        bg_hex="EFF6FF"
    )
    add_bullet(doc, "Activate any user ID for free. Automatically generates a unique tax invoice (INV-SKL-YYYY-XXXXX) and sends the official Welcome Email.", bold_prefix="Free User Activation: ")
    add_bullet(doc, "Click 'Login as User' on any account to immediately view the portal from that student's perspective to troubleshoot issues.", bold_prefix="1-Click User Impersonation: ")
    add_bullet(doc, "Change selling prices and direct/passive commission amounts for all 5 packages in real-time.", bold_prefix="5 Packages Pricing Matrix: ")
    add_bullet(doc, "Flip a switch to instantly hide or show any course/package on the public website.", bold_prefix="Course Show / Hide Toggle: ")
    add_bullet(doc, "Create discount coupons (flat or %), usage limits, and live countdown flash sale banners.", bold_prefix="Coupons & Flash Sales: ")
    add_bullet(doc, "Switch between Cashfree Sandbox and Live mode, and update API keys directly from the UI.", bold_prefix="Cashfree Gateway Config: ")
    add_bullet(doc, "Review withdrawal requests and click Approve or Reject with notes.", bold_prefix="1-Click Payout Approvals: ")

    doc.save(output_path)
    print(f"Saved: {output_path}")

if __name__ == "__main__":
    base_dir = r"c:\laragon\www\careerfixx-clone"
    master_file = os.path.join(base_dir, "SkillLearner_Complete_Platform_Documentation.docx")
    build_master_doc(master_file)
    print("Master documentation docx created successfully!")
