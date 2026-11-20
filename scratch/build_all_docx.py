import os
from docx import Document
from docx.shared import Inches, Pt, RGBColor
from docx.enum.text import WD_ALIGN_PARAGRAPH
from docx.enum.table import WD_TABLE_ALIGNMENT
from docx.oxml import parse_xml
from docx.oxml.ns import nsdecls

def set_cell_background(cell, fill_hex):
    tcPr = cell._element.get_or_add_tcPr()
    shd = parse_xml(f'<w:shd {nsdecls("w")} w:fill="{fill_hex}"/>')
    tcPr.append(shd)

def set_cell_margins(cell, top=140, bottom=140, left=180, right=180):
    tcPr = cell._element.get_or_add_tcPr()
    tcMar = parse_xml(f'<w:tcMar {nsdecls("w")}><w:top w:w="{top}" w:type="dxa"/><w:bottom w:w="{bottom}" w:type="dxa"/><w:left w:w="{left}" w:type="dxa"/><w:right w:w="{right}" w:type="dxa"/></w:tcMar>')
    tcPr.append(tcMar)

def set_cell_border(cell, **kwargs):
    tcPr = cell._element.get_or_add_tcPr()
    borders = parse_xml(f'<w:tcBorders {nsdecls("w")}/>')
    for edge, opts in kwargs.items():
        val = opts.get('val', 'single')
        sz = opts.get('sz', '4')
        color = opts.get('color', 'CCCCCC')
        b_elem = parse_xml(f'<w:{edge} {nsdecls("w")} w:val="{val}" w:sz="{sz}" w:space="0" w:color="{color}"/>')
        borders.append(b_elem)
    tcPr.append(borders)

def add_header_banner(doc, title, subtitle, badge_text="SKILLLEARNER OFFICIAL PLATFORM GUIDE"):
    p_badge = doc.add_paragraph()
    p_badge.paragraph_format.space_before = Pt(0)
    p_badge.paragraph_format.space_after = Pt(4)
    run_b = p_badge.add_run(f"● {badge_text.upper()}")
    run_b.font.name = "Segoe UI"
    run_b.font.size = Pt(9.5)
    run_b.font.bold = True
    run_b.font.color.rgb = RGBColor(5, 179, 150)
    
    p_title = doc.add_paragraph()
    p_title.paragraph_format.space_before = Pt(0)
    p_title.paragraph_format.space_after = Pt(6)
    run_t = p_title.add_run(title)
    run_t.font.name = "Segoe UI"
    run_t.font.size = Pt(22)
    run_t.font.bold = True
    run_t.font.color.rgb = RGBColor(15, 23, 42)
    
    p_sub = doc.add_paragraph()
    p_sub.paragraph_format.space_before = Pt(0)
    p_sub.paragraph_format.space_after = Pt(14)
    run_s = p_sub.add_run(subtitle)
    run_s.font.name = "Segoe UI"
    run_s.font.size = Pt(11)
    run_s.font.color.rgb = RGBColor(100, 116, 139)
    
    p_div = doc.add_paragraph()
    p_div.paragraph_format.space_before = Pt(0)
    p_div.paragraph_format.space_after = Pt(14)
    pBrd = parse_xml(f'<w:pBrd {nsdecls("w")}><w:bottom w:val="single" w:sz="16" w:space="4" w:color="05B396"/></w:pBrd>')
    p_div._p.get_or_add_pPr().append(pBrd)

def add_h1(doc, text):
    h = doc.add_heading(text, level=1)
    h.paragraph_format.space_before = Pt(18)
    h.paragraph_format.space_after = Pt(6)
    h.paragraph_format.keep_with_next = True
    for run in h.runs:
        run.font.name = "Segoe UI"
        run.font.size = Pt(15)
        run.font.bold = True
        run.font.color.rgb = RGBColor(15, 23, 42)
    return h

def add_h2(doc, text):
    h = doc.add_heading(text, level=2)
    h.paragraph_format.space_before = Pt(13)
    h.paragraph_format.space_after = Pt(4)
    h.paragraph_format.keep_with_next = True
    for run in h.runs:
        run.font.name = "Segoe UI"
        run.font.size = Pt(12)
        run.font.bold = True
        run.font.color.rgb = RGBColor(5, 179, 150)
    return h

