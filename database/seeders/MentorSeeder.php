<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coreMentors = [
            [
                'name' => 'Adarsh Pandey',
                'email' => 'adarsh.pandey@skilllearner.com',
                'phone' => '+91 98765 00001',
                'photo' => 'images/founder.jpg',
                'designation' => 'Founder & CEO – Skilllearner',
                'badge' => '★ FOUNDER & CEO',
                'bio' => 'Founder and CEO with 5+ years of experience in Digital Marketing and Online Business, bringing deep expertise in digital growth and branding.',
                'expertise' => 'Digital Marketing, Online Business, Growth & Branding',
                'experience' => '5+ Years',
                'qualification' => 'Founder & CEO, Digital Growth Strategist',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 25.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'ADRSH1234F',
                'aadhar_number' => '9876 5432 1001',
                'bank_name' => 'HDFC Bank',
                'holder_name' => 'Adarsh Pandey',
                'account_number' => '50100458923001',
                'ifsc_code' => 'HDFC0001234',
                'upi_id' => 'adarsh@hdfcbank',
                'total_earned' => 145000.00,
                'wallet_balance' => 24500.00,
            ],
            [
                'name' => 'Ravi Gond',
                'email' => 'ravi.gond@skilllearner.com',
                'phone' => '+91 98765 00002',
                'photo' => 'images/co-founder.jpg',
                'designation' => 'Co-Founder – Skilllearner',
                'badge' => '★ CO-FOUNDER',
                'bio' => 'Co-Founder with 4+ years of experience in Digital Marketing and Online Business, specializing in sales strategies and online branding.',
                'expertise' => 'Sales Strategies, Online Branding, Business Scaling',
                'experience' => '4+ Years',
                'qualification' => 'Co-Founder, Sales & Brand Specialist',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 20.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'RAVIG5678Y',
                'aadhar_number' => '9876 5432 1002',
                'bank_name' => 'ICICI Bank',
                'holder_name' => 'Ravi Gond',
                'account_number' => '189201928002',
                'ifsc_code' => 'ICIC0001892',
                'upi_id' => 'ravi@icici',
                'total_earned' => 98000.00,
                'wallet_balance' => 18200.00,
            ],
            [
                'name' => 'Pavan Prajapati',
                'email' => 'pavan.prajapati@skilllearner.com',
                'phone' => '+91 98765 00003',
                'photo' => 'images/mentor-1.jpg',
                'designation' => 'SkillLearner EdTech',
                'badge' => '★ PAVAN PRAJAPATI',
                'bio' => 'Dedicated mentor offering practical guidance, hands-on masterclasses, and career coaching to help learners achieve measurable digital growth.',
                'expertise' => 'Practical Masterclasses, Career Coaching, Digital Growth',
                'experience' => '4+ Years',
                'qualification' => 'Expert Mentor, Career Coach',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 15.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'PAVAN9012P',
                'aadhar_number' => '9876 5432 1003',
                'bank_name' => 'State Bank of India',
                'holder_name' => 'Pavan Prajapati',
                'account_number' => '309823478003',
                'ifsc_code' => 'SBIN0004321',
                'upi_id' => 'pavan@sbi',
                'total_earned' => 45000.00,
                'wallet_balance' => 9500.00,
            ],
            [
                'name' => 'Soumyadip Pania',
                'email' => 'soumyadip.pania@skilllearner.com',
                'phone' => '+91 98765 00004',
                'photo' => 'images/mentor-2.jpg',
                'designation' => 'SkillLearner EdTech',
                'badge' => '★ SOUMYADIP PANIA',
                'bio' => 'Empowering students with actionable digital skills, real-time problem solving, and proven strategies to succeed in competitive markets.',
                'expertise' => 'Digital Skills, Problem Solving, Market Strategy',
                'experience' => '3+ Years',
                'qualification' => 'Expert Mentor, Digital Strategist',
                'social_links' => [
                    'linkedin' => 'https://linkedin.com',
                    'youtube' => 'https://youtube.com',
                    'twitter' => '',
                    'github' => '',
                ],
                'commission_percentage' => 15.00,
                'assigned_courses' => [],
                'status' => 'active',
                'is_featured' => true,
                'kyc_status' => 'approved',
                'pan_number' => 'SOUMY3456K',
                'aadhar_number' => '9876 5432 1004',
                'bank_name' => 'Axis Bank',
                'holder_name' => 'Soumyadip Pania',
                'account_number' => '918020038004',
                'ifsc_code' => 'UTIB0000123',
                'upi_id' => 'soumyadip@axisbank',
                'total_earned' => 38000.00,
                'wallet_balance' => 7800.00,
            ],
        ];

        foreach ($coreMentors as $data) {
            Mentor::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }
    }
}
