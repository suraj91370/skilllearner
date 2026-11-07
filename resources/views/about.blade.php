@extends('layouts.app')

@section('title', 'About Us — Know About SkillLearner Platform')

@section('content')
<!-- Hero / Header Banner -->
<section style="padding: 4.5rem 1.5rem 3.5rem; text-align: center; background: radial-gradient(circle at 50% 10%, rgba(10, 107, 92, 0.08) 0%, #ffffff 70%); border-bottom: 1px solid rgba(0,0,0,0.05); position: relative; overflow: hidden;">
    <!-- Ambient Blur Background Accents -->
    <div style="position: absolute; top: -50px; left: 15%; width: 280px; height: 280px; background: radial-gradient(circle, rgba(11, 79, 74, 0.08) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>
    <div style="position: absolute; bottom: -50px; right: 15%; width: 280px; height: 280px; background: radial-gradient(circle, rgba(10, 107, 92, 0.1) 0%, transparent 70%); filter: blur(50px); pointer-events: none;"></div>

    <div class="container" style="max-width: 950px; margin: 0 auto; position: relative; z-index: 2;">
        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.25); color: #0A6B5C; padding: 6px 20px; border-radius: 50px; font-size: 0.85rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.4rem;">
            <span>✨ EMPOWERING DIGITAL CAREERS</span>
        </div>
        
        <h1 style="font-size: clamp(2.4rem, 5vw, 3.5rem); font-weight: 900; letter-spacing: -1.2px; line-height: 1.15; color: #0c2340; margin-bottom: 1.2rem;">
            Know About <span style="color: #0B4F4A;">SkillLearner</span> <span style="color: #0A6B5C;">Platform</span>
        </h1>
        
        <p style="font-size: 1.15rem; line-height: 1.7; color: #475569; max-width: 760px; margin: 0 auto 2rem; font-weight: 500;">
            A next-generation practical learning and career upskilling platform dedicated to bridging the gap between education, real-world skills, and sustainable professional development.
        </p>

      
    </div>
</section>