def add_h3(doc, text):
    h = doc.add_heading(text, level=3)
    h.paragraph_format.space_before = Pt(9)
    h.paragraph_format.space_after = Pt(2)
    h.paragraph_format.keep_with_next = True
    for run in h.runs:
        run.font.name = "Segoe UI"
        run.font.size = Pt(10.5)
        run.font.bold = True
        run.font.color.rgb = RGBColor(37, 99, 235)
    return h

def add_p(doc, text, bold_prefix=None, italic=False):
    p = doc.add_paragraph()
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(5)
    p.paragraph_format.line_spacing = 1.15
    if bold_prefix:
        r_pre = p.add_run(bold_prefix)
        r_pre.font.name = "Segoe UI"
        r_pre.font.bold = True
        r_pre.font.color.rgb = RGBColor(15, 23, 42)
    r_text = p.add_run(text)
    r_text.font.name = "Segoe UI"
    r_text.font.italic = italic
    r_text.font.color.rgb = RGBColor(51, 65, 85)
    return p

def add_bullet(doc, text, bold_prefix=None):
    p = doc.add_paragraph(style='List Bullet')
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(3)
    p.paragraph_format.line_spacing = 1.15
    if bold_prefix:
        r_pre = p.add_run(bold_prefix)
        r_pre.font.name = "Segoe UI"
        r_pre.font.bold = True
        r_pre.font.color.rgb = RGBColor(15, 23, 42)
    r_text = p.add_run(text)
    r_text.font.name = "Segoe UI"
    r_text.font.color.rgb = RGBColor(51, 65, 85)
    return p

def add_callout(doc, title, text, icon="ℹ️", color="05B396", bg_hex="F0FDF4"):
    tbl = doc.add_table(rows=1, cols=1)
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER
    tbl.autofit = False
    cell = tbl.cell(0, 0)
    cell.width = Inches(6.5)
    set_cell_background(cell, bg_hex)
    set_cell_margins(cell, top=140, bottom=140, left=200, right=180)
    set_cell_border(cell, 
                    left={'val': 'single', 'sz': '24', 'color': color},
                    top={'val': 'single', 'sz': '4', 'color': 'E2E8F0'},
                    right={'val': 'single', 'sz': '4', 'color': 'E2E8F0'},
                    bottom={'val': 'single', 'sz': '4', 'color': 'E2E8F0'})
    
    p = cell.paragraphs[0]
    p.paragraph_format.space_before = Pt(0)
    p.paragraph_format.space_after = Pt(2)
    r_icon = p.add_run(f"{icon}  {title}\n")
    r_icon.font.name = "Segoe UI"
    r_icon.font.bold = True
    r_icon.font.size = Pt(10)
    if color == "05B396":
        r_icon.font.color.rgb = RGBColor(21, 128, 61)
    elif color == "DC2626":
        r_icon.font.color.rgb = RGBColor(185, 28, 28)
    else:
        r_icon.font.color.rgb = RGBColor(30, 64, 175)
        
    r_text = p.add_run(text)
    r_text.font.name = "Segoe UI"
    r_text.font.size = Pt(9.5)
    r_text.font.color.rgb = RGBColor(51, 65, 85)
    doc.add_paragraph().paragraph_format.space_after = Pt(4)

def add_table_data(doc, headers, rows, col_widths=None):
    tbl = doc.add_table(rows=len(rows) + 1, cols=len(headers))
    tbl.alignment = WD_TABLE_ALIGNMENT.CENTER
    tbl.autofit = False
    
    hdr_cells = tbl.rows[0].cells
    for i, h_text in enumerate(headers):
        hdr_cells[i].text = h_text
        set_cell_background(hdr_cells[i], "0F172A")
        set_cell_margins(hdr_cells[i], top=120, bottom=120, left=120, right=120)
        p = hdr_cells[i].paragraphs[0]
        for r in p.runs:
            r.font.name = "Segoe UI"
            r.font.bold = True
            r.font.size = Pt(9)
            r.font.color.rgb = RGBColor(255, 255, 255)
            
    for r_idx, row_data in enumerate(rows):
        row_cells = tbl.rows[r_idx + 1].cells
        bg = "FFFFFF" if r_idx % 2 == 0 else "F8FAFC"
        for c_idx, cell_value in enumerate(row_data):
            row_cells[c_idx].text = str(cell_value)
            set_cell_background(row_cells[c_idx], bg)
            set_cell_margins(row_cells[c_idx], top=90, bottom=90, left=120, right=120)
            set_cell_border(row_cells[c_idx],
                            bottom={'val': 'single', 'sz': '4', 'color': 'E2E8F0'},
                            top={'val': 'single', 'sz': '4', 'color': 'E2E8F0'},
                            left={'val': 'none'}, right={'val': 'none'})
            p = row_cells[c_idx].paragraphs[0]
            for r in p.runs:
                r.font.name = "Segoe UI"
                r.font.size = Pt(8.5)
                r.font.color.rgb = RGBColor(30, 41, 59)
                
    if col_widths:
        for row in tbl.rows:
            for i, w in enumerate(col_widths):
                row.cells[i].width = Inches(w)
                
    doc.add_paragraph().paragraph_format.space_after = Pt(6)