<!-- Mission & Vision Container -->
<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 5rem 1.5rem 3rem;">

    <!-- SECTION 1: Our Mission -->
    <section class="about-split-grid" style="display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 4rem; align-items: center; margin-bottom: 6rem;">
        
        <!-- Left: Text Content -->
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(11, 79, 74, 0.08); border: 1px solid rgba(11, 79, 74, 0.2); color: #0B4F4A; padding: 5px 16px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: 1rem;">
                <span>🎯 OUR PURPOSE & COMMITMENT</span>
            </div>

            <h2 style="font-size: clamp(2.2rem, 4vw, 2.9rem); font-weight: 900; color: #0c2340; line-height: 1.2; letter-spacing: -0.8px; margin-bottom: 0.8rem;">
                Our <span style="color: #0B4F4A;">Mission</span>
            </h2>
            <div style="width: 50px; height: 4px; background: #0A6B5C; border-radius: 2px; margin-bottom: 1.8rem;"></div>

            <p style="font-size: 1.12rem; line-height: 1.8; color: #1e293b; margin-bottom: 1.2rem; font-weight: 600;">
                Our mission is to make quality skill-based education accessible to everyone by providing valuable learning opportunities that encourage continuous improvement, practical knowledge and professional development.
            </p>

            <p style="font-size: 1.05rem; line-height: 1.8; color: #475569; margin-bottom: 2rem; font-weight: 500;">
                We aim to empower individuals with the confidence and skills they need to pursue their goals and build a better future.
            </p>

            <!-- Mission Highlights -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(10, 107, 92, 0.12); color: #0A6B5C; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0; font-size: 0.9rem;">✓</div>
                    <div>
                        <strong style="color: #0c2340; font-size: 1rem;">Practical & Job-Ready Skills:</strong>
                        <span style="color: #64748b; font-size: 0.95rem;"> Curated modules focused on hands-on project creation over passive theory.</span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(10, 107, 92, 0.12); color: #0A6B5C; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0; font-size: 0.9rem;">✓</div>
                    <div>
                        <strong style="color: #0c2340; font-size: 1rem;">Accessible to Everyone:</strong>
                        <span style="color: #64748b; font-size: 0.95rem;"> High-value, affordable packages built for students, graduates, and aspiring professionals.</span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(10, 107, 92, 0.12); color: #0A6B5C; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0; font-size: 0.9rem;">✓</div>
                    <div>
                        <strong style="color: #0c2340; font-size: 1rem;">Career Confidence:</strong>
                        <span style="color: #64748b; font-size: 0.95rem;"> Empowering students with the direct capability to launch freelance services and scale digital income.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Mission Image -->
        <div style="display: flex; justify-content: center; position: relative;">
            <div style="position: absolute; inset: -15px; background: radial-gradient(circle, rgba(10, 107, 92, 0.18) 0%, transparent 70%); filter: blur(35px); pointer-events: none;"></div>
            <div style="position: relative; width: 100%; max-width: 490px; border-radius: 26px; overflow: hidden; box-shadow: 0 20px 45px -10px rgba(11, 79, 74, 0.22), 0 0 0 1px rgba(226, 232, 240, 0.9); background: #ffffff;">
                <img src="{{ asset('images/about-mission.jpg') }}" alt="SkillLearner Mission - Teamwork & Skill Growth" style="width: 100%; height: auto; display: block; object-fit: cover; transition: transform 0.4s ease;">
                
                <!-- Floating Glass Badge -->
                <div style="position: absolute; bottom: 16px; left: 16px; right: 16px; background: rgba(12, 35, 64, 0.88); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 16px; padding: 12px 18px; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.4rem;">🤝</span>
                        <div>
                            <div style="font-size: 0.82rem; font-weight: 800; color: #10B981; letter-spacing: 0.5px; text-transform: uppercase;">Real Impact</div>
                            <div style="font-size: 0.95rem; font-weight: 700;">Collaboration & Community Mentorship</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- SECTION 2: Our Vision -->
    <section class="about-split-grid about-vision-grid" style="display: grid; grid-template-columns: 0.9fr 1.1fr; gap: 4rem; align-items: center; margin-bottom: 6rem;">
        
        <!-- Left: Vision Image -->
        <div style="display: flex; justify-content: center; position: relative;">
            <div style="position: absolute; inset: -15px; background: radial-gradient(circle, rgba(16, 185, 129, 0.18) 0%, transparent 70%); filter: blur(35px); pointer-events: none;"></div>
            <div style="position: relative; width: 100%; max-width: 490px; border-radius: 26px; overflow: hidden; box-shadow: 0 20px 45px -10px rgba(10, 107, 92, 0.22), 0 0 0 1px rgba(226, 232, 240, 0.9); background: #ffffff;">
                <img src="{{ asset('images/about-vision.jpg') }}" alt="SkillLearner Vision - Upward Career Growth" style="width: 100%; height: auto; display: block; object-fit: cover; transition: transform 0.4s ease;">
                
                <!-- Floating Glass Badge -->
                <div style="position: absolute; bottom: 16px; left: 16px; right: 16px; background: rgba(12, 35, 64, 0.88); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 16px; padding: 12px 18px; color: #ffffff; display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 1.4rem;">📈</span>
                        <div>
                            <div style="font-size: 0.82rem; font-weight: 800; color: #10B981; letter-spacing: 0.5px; text-transform: uppercase;">Future Horizons</div>
                            <div style="font-size: 0.95rem; font-weight: 700;">Empowering Sustainable Growth</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Text Content -->
        <div>
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.2); color: #0A6B5C; padding: 5px 16px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; margin-bottom: 1rem;">
                <span>🚀 FUTURE HORIZONS & ASPIRATION</span>
            </div>

            <h2 style="font-size: clamp(2.2rem, 4vw, 2.9rem); font-weight: 900; color: #0c2340; line-height: 1.2; letter-spacing: -0.8px; margin-bottom: 0.8rem;">
                Our <span style="color: #0A6B5C;">Vision</span>
            </h2>
            <div style="width: 50px; height: 4px; background: #0A6B5C; border-radius: 2px; margin-bottom: 1.8rem;"></div>

            <p style="font-size: 1.12rem; line-height: 1.8; color: #1e293b; margin-bottom: 1.2rem; font-weight: 600;">
                To become a trusted and recognized online learning platform that inspires millions of individuals to learn new skills, embrace opportunities and achieve their full potential.
            </p>

            <p style="font-size: 1.05rem; line-height: 1.8; color: #475569; margin-bottom: 2rem; font-weight: 500;">
                We envision a future where learning has no limits and everyone has the opportunity to grow.
            </p>

            <!-- Vision Highlights -->
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(10, 107, 92, 0.12); color: #0A6B5C; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0; font-size: 0.9rem;">✓</div>
                    <div>
                        <strong style="color: #0c2340; font-size: 1rem;">Inspiring Millions:</strong>
                        <span style="color: #64748b; font-size: 0.95rem;"> Building an educational movement that reaches motivated learners in every corner of India.</span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(10, 107, 92, 0.12); color: #0A6B5C; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0; font-size: 0.9rem;">✓</div>
                    <div>
                        <strong style="color: #0c2340; font-size: 1rem;">Limitless Learning:</strong>
                        <span style="color: #64748b; font-size: 0.95rem;"> Removing traditional barriers of high costs, geographical distance, and rigid schedules.</span>
                    </div>
                </div>
                <div style="display: flex; align-items: flex-start; gap: 12px;">
                    <div style="width: 28px; height: 28px; border-radius: 50%; background: rgba(10, 107, 92, 0.12); color: #0A6B5C; display: flex; align-items: center; justify-content: center; font-weight: 900; flex-shrink: 0; font-size: 0.9rem;">✓</div>
                    <div>
                        <strong style="color: #0c2340; font-size: 1rem;">Full Potential Realized:</strong>
                        <span style="color: #64748b; font-size: 0.95rem;"> Providing the exact tools, mentors, and roadmaps required for long-term career mastery.</span>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- SECTION 3: What Powers SkillLearner (Core Values Grid) -->
    <section style="margin-bottom: 6rem;">
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(10, 107, 92, 0.08); border: 1px solid rgba(10, 107, 92, 0.25); color: #0A6B5C; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1rem;">
                <span>💡 WHY WE EXIST</span>
            </div>
            <h2 style="font-size: clamp(2rem, 4.5vw, 2.8rem); font-weight: 900; letter-spacing: -0.8px; margin-bottom: 0.8rem; color: #0c2340;">
                The Pillars of <span style="color: #0B4F4A;">SkillLearner</span>
            </h2>
            <p style="font-size: 1.05rem; line-height: 1.6; color: #64748b; max-width: 650px; margin: 0 auto; font-weight: 500;">
                We build every feature, module, and partnership around four foundational pillars designed for modern digital success.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.8rem;">
            
            <div class="pillar-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 4px 18px -2px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(10, 107, 92, 0.1); border: 1px solid rgba(10, 107, 92, 0.25); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.4rem;">
                    🎓
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0c2340; margin-bottom: 0.6rem;">High-Yield Skillsets</h3>
                <p style="color: #64748b; font-size: 0.92rem; line-height: 1.65; margin: 0;">
                    Courses in AI tools, Canva mastery, video editing, spoken English, and high-ticket affiliate systems that produce tangible results.
                </p>
            </div>

            <div class="pillar-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 4px 18px -2px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.4rem;">
                    ⚡
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0c2340; margin-bottom: 0.6rem;">Self-Paced Flexibility</h3>
                <p style="color: #64748b; font-size: 0.92rem; line-height: 1.65; margin: 0;">
                    Learn on your own schedule with 24/7 lifetime access on mobile, tablet, or desktop with instant dashboard activation.
                </p>
            </div>

            <div class="pillar-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 4px 18px -2px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.25); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.4rem;">
                    👥
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0c2340; margin-bottom: 0.6rem;">Dedicated Mentorship</h3>
                <p style="color: #64748b; font-size: 0.92rem; line-height: 1.65; margin: 0;">
                    Direct guidance from experienced founders and instructors committed to resolving doubts and unlocking real career progress.
                </p>
            </div>

            <div class="pillar-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 20px; padding: 2rem 1.8rem; box-shadow: 0 4px 18px -2px rgba(0,0,0,0.04); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;">
                <div style="width: 52px; height: 52px; border-radius: 14px; background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.25); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1.4rem;">
                    🏆
                </div>
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #0c2340; margin-bottom: 0.6rem;">Recognized Certification</h3>
                <p style="color: #64748b; font-size: 0.92rem; line-height: 1.65; margin: 0;">
                    Complete your coursework and earn verifiable SkillLearner course completion certificates to validate your resume and portfolio.
                </p>
            </div>

        </div>
    </section>

 

    <!-- SECTION 4: Our Leadership / Founders Section -->
    <section style="margin-bottom: 6rem;">
        <div style="text-align: center; margin-bottom: 3.5rem;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(11, 79, 74, 0.08); border: 1px solid rgba(11, 79, 74, 0.25); color: #0B4F4A; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 1rem;">
                <span>✨ VISIONARY LEADERSHIP</span>
            </div>
            <h2 style="font-size: clamp(2.2rem, 4.5vw, 3rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 0.8rem; color: #0f172a; line-height: 1.2;">
                Meet Our <span style="color: #0B4F4A;">Founder</span> &amp; <span style="color: #0A6B5C;">Co-Founder</span>
            </h2>
            <p style="font-size: 1.05rem; line-height: 1.6; color: #64748b; max-width: 680px; margin: 0 auto; font-weight: 500;">
                Dedicated to transforming digital education across India through practical mastery, high-demand skills, and sustainable career growth.
            </p>
        </div>

        <!-- 2 Founders Side-by-Side Grid -->
        <div class="founders-grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2.5rem;">
            
            <!-- Founder Card -->
            <div class="founder-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0, 0, 0, 0.02); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; display: flex; flex-direction: column;">
                <div style="width: 100%; height: 380px; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ asset('images/founder.jpg') }}" alt="Adarsh Pandey — Founder & CEO" style="width: 100%; height: 100%; object-fit: cover; object-position: center 25%; transition: transform 0.4s ease;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.5) 0%, transparent 40%);"></div>
                    
                    <span style="position: absolute; top: 16px; left: 16px; background: rgba(11, 79, 74, 0.95); backdrop-filter: blur(8px); color: #fff; padding: 5px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; border: 1px solid rgba(255, 255, 255, 0.2);">
                        ★ FOUNDER &amp; CEO
                    </span>
                </div>

                <div style="padding: 2.2rem 2rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: #0B4F4A; font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.35rem;">
                            LEADERSHIP &amp; VISION
                        </div>
                        <h3 style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin-bottom: 0.3rem; letter-spacing: -0.5px;">
                            ADARSH PANDEY
                        </h3>
                        <div style="font-size: 1.02rem; font-weight: 700; color: #0A6B5C; margin-bottom: 1.25rem;">
                            Founder &amp; CEO – Skilllearner
                        </div>
                        <p style="color: #334155; font-size: 0.95rem; line-height: 1.65; margin-bottom: 1rem; font-weight: 500;">
                            Adarsh Pandey is the Founder and CEO of Skilllearner, an online learning platform focused on digital education, skill development, and entrepreneurship.
                        </p>
                        <p style="color: #64748b; font-size: 0.92rem; line-height: 1.65; margin-bottom: 0;">
                            With 5+ years of experience in Digital Marketing and the Online Business Industry, he brings knowledge of digital growth, branding, online marketing, and business development.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Co-Founder Card -->
            <div class="founder-card" style="background: #ffffff; border: 1px solid rgba(226, 232, 240, 0.9); border-radius: 24px; overflow: hidden; box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.06), 0 5px 15px rgba(0, 0, 0, 0.02); transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease; display: flex; flex-direction: column;">
                <div style="width: 100%; height: 380px; position: relative; overflow: hidden; background: #0f172a;">
                    <img src="{{ asset('images/co-founder.jpg') }}" alt="Ravi Gond — Co-Founder" style="width: 100%; height: 100%; object-fit: cover; object-position: center 20%; transition: transform 0.4s ease;">
                    <div style="position: absolute; inset: 0; background: linear-gradient(to top, rgba(15, 23, 42, 0.5) 0%, transparent 40%);"></div>
                    
                    <span style="position: absolute; top: 16px; left: 16px; background: rgba(217, 119, 6, 0.95); backdrop-filter: blur(8px); color: #fff; padding: 5px 14px; border-radius: 50px; font-size: 0.78rem; font-weight: 800; letter-spacing: 0.8px; text-transform: uppercase; border: 1px solid rgba(255, 255, 255, 0.2);">
                        ★ CO-FOUNDER
                    </span>
                </div>

                <div style="padding: 2.2rem 2rem; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <div style="color: #D97706; font-size: 0.82rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.35rem;">
                            GROWTH &amp; OPERATIONS
                        </div>
                        <h3 style="font-size: 1.8rem; font-weight: 900; color: #0f172a; margin-bottom: 0.3rem; letter-spacing: -0.5px;">
                            RAVI GOND
                        </h3>
                        <div style="font-size: 1.02rem; font-weight: 700; color: #D97706; margin-bottom: 1.25rem;">
                            Co-Founder – Skilllearner
                        </div>
                        <p style="color: #334155; font-size: 0.95rem; line-height: 1.65; margin-bottom: 1rem; font-weight: 500;">
                            Ravi Gond is the Co-Founder of Skilllearner, an online learning platform focused on digital education, skill development, and entrepreneurship.
                        </p>
                        <p style="color: #64748b; font-size: 0.92rem; line-height: 1.65; margin-bottom: 0;">
                            With 4+ years of experience in Digital Marketing and Online Business, he has developed knowledge of digital marketing, online branding, business development, and sales strategies.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <section style="background: linear-gradient(135deg, #0c2340 0%, #071729 100%); border-radius: 28px; padding: 4rem 2rem; text-align: center; color: #ffffff; position: relative; overflow: hidden; box-shadow: 0 25px 50px -15px rgba(12, 35, 64, 0.35);">
        <div style="position: absolute; top: -30px; right: -30px; width: 220px; height: 220px; background: radial-gradient(circle, rgba(10, 107, 92, 0.35) 0%, transparent 70%); filter: blur(40px); pointer-events: none;"></div>
        <div style="position: absolute; bottom: -30px; left: -30px; width: 220px; height: 220px; background: radial-gradient(circle, rgba(16, 185, 129, 0.25) 0%, transparent 70%); filter: blur(40px); pointer-events: none;"></div>

        <div style="position: relative; z-index: 2; max-width: 700px; margin: 0 auto;">
            <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 6px 18px; border-radius: 50px; font-size: 0.82rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 1.2rem;">
                🚀 START YOUR JOURNEY TODAY
            </div>
            
            <h2 style="font-size: clamp(2rem, 4vw, 2.7rem); font-weight: 900; letter-spacing: -0.8px; margin-bottom: 1rem; line-height: 1.25;">
                Ready to Build Your Skill &amp; Shape Your Future?
            </h2>
            
            <p style="font-size: 1.05rem; line-height: 1.65; color: #cbd5e1; margin-bottom: 2.2rem; font-weight: 400;">
                Unlock our curated packages, access comprehensive step-by-step masterclasses, and step into high-income digital opportunities with SkillLearner.
            </p>

            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="{{ url('/courses') }}" class="btn btn-primary" style="background: #0A6B5C; padding: 0.95rem 2.2rem; font-size: 1.05rem; font-weight: 800; border-radius: 12px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 10px 25px rgba(10, 107, 92, 0.4);">
                    <span>Explore Packages</span>
                    <span>➔</span>
                </a>
                <a href="{{ url('/contact') }}" class="btn btn-secondary" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff; padding: 0.95rem 2rem; font-size: 1.05rem; font-weight: 700; border-radius: 12px; text-decoration: none;">
                    Contact Our Team
                </a>
            </div>
        </div>
    </section>

</div>

@push('styles')
<style>
    .pillar-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 32px -4px rgba(11, 79, 74, 0.12), 0 4px 12px -2px rgba(0,0,0,0.03) !important;
        border-color: rgba(11, 79, 74, 0.3) !important;
    }
    .founder-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 45px -8px rgba(11, 79, 74, 0.16) !important;
        border-color: rgba(11, 79, 74, 0.35) !important;
    }
    .founder-card:hover img {
        transform: scale(1.04);
    }

    @media (max-width: 900px) {
        .about-split-grid {
            grid-template-columns: 1fr !important;
            gap: 2.5rem !important;
        }
        .about-vision-grid > div:first-child {
            order: 2;
        }
        .about-vision-grid > div:last-child {
            order: 1;
        }
        .founders-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>
@endpush
@endsection