# ==============================================================================
# DOCUMENT 1: FRONTEND USER GUIDE (HOW THE PROJECT WORKS)
# ==============================================================================
def build_frontend_user_guide(output_path):
    doc = Document()
    for s in doc.sections:
        s.top_margin = Inches(0.8)
        s.bottom_margin = Inches(0.8)
        s.left_margin = Inches(0.8)
        s.right_margin = Inches(0.8)

    add_header_banner(
        doc,
        title="SkillLearner: Frontend Platform Walkthrough & User Guide",
        subtitle="A non-technical, visual step-by-step manual explaining how the website works for students, affiliates, and super admins.",
        badge_text="END-USER & AFFILIATE EXPERIENCE GUIDE"
    )

    add_h1(doc, "1. What is SkillLearner?")
    add_p(doc, "SkillLearner is a modern platform that combines High-Income Skill Education with a lucrative Two-Tier Affiliate Earning Opportunity:")
    add_bullet(doc, "Learn career-ready digital skills (Video Editing, Social Media Growth, AI Tools, Sales Funnels, Personal Branding) structured across 5 package tiers.", bold_prefix="For Students: ")
    add_bullet(doc, "Earn substantial direct (Active) and team (Passive) income by sharing skill packages with leads using ready-made reels, posters, live webinars, and training masterclasses.", bold_prefix="For Affiliates: ")

    add_callout(
        doc,
        title="Quick 6-Step Journey",
        text="1. Browse Course Packages -> 2. Register with Sponsor ID -> 3. Pay via Cashfree Gateway -> 4. Watch HD Courses & Earn Certificates -> 5. Download Ready-Made Reels & Posters to Promote -> 6. Submit KYC & Receive Weekly Direct Bank Payouts.",
        icon="🚀",
        color="05B396",
        bg_hex="F0FDF4"
    )

    add_h1(doc, "2. What a Visitor Sees: The Public Website")
    add_p(doc, "When a visitor opens the website on their phone or laptop, they see:")
    add_bullet(doc, "Introduces the platform, key benefits, student results, and how affiliate learning works.", bold_prefix="Hero Pitch Video: ")
    add_bullet(doc, "Highlights active limited-time offers or discount coupon codes.", bold_prefix="Top Notification Bar: ")
    add_bullet(doc, "Shows the 5 distinct educational tiers with pricing, curriculum, and features.", bold_prefix="5 Package Tiers: ")

    # Packages Table
    pkg_headers = ["Package Name", "Target Audience", "Key Skills Taught", "Affiliate Benefit"]
    pkg_rows = [
        ["Basic (e-Lite)", "Beginners", "Social media basics, digital starter pack", "Entry-level commissions"],
        ["Growth Package", "Active Creators", "Instagram reels mastery, organic lead generation", "Higher active commission"],
        ["Advance Package", "Video Creators", "Presentation skills, video sales letters, funnels", "Strong passive leverage"],
        ["Premium Package", "Entrepreneurs", "Automation funnels, ads, high-ticket closing", "High-tier commissions"],
        ["Infinity Package", "Elite Earners", "Full master bundle + personal branding secrets", "Maximum active & passive rates"],
    ]
    add_table_data(doc, pkg_headers, pkg_rows, [1.3, 1.4, 2.3, 1.5])

    add_bullet(doc, "Verified instructor cards with photos, designations, and expertise tags.", bold_prefix="Mentor Directory: ")
    add_bullet(doc, "Real student earnings proofs and reviews.", bold_prefix="Student Reviews & Proofs: ")

    add_h1(doc, "3. Registration, Payment & The Security Gate")
    add_p(doc, "How a new student joins the platform:")
    add_bullet(doc, "The student opens a mentor's referral link. The sponsor's name and ID are locked in automatically.", bold_prefix="Step 1 - Registration: ")
    add_bullet(doc, "The student is redirected to the secure Cashfree checkout to pay via UPI (GPay/PhonePe), Cards, or NetBanking.", bold_prefix="Step 2 - Payment: ")
    add_bullet(doc, "Instantly upon payment, an official Tax Invoice (INV-SKL-2026-XXXXX) is generated, a Welcome Email with login details is sent, and the student can log in.", bold_prefix="Step 3 - Instant Activation: ")

    add_callout(
        doc,
        title="The Strict Security Gate Rule",
        text="If someone registers, enters the payment screen, and then presses 'Back' or closes the browser without paying, they CANNOT log into the website. The system blocks login access until either: (1) they complete the payment, or (2) a Super Admin manually activates their ID for free.",
        icon="🔒",
        color="DC2626",
        bg_hex="FEF2F2"
    )

    add_h1(doc, "4. Inside the Student Portal: Learning & Certification")
    add_p(doc, "Once logged in, students access their personal Portal:")
    add_bullet(doc, "All video courses included in their package appear as interactive cards.", bold_prefix="My Courses: ")
    add_bullet(doc, "High-definition video lessons with chapter navigation and mark-complete tracking.", bold_prefix="HD Video Player: ")
    add_bullet(doc, "When all lessons in a course are completed, students instantly unlock an official completion certificate with their name.", bold_prefix="Course Certificates: ")

    add_h1(doc, "5. The Affiliate Earning Machine (How to Earn Money)")
    add_p(doc, "Every enrolled student can earn money by sharing SkillLearner:")
    add_bullet(doc, "Every user gets their master referral link, package checkout links, and a scannable QR Code.", bold_prefix="1. Referral Links & QR Code: ")
    add_bullet(doc, "Users don't need to make videos or design posters. They visit 'Marketing Tools' to preview and download 9:16 vertical Short Videos/Reels and high-res promotional posters to put on WhatsApp Status and Instagram.", bold_prefix="2. Marketing Tools (Shorts & Posters): ")
    add_bullet(doc, "Step-by-step masterclasses on attracting organic leads, WhatsApp conversation closing scripts, and objection handling.", bold_prefix="3. Affiliate Training Masterclasses: ")
    add_bullet(doc, "Company reward challenges (e.g. Goa Trip Vacation, ₹25,000 Cash Bonus, Laptop Challenge). Affiliates see the qualification target, countdown timer, and can download official offer posters.", bold_prefix="4. Live Contests & Offers: ")
    add_bullet(doc, "Weekly live workshops with mentors. Affiliates get a 1-click 'Join Live Meeting' button (Zoom/Google Meet) and a 'Download Poster' button to invite their prospects.", bold_prefix="5. Live Webinars: ")
    add_bullet(doc, "Direct 1-click links to join verified WhatsApp channels, Telegram groups, Instagram, and YouTube.", bold_prefix="6. Official Social Communities: ")

    add_h1(doc, "6. Financials, KYC & Getting Paid into Your Bank")
    add_bullet(doc, "Earned immediately when a lead buys a package directly through your referral link.", bold_prefix="Active Direct Commission: ")
    add_bullet(doc, "Earned when a student referred by you makes a sale. You earn leverage income from your team.", bold_prefix="Passive Tier-2 Commission: ")
    add_bullet(doc, "Displays Today's Earnings, Last 7 Days, Last 30 Days, All-Time Total, and team breakdown.", bold_prefix="Earning Dashboard: ")
    add_bullet(doc, "Affiliates submit their Bank Account Number, IFSC Code, Bank Name, and UPI ID.", bold_prefix="KYC Submission: ")
    add_bullet(doc, "Company audits and credits payouts weekly directly into the affiliate's bank account or UPI.", bold_prefix="Weekly Payouts: ")
    add_bullet(doc, "Live platform-wide ranking showing top earners of the day, week, month, and all time.", bold_prefix="Leaderboard: ")

    add_h1(doc, "7. How Super Admin Manages the Platform (Visual Admin Tour)")
    add_p(doc, "Super Admins manage the platform visually through buttons and forms — no coding required:")
    add_bullet(doc, "Can activate any user ID for free with 1 click. Generates an official invoice and sends the Welcome Email automatically.", bold_prefix="Free User Activation: ")
    add_bullet(doc, "1-click 'Login as User' button to inspect any student's portal exactly as they see it, with a return button at the top.", bold_prefix="User Impersonation: ")
    add_bullet(doc, "Change selling prices and exact active/passive commission amounts for all 5 packages in seconds.", bold_prefix="Package Pricing & Commission Matrix: ")
    add_bullet(doc, "Flip a switch to instantly hide or show any course/package on the public website.", bold_prefix="Course Show / Hide Toggle: ")
    add_bullet(doc, "Upload reels, posters, webinars, and live contest banners with simple file upload forms.", bold_prefix="Media & Content Uploader: ")
    add_bullet(doc, "Switch between Cashfree Test and Live mode, and update API keys directly from the UI.", bold_prefix="Cashfree Gateway Config: ")
    add_bullet(doc, "Review affiliate withdrawal requests and click Approve or Reject with notes.", bold_prefix="1-Click Payout Approvals: ")

    doc.save(output_path)
    print(f"Saved: {output_path}")


# ==============================================================================
# DOCUMENT 2: ROLES & PERMISSIONS GUIDE (SYSTEM CAPABILITIES SPECIFICATION)
# ==============================================================================
def build_roles_permissions_guide(output_path):
    doc = Document()
    for s in doc.sections:
        s.top_margin = Inches(0.8)
        s.bottom_margin = Inches(0.8)
        s.left_margin = Inches(0.8)
        s.right_margin = Inches(0.8)

    add_header_banner(
        doc,
        title="SkillLearner: System Roles, Permissions & Capabilities",
        subtitle="Comprehensive administrative and technical permissions matrix for Students, Operations Admins, and Super Admins.",
        badge_text="OFFICIAL ROLE SPECIFICATION SPEC"
    )

    add_h1(doc, "1. Architecture & Role Hierarchy")
    add_p(doc, "SkillLearner operates with a structured 3-tier role hierarchy:")
    add_bullet(doc, "Enrolled students who learn skills, promote referral links, access marketing materials, and earn affiliate commissions.", bold_prefix="1. Student / Affiliate User (role: user/student): ")
    add_bullet(doc, "Operational managers who oversee payout approvals, content uploads, webinars, live offers, and mentor profiles.", bold_prefix="2. Operations Admin (role: admin): ")
    add_bullet(doc, "Complete system owner with unrestricted access to pricing engines, Cashfree API credentials, manual activations, RBAC, and audit logs.", bold_prefix="3. Super Admin (role: super_admin): ")

    add_h1(doc, "2. Master Permissions & Capabilities Matrix")
    
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

    add_h1(doc, "3. Student / Affiliate (User) Specification")
    add_p(doc, "Key functional entitlements for regular students:")
    add_bullet(doc, "Cannot access the student dashboard after registration until payment is confirmed by Cashfree or granted by Super Admin.", bold_prefix="Access Control: ")
    add_bullet(doc, "High-definition course player with chapter modules, lesson completion tracking, and downloadable completion certificates.", bold_prefix="Curriculum: ")
    add_bullet(doc, "Personal referral link generator, package-specific links, and instant QR Code creation.", bold_prefix="Affiliate Tools: ")
    add_bullet(doc, "Direct download of promotional 9:16 short reels and graphic flyers for social media broadcasting.", bold_prefix="Marketing Library: ")
    add_bullet(doc, "YouTube-embedded training masterclasses for organic traffic and sales closing.", bold_prefix="Training: ")
    add_bullet(doc, "1-click meeting access to Zoom/Google Meet live webinars with promotional poster downloads.", bold_prefix="Webinars: ")
    add_bullet(doc, "Submission of Bank Account, IFSC, and UPI ID for automated weekly payouts.", bold_prefix="KYC & Payouts: ")

    add_h1(doc, "4. Operations Admin Specification")
    add_p(doc, "Operations staff handle daily business fulfillment:")
    add_bullet(doc, "Inspect withdrawal requests against submitted KYC bank details. Approve payouts or reject with reason notes.", bold_prefix="Payout Approvals: ")
    add_bullet(doc, "Upload new mentor profiles with professional photo uploads, credentials, and social links.", bold_prefix="Mentor Curation: ")
    add_bullet(doc, "Upload short videos (.mp4) and graphic posters (.png, .jpg), manage categories, and monitor download statistics.", bold_prefix="Marketing Tools: ")
    add_bullet(doc, "Add training modules, embed YouTube videos, set durations, and assign step tags.", bold_prefix="Affiliate Training: ")
    add_bullet(doc, "Add new WhatsApp/Telegram channels, adjust button labels, set theme colors, and toggle active status.", bold_prefix="Social Links: ")
    add_bullet(doc, "Upload promotional posters, configure prize targets, set countdown timers, and manage status.", bold_prefix="Live Offers: ")
    add_bullet(doc, "Schedule sessions, upload invitation banners, and configure Zoom/Google Meet links.", bold_prefix="Webinars: ")

    add_h1(doc, "5. Super Admin (System Ownership) Specification")
    add_callout(
        doc,
        title="Super Admin God-Mode",
        text="The Super Admin role is the supreme platform authority. It bypasses all permission checks and possesses exclusive control over system pricing, payment gateways, free activations, and audit logs.",
        icon="👑",
        color="2563EB",
        bg_hex="EFF6FF"
    )
    add_bullet(doc, "Can activate any registered user ID without payment. Generates a collision-free tax invoice (INV-SKL-YYYY-XXXXX), records order as paid, and sends the official Welcome Email.", bold_prefix="Manual Free User Activation: ")
    add_bullet(doc, "Can click 'Login as User' on any account to troubleshoot issues directly from the student's perspective.", bold_prefix="1-Click User Impersonation: ")
    add_bullet(doc, "Dynamic adjustment of base prices, Direct Active Commission, and Tier-2 Passive Commission for all 5 packages.", bold_prefix="5 Packages Pricing Matrix: ")
    add_bullet(doc, "Toggle individual courses or packages to show or hide them from the public store.", bold_prefix="Course Show / Hide Toggle: ")
    add_bullet(doc, "Create discount coupons (flat or %), usage limits, expiry dates, and countdown flash sale banners.", bold_prefix="Coupons & Flash Sales: ")
    add_bullet(doc, "Switch Cashfree between Sandbox and Live, and update App ID, Secret Key, and Webhook Secret directly from the UI.", bold_prefix="Cashfree Gateway Settings: ")
    add_bullet(doc, "Create staff accounts, assign granular permissions, and review the full audit log of all system actions.", bold_prefix="RBAC & Audit Trail: ")

    doc.save(output_path)
    print(f"Saved: {output_path}")


# ==============================================================================
# MAIN EXECUTION
# ==============================================================================
if __name__ == "__main__":
    base_dir = r"c:\laragon\www\careerfixx-clone"
    
    file1 = os.path.join(base_dir, "SkillLearner_Frontend_User_Guide.docx")
    file2 = os.path.join(base_dir, "SkillLearner_Roles_and_Permissions_Guide.docx")
    
    build_frontend_user_guide(file1)
    build_roles_permissions_guide(file2)
    print("All docx documents generated successfully!")
