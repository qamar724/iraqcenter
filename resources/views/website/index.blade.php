@php
    $lang = request()->get('lang', 'en');
    $isRtl = $lang === 'ar';

    // Translations
    $t = [
        'en' => [
            'site_name' => 'Doctors Syndicate',
            'site_desc' => 'Supporting Medical Excellence',
            'meta_desc' => 'Doctors Syndicate - Supporting Medical Professionals',
            'home' => 'Home',
            'about' => 'About Us',
            'services' => 'Services',
            'news' => 'News',
            'contact' => 'Contact',
            'member_portal' => 'Member Portal',
            'working_hours_short' => 'Sun - Thu: 8:00 AM - 4:00 PM',
            'established' => 'Established Since 1950',
            'hero_title' => 'Empowering',
            'hero_title_highlight' => 'Doctors',
            'hero_title_end' => 'Building Healthcare Excellence',
            'hero_desc' =>
                'The Doctors Syndicate is dedicated to advancing the medical profession, protecting physicians\' rights, and promoting excellence in healthcare delivery.',
            'doctors_portal' => 'Doctor\'s Portal',
            'our_services' => 'Our Services',
            'registered_doctors' => 'Registered Doctors',
            'partner_hospitals' => 'Partner Hospitals',
            'specialties' => 'Specialties',
            'years_service' => 'Years of Service',
            'doctor_info_system' => 'Doctor Information System',
            'doctor_info_desc' => 'Access your profile and manage your information',
            'hospital_distribution' => 'Hospital Distribution',
            'hospital_dist_desc' => 'View and apply for hospital placements',
            'monthly_evaluations' => 'Monthly Evaluations',
            'evaluations_desc' => 'Submit and track your performance assessments',
            'support_inquiries' => 'Support & Inquiries',
            'support_desc' => 'Get help with your questions and concerns',
            'about_title' => 'About Doctors Syndicate',
            'years_excellence' => 'Years of Excellence',
            'about_lead' => 'A Professional Organization Dedicated to Medical Excellence',
            'about_p1' =>
                'The Doctors Syndicate was established to serve as the voice of medical professionals, advocating for their rights and promoting the highest standards of healthcare delivery.',
            'about_p2' =>
                'We provide comprehensive support to our members through various services including membership management, hospital placement, continuing education, and legal assistance.',
            'professional_protection' => 'Professional Protection',
            'protection_desc' => 'Legal support and advocacy for physicians',
            'continuing_education' => 'Continuing Education',
            'education_desc' => 'Professional development programs and workshops',
            'member_welfare' => 'Member Welfare',
            'welfare_desc' => 'Support programs and benefits for members',
            'learn_more' => 'Learn More',
            'services_subtitle' => 'Comprehensive support for medical professionals at every stage of their career',
            'membership_services' => 'Membership Services',
            'membership_desc' =>
                'Register, renew, and manage your syndicate membership. Access exclusive member benefits and resources.',
            'hospital_dist_full' =>
                'Streamlined placement and distribution services for doctors across hospitals and healthcare facilities.',
            'evaluations_full' =>
                'Performance evaluations and assessments to ensure professional growth and maintain excellence standards.',
            'education_full' =>
                'Professional development programs, workshops, and certification courses to advance your career.',
            'legal_support' => 'Legal Support',
            'legal_desc' =>
                'Expert legal assistance and advocacy for workplace issues, contracts, and professional matters.',
            'career_opportunities' => 'Career Opportunities',
            'career_desc' => 'Browse job listings and career opportunities posted by healthcare institutions.',
            'doctor_system_title' => 'Doctor Information Management System',
            'doctor_system_desc' =>
                'A comprehensive platform for managing and organizing doctors\' affairs, providing various electronic services seamlessly.',
            'feature1' => 'Manage your profile and credentials',
            'feature2' => 'Track your membership status and renewals',
            'feature3' => 'Access training and certification records',
            'feature4' => 'View hospital distribution assignments',
            'feature5' => 'Submit and track evaluation forms',
            'access_portal' => 'Access Portal',
            'profile_management' => 'Profile Management',
            'medical_records' => 'Medical Records',
            'appointments' => 'Appointments',
            'certifications' => 'Certifications',
            'latest_news' => 'Latest News & Updates',
            'news_subtitle' => 'Stay informed with the latest news and announcements from the Doctors Syndicate',
            'announcements' => 'Announcements',
            'events' => 'Events',
            'news_title1' => 'Professional Conduct Training Session Completed Successfully',
            'news_desc1' =>
                'The syndicate has concluded the latest professional conduct training course with excellent participation...',
            'news_title2' => 'New Electronic System Launched for Clinic Management',
            'news_desc2' =>
                'The syndicate announces the adoption of the new electronic system for managing clinic operations...',
            'news_title3' => 'International Medical Conference Announced',
            'news_desc3' =>
                'The Doctors Syndicate invites all members to participate in the upcoming international medical conference...',
            'read_more' => 'Read More',
            'view_all_news' => 'View All News',
            'laws_title' => 'Important Laws & Regulations',
            'laws_subtitle' => 'Key legislation that governs the medical profession',
            'syndicate_law' => 'Doctors Syndicate Law',
            'syndicate_law_desc' => 'The foundational law governing the syndicate\'s operations',
            'protection_law' => 'Doctor Protection Law',
            'protection_law_desc' => 'Legislation protecting medical practitioners\' rights',
            'support_law' => 'Doctor Support Law',
            'support_law_desc' => 'Support programs and benefits for physicians',
            'health_law' => 'Public Health Law',
            'health_law_desc' => 'General public health regulations and guidelines',
            'working_hours' => 'Working Hours',
            'sunday' => 'Sunday',
            'monday' => 'Monday',
            'tuesday' => 'Tuesday',
            'wednesday' => 'Wednesday',
            'thursday' => 'Thursday',
            'friday' => 'Friday',
            'saturday' => 'Saturday',
            'closed' => 'Closed',
            'complaints_suggestions' => 'Complaints & Suggestions',
            'complaints_desc' =>
                'If you have any suggestions or complaints, please don\'t hesitate to contact the syndicate administration. We value your feedback and are committed to improving our services.',
            'your_name' => 'Your Name',
            'your_email' => 'Your Email',
            'your_message' => 'Your Message',
            'send_message' => 'Send Message',
            'contact_us' => 'Contact Us',
            'contact_subtitle' => 'Get in touch with us for any inquiries or support',
            'address' => 'Address',
            'address_line1' => 'Medical District',
            'address_line2' => 'Healthcare Building',
            'address_line3' => 'Main Street, City',
            'phone' => 'Phone',
            'email' => 'Email',
            'follow_us' => 'Follow Us',
            'partners' => 'Our Partners',
            'partners_subtitle' => 'Sustainable institutional cooperation',
            'quick_links' => 'Quick Links',
            'contact_info' => 'Contact Info',
            'mobile_app' => 'Mobile App',
            'app_desc' => 'Download our mobile app for easier access to syndicate services.',
            'footer_desc' =>
                'The Doctors Syndicate was established to serve medical professionals, advocating for their rights and promoting excellence in healthcare delivery.',
            'copyright' => 'All Rights Reserved.',
            'privacy_policy' => 'Privacy Policy',
            'terms' => 'Terms & Conditions',
            'lang_switch' => 'العربية',
            'lang_code' => 'ar',
        ],
        'ar' => [
            'site_name' => 'نقابة الأطباء',
            'site_desc' => 'دعم التميز الطبي',
            'meta_desc' => 'نقابة الأطباء - دعم المهنيين الطبيين',
            'home' => 'الرئيسية',
            'about' => 'من نحن',
            'services' => 'خدماتنا',
            'news' => 'الأخبار',
            'contact' => 'اتصل بنا',
            'member_portal' => 'بوابة الأعضاء',
            'working_hours_short' => 'الأحد - الخميس: 8:00 ص - 4:00 م',
            'established' => 'تأسست عام 1950',
            'hero_title' => 'تمكين',
            'hero_title_highlight' => 'الأطباء',
            'hero_title_end' => 'بناء التميز في الرعاية الصحية',
            'hero_desc' =>
                'نقابة الأطباء مكرسة للنهوض بمهنة الطب، وحماية حقوق الأطباء، وتعزيز التميز في تقديم الرعاية الصحية.',
            'doctors_portal' => 'بوابة الطبيب',
            'our_services' => 'خدماتنا',
            'registered_doctors' => 'طبيب مسجل',
            'partner_hospitals' => 'مستشفى شريك',
            'specialties' => 'تخصص',
            'years_service' => 'سنوات الخدمة',
            'doctor_info_system' => 'نظام معلومات الطبيب',
            'doctor_info_desc' => 'الوصول إلى ملفك الشخصي وإدارة معلوماتك',
            'hospital_distribution' => 'توزيع المستشفيات',
            'hospital_dist_desc' => 'عرض والتقديم على التوزيعات في المستشفيات',
            'monthly_evaluations' => 'التقييمات الشهرية',
            'evaluations_desc' => 'تقديم وتتبع تقييمات أدائك',
            'support_inquiries' => 'الدعم والاستفسارات',
            'support_desc' => 'احصل على المساعدة في أسئلتك واستفساراتك',
            'about_title' => 'عن نقابة الأطباء',
            'years_excellence' => 'سنوات من التميز',
            'about_lead' => 'منظمة مهنية مكرسة للتميز الطبي',
            'about_p1' =>
                'تأسست نقابة الأطباء لتكون صوت المهنيين الطبيين، والدفاع عن حقوقهم وتعزيز أعلى معايير تقديم الرعاية الصحية.',
            'about_p2' =>
                'نقدم دعماً شاملاً لأعضائنا من خلال خدمات متنوعة تشمل إدارة العضوية، والتوزيع على المستشفيات، والتعليم المستمر، والمساعدة القانونية.',
            'professional_protection' => 'الحماية المهنية',
            'protection_desc' => 'الدعم القانوني والدفاع عن الأطباء',
            'continuing_education' => 'التعليم المستمر',
            'education_desc' => 'برامج التطوير المهني وورش العمل',
            'member_welfare' => 'رعاية الأعضاء',
            'welfare_desc' => 'برامج الدعم والمزايا للأعضاء',
            'learn_more' => 'اقرأ المزيد',
            'services_subtitle' => 'دعم شامل للمهنيين الطبيين في كل مرحلة من مراحل حياتهم المهنية',
            'membership_services' => 'خدمات العضوية',
            'membership_desc' => 'التسجيل والتجديد وإدارة عضويتك في النقابة. الوصول إلى مزايا وموارد الأعضاء الحصرية.',
            'hospital_dist_full' => 'خدمات التوزيع والتعيين المبسطة للأطباء عبر المستشفيات والمرافق الصحية.',
            'evaluations_full' => 'تقييمات الأداء لضمان النمو المهني والحفاظ على معايير التميز.',
            'education_full' => 'برامج التطوير المهني وورش العمل ودورات الشهادات لتطوير مسيرتك المهنية.',
            'legal_support' => 'الدعم القانوني',
            'legal_desc' => 'المساعدة القانونية المتخصصة والدفاع في قضايا العمل والعقود والشؤون المهنية.',
            'career_opportunities' => 'فرص العمل',
            'career_desc' => 'تصفح قوائم الوظائف وفرص العمل المقدمة من المؤسسات الصحية.',
            'doctor_system_title' => 'نظام إدارة معلومات الطبيب',
            'doctor_system_desc' => 'منصة شاملة لإدارة وتنظيم شؤون الأطباء، توفر خدمات إلكترونية متنوعة بسلاسة.',
            'feature1' => 'إدارة ملفك الشخصي وبياناتك',
            'feature2' => 'تتبع حالة عضويتك والتجديدات',
            'feature3' => 'الوصول إلى سجلات التدريب والشهادات',
            'feature4' => 'عرض تعيينات توزيع المستشفيات',
            'feature5' => 'تقديم وتتبع نماذج التقييم',
            'access_portal' => 'الدخول للبوابة',
            'profile_management' => 'إدارة الملف الشخصي',
            'medical_records' => 'السجلات الطبية',
            'appointments' => 'المواعيد',
            'certifications' => 'الشهادات',
            'latest_news' => 'آخر الأخبار والتحديثات',
            'news_subtitle' => 'ابق على اطلاع بآخر الأخبار والإعلانات من نقابة الأطباء',
            'announcements' => 'إعلانات',
            'events' => 'فعاليات',
            'news_title1' => 'اختتام دورة السلوك المهني بنجاح',
            'news_desc1' => 'اختتمت النقابة دورة السلوك المهني الأخيرة بمشاركة ممتازة...',
            'news_title2' => 'إطلاق النظام الإلكتروني الجديد لإدارة العيادات',
            'news_desc2' => 'تعلن النقابة عن اعتماد النظام الإلكتروني الجديد لإدارة عمليات العيادات...',
            'news_title3' => 'الإعلان عن المؤتمر الطبي الدولي',
            'news_desc3' => 'تدعو نقابة الأطباء جميع الأعضاء للمشاركة في المؤتمر الطبي الدولي القادم...',
            'read_more' => 'اقرأ المزيد',
            'view_all_news' => 'عرض جميع الأخبار',
            'laws_title' => 'القوانين واللوائح المهمة',
            'laws_subtitle' => 'التشريعات الرئيسية التي تحكم مهنة الطب',
            'syndicate_law' => 'قانون نقابة الأطباء',
            'syndicate_law_desc' => 'القانون التأسيسي الذي يحكم عمليات النقابة',
            'protection_law' => 'قانون حماية الطبيب',
            'protection_law_desc' => 'التشريعات التي تحمي حقوق الممارسين الطبيين',
            'support_law' => 'قانون دعم الطبيب',
            'support_law_desc' => 'برامج الدعم والمزايا للأطباء',
            'health_law' => 'قانون الصحة العامة',
            'health_law_desc' => 'لوائح وإرشادات الصحة العامة',
            'working_hours' => 'ساعات العمل',
            'sunday' => 'الأحد',
            'monday' => 'الاثنين',
            'tuesday' => 'الثلاثاء',
            'wednesday' => 'الأربعاء',
            'thursday' => 'الخميس',
            'friday' => 'الجمعة',
            'saturday' => 'السبت',
            'closed' => 'مغلق',
            'complaints_suggestions' => 'الشكاوى والمقترحات',
            'complaints_desc' =>
                'إذا كان لديك أي مقترحات أو شكاوى، لا تتردد في التواصل مع إدارة النقابة. نحن نقدر ملاحظاتك ونلتزم بتحسين خدماتنا.',
            'your_name' => 'اسمك',
            'your_email' => 'بريدك الإلكتروني',
            'your_message' => 'رسالتك',
            'send_message' => 'إرسال الرسالة',
            'contact_us' => 'اتصل بنا',
            'contact_subtitle' => 'تواصل معنا لأي استفسارات أو دعم',
            'address' => 'العنوان',
            'address_line1' => 'المنطقة الطبية',
            'address_line2' => 'مبنى الرعاية الصحية',
            'address_line3' => 'الشارع الرئيسي، المدينة',
            'phone' => 'الهاتف',
            'email' => 'البريد الإلكتروني',
            'follow_us' => 'تابعنا',
            'partners' => 'شركاؤنا',
            'partners_subtitle' => 'تعاون مؤسسي مستدام',
            'quick_links' => 'روابط سريعة',
            'contact_info' => 'معلومات الاتصال',
            'mobile_app' => 'تطبيق الجوال',
            'app_desc' => 'حمل تطبيقنا للجوال للوصول السهل لخدمات النقابة.',
            'footer_desc' =>
                'تأسست نقابة الأطباء لخدمة المهنيين الطبيين، والدفاع عن حقوقهم وتعزيز التميز في تقديم الرعاية الصحية.',
            'copyright' => 'جميع الحقوق محفوظة.',
            'privacy_policy' => 'سياسة الخصوصية',
            'terms' => 'الشروط والأحكام',
            'lang_switch' => 'English',
            'lang_code' => 'en',
        ],
    ];

    $__ = $t[$lang];
@endphp
<!DOCTYPE html>
<html lang="{{ $lang }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $__['meta_desc'] }}">
    <title>{{ config('app.name', $__['site_name']) }}</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Open+Sans:wght@400;500;600;700&family=Cairo:wght@300;400;500;600;700;800&family=Tajawal:wght@400;500;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    @if ($isRtl)
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1e5f74;
            --primary-dark: #133b4a;
            --secondary-color: #28a745;
            --accent-color: #ffc107;
            --dark-color: #0a1628;
            --light-bg: #f4f7fa;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --gradient-primary: linear-gradient(135deg, #1e5f74 0%, #133b4a 100%);
            --gradient-secondary: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            --shadow-sm: 0 2px 15px rgba(0, 0, 0, 0.08);
            --shadow-md: 0 5px 30px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 15px 50px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s ease;
            /* Light mode specific */
            --body-bg: #ffffff;
            --card-bg: #ffffff;
            --navbar-bg: #ffffff;
            --section-bg: #f4f7fa;
            --border-color: #eee;
            --input-bg: #ffffff;
            --input-border: #dee2e6;
        }

        /* Dark Mode Variables */
        [data-theme="dark"] {
            --primary-color: #3498db;
            --primary-dark: #2980b9;
            --dark-color: #0d1b2a;
            --light-bg: #1b2838;
            --text-dark: #e8e8e8;
            --text-light: #a0aec0;
            --body-bg: #0d1b2a;
            --card-bg: #1b2838;
            --navbar-bg: #152238;
            --section-bg: #152238;
            --border-color: #2d3f54;
            --input-bg: #1b2838;
            --input-border: #2d3f54;
            --shadow-sm: 0 2px 15px rgba(0, 0, 0, 0.3);
            --shadow-md: 0 5px 30px rgba(0, 0, 0, 0.4);
            --shadow-lg: 0 15px 50px rgba(0, 0, 0, 0.5);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: {{ $isRtl ? "'Cairo', 'Tajawal', sans-serif" : "'Open Sans', sans-serif" }};
            color: var(--text-dark);
            line-height: 1.7;
            overflow-x: hidden;
            background-color: var(--body-bg);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: {{ $isRtl ? "'Cairo', sans-serif" : "'Poppins', sans-serif" }};
            font-weight: 600;
        }

        a {
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            color: #fff;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            border: none;
            transition: var(--transition);
            display: inline-block;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            color: #fff;
        }

        .btn-secondary-custom {
            background: transparent;
            color: #fff;
            padding: 11px 28px;
            border-radius: 50px;
            font-weight: 600;
            border: 2px solid #fff;
            transition: var(--transition);
            display: inline-block;
        }

        .btn-secondary-custom:hover {
            background: #fff;
            color: var(--primary-color);
        }

        .section-padding {
            padding: 100px 0;
        }

        .section-title {
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
            position: relative;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-secondary);
            border-radius: 2px;
        }

        [dir="rtl"] .section-title h2::after {
            right: 50%;
            left: auto;
            transform: translateX(50%);
        }

        .section-title.text-start h2::after {
            left: 0;
            transform: none;
        }

        [dir="rtl"] .section-title.text-start h2::after {
            right: 0;
            left: auto;
        }

        .section-title p {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 20px auto 0;
        }

        /* Language Switcher */
        .lang-switch {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: var(--transition);
        }

        .lang-switch:hover {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        /* Theme Toggle */
        .theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: var(--transition);
        }

        .theme-toggle:hover {
            background: var(--primary-color);
            border-color: var(--primary-color);
            transform: rotate(180deg);
        }

        .theme-toggle .fa-sun {
            display: none;
        }

        .theme-toggle .fa-moon {
            display: inline-block;
        }

        [data-theme="dark"] .theme-toggle .fa-sun {
            display: inline-block;
        }

        [data-theme="dark"] .theme-toggle .fa-moon {
            display: none;
        }

        /* Navbar Theme Toggle */
        .navbar .theme-toggle-nav {
            background: var(--light-bg);
            color: var(--text-dark);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            margin-inline-start: 10px;
        }

        .navbar .theme-toggle-nav:hover {
            background: var(--primary-color);
            color: #fff;
        }

        .navbar .theme-toggle-nav .fa-sun {
            display: none;
        }

        .navbar .theme-toggle-nav .fa-moon {
            display: inline-block;
        }

        [data-theme="dark"] .navbar .theme-toggle-nav .fa-sun {
            display: inline-block;
        }

        [data-theme="dark"] .navbar .theme-toggle-nav .fa-moon {
            display: none;
        }

        /* Top Bar */
        .top-bar {
            background: var(--dark-color);
            padding: 10px 0;
            font-size: 0.9rem;
        }

        .top-bar a {
            color: rgba(255, 255, 255, 0.8);
        }

        .top-bar a:hover {
            color: var(--accent-color);
        }

        .top-bar .social-links a {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            margin-inline-start: 8px;
            font-size: 0.85rem;
        }

        .top-bar .social-links a:hover {
            background: var(--primary-color);
            color: #fff;
        }

        /* Navbar */
        .navbar {
            background: var(--navbar-bg);
            box-shadow: var(--shadow-sm);
            padding: 0;
            transition: var(--transition);
        }

        .navbar.scrolled {
            box-shadow: var(--shadow-md);
        }

        [data-theme="dark"] .navbar-toggler-icon {
            filter: invert(1);
        }

        .navbar-brand {
            padding: 15px 0;
        }

        .navbar-brand img {
            height: 60px;
        }

        .navbar-brand .brand-text {
            font-family: {{ $isRtl ? "'Cairo', sans-serif" : "'Poppins', sans-serif" }};
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--primary-color);
            margin-inline-start: 10px;
        }

        .navbar-brand .brand-text small {
            display: block;
            font-size: 0.75rem;
            font-weight: 400;
            color: var(--text-light);
        }

        .navbar .nav-link {
            font-weight: 600;
            color: var(--dark-color) !important;
            padding: 25px 18px !important;
            position: relative;
            font-size: 0.95rem;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 20px;
            left: 18px;
            right: 18px;
            height: 3px;
            background: var(--primary-color);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .navbar .nav-link:hover::after,
        .navbar .nav-link.active::after {
            transform: scaleX(1);
        }

        .navbar .btn-portal {
            background: var(--gradient-primary);
            color: #fff !important;
            padding: 12px 25px !important;
            border-radius: 50px;
            margin-inline-start: 15px;
        }

        .navbar .btn-portal::after {
            display: none;
        }

        .navbar .btn-portal:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-sm);
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-primary);
            min-height: 85vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.03)" stroke-width="1"/></svg>') repeat;
            background-size: 100px;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: -50%;
            inset-inline-end: -10%;
            width: 60%;
            height: 200%;
            background: rgba(255, 255, 255, 0.03);
            transform: rotate(15deg);
        }

        [dir="rtl"] .hero-section::after {
            transform: rotate(-15deg);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content .badge-text {
            display: inline-block;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 20px;
            border-radius: 50px;
            color: #fff;
            font-size: 0.9rem;
            margin-bottom: 25px;
            backdrop-filter: blur(10px);
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 25px;
            line-height: 1.2;
        }

        .hero-content h1 span {
            color: var(--accent-color);
        }

        .hero-content p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 35px;
            max-width: 550px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
            z-index: 2;
        }

        .hero-image img {
            max-width: 100%;
            border-radius: 20px;
            box-shadow: var(--shadow-lg);
        }

        .hero-stats {
            position: absolute;
            bottom: 30px;
            left: 0;
            right: 0;
            z-index: 3;
        }

        .hero-stat-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hero-stat-card h3 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--accent-color);
            margin-bottom: 5px;
        }

        .hero-stat-card p {
            color: #fff;
            margin: 0;
            font-size: 0.95rem;
        }

        /* Quick Links Section */
        .quick-links {
            background: var(--body-bg);
            padding: 0;
            margin-top: -60px;
            position: relative;
            z-index: 10;
        }

        .quick-link-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 35px 25px;
            text-align: center;
            box-shadow: var(--shadow-md);
            transition: var(--transition);
            height: 100%;
            border: 1px solid var(--border-color);
        }

        .quick-link-card:hover {
            transform: translateY(-10px);
            border-color: var(--primary-color);
            box-shadow: var(--shadow-lg);
        }

        .quick-link-card .icon-box {
            width: 80px;
            height: 80px;
            background: var(--light-bg);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            transition: var(--transition);
        }

        .quick-link-card:hover .icon-box {
            background: var(--gradient-primary);
        }

        .quick-link-card .icon-box i {
            font-size: 2rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .quick-link-card:hover .icon-box i {
            color: #fff;
        }

        .quick-link-card h5 {
            color: var(--dark-color);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .quick-link-card p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin: 0;
        }

        /* About Section */
        .about-section {
            background: var(--section-bg);
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            border-radius: 20px;
            box-shadow: var(--shadow-md);
        }

        .about-image .experience-badge {
            position: absolute;
            bottom: 30px;
            inset-inline-end: -30px;
            background: var(--gradient-secondary);
            color: #fff;
            padding: 25px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: var(--shadow-md);
        }

        .about-image .experience-badge h3 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .about-image .experience-badge p {
            margin: 0;
            font-size: 0.95rem;
        }

        .about-content h2 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 20px;
        }

        .about-content .lead {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .about-features {
            margin-top: 30px;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .about-feature .icon {
            width: 50px;
            height: 50px;
            background: var(--light-bg);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-inline-end: 15px;
            flex-shrink: 0;
        }

        .about-feature .icon i {
            color: var(--primary-color);
            font-size: 1.3rem;
        }

        .about-feature h6 {
            margin-bottom: 5px;
            color: var(--dark-color);
        }

        .about-feature p {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* Services Section */
        .services-section {
            background: var(--body-bg);
        }

        .service-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            transform: scaleX(0);
            transition: var(--transition);
        }

        .service-card:hover::before {
            transform: scaleX(1);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .service-card .service-icon {
            width: 90px;
            height: 90px;
            background: var(--light-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            transition: var(--transition);
        }

        .service-card:hover .service-icon {
            background: var(--gradient-primary);
        }

        .service-card .service-icon i {
            font-size: 2.2rem;
            color: var(--primary-color);
            transition: var(--transition);
        }

        .service-card:hover .service-icon i {
            color: #fff;
        }

        .service-card h4 {
            color: var(--dark-color);
            margin-bottom: 15px;
            font-size: 1.25rem;
        }

        .service-card p {
            color: var(--text-light);
            font-size: 0.95rem;
            margin-bottom: 20px;
        }

        .service-card .learn-more {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .service-card .learn-more i {
            margin-inline-start: 5px;
            transition: var(--transition);
        }

        .service-card:hover .learn-more i {
            transform: translateX(5px);
        }

        [dir="rtl"] .service-card:hover .learn-more i {
            transform: translateX(-5px);
        }

        /* News Section */
        .news-section {
            background: var(--section-bg);
        }

        .news-card {
            background: var(--card-bg);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
        }

        .news-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .news-card .news-image {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .news-card .news-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition);
        }

        .news-card:hover .news-image img {
            transform: scale(1.1);
        }

        .news-card .news-date {
            position: absolute;
            top: 15px;
            inset-inline-start: 15px;
            background: var(--primary-color);
            color: #fff;
            padding: 10px 15px;
            border-radius: 10px;
            text-align: center;
            font-size: 0.85rem;
        }

        .news-card .news-date strong {
            display: block;
            font-size: 1.5rem;
            line-height: 1;
        }

        .news-card .news-content {
            padding: 25px;
        }

        .news-card .news-category {
            display: inline-block;
            background: var(--section-bg);
            color: var(--primary-color);
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .news-card h5 {
            color: var(--dark-color);
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .news-card h5 a {
            color: inherit;
        }

        .news-card h5 a:hover {
            color: var(--primary-color);
        }

        .news-card p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .news-card .read-more {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Doctor Info System */
        .doctor-system {
            background: var(--gradient-primary);
            position: relative;
            overflow: hidden;
        }

        .doctor-system::before {
            content: '';
            position: absolute;
            top: 0;
            inset-inline-end: 0;
            width: 40%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><path fill="rgba(255,255,255,0.05)" d="M100,0 L200,100 L100,200 L0,100 Z"/></svg>') no-repeat center;
            background-size: cover;
        }

        .doctor-system .content {
            position: relative;
            z-index: 2;
        }

        .doctor-system h2 {
            color: #fff;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .doctor-system p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .doctor-system .features-list {
            list-style: none;
            padding: 0;
            margin-bottom: 30px;
        }

        .doctor-system .features-list li {
            color: #fff;
            padding: 10px 0;
            display: flex;
            align-items: center;
        }

        .doctor-system .features-list li i {
            color: var(--accent-color);
            margin-inline-end: 15px;
            font-size: 1.2rem;
        }

        .system-cards {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .system-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
        }

        .system-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .system-card i {
            font-size: 2.5rem;
            color: var(--accent-color);
            margin-bottom: 15px;
        }

        .system-card h5 {
            color: #fff;
            font-size: 1rem;
            margin: 0;
        }

        /* Laws Section */
        .laws-section {
            background: var(--body-bg);
        }

        .law-card {
            background: var(--section-bg);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            transition: var(--transition);
            height: 100%;
            border: 2px solid var(--border-color);
        }

        .law-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .law-card i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .law-card h5 {
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .law-card p {
            color: var(--text-light);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .law-card .btn-link {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Working Hours */
        .working-hours {
            background: var(--section-bg);
        }

        .hours-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-md);
            height: 100%;
        }

        .hours-card h4 {
            color: var(--dark-color);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
        }

        .hours-card h4 i {
            color: var(--primary-color);
            margin-inline-end: 15px;
            font-size: 1.5rem;
        }

        .day-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .day-row:last-child {
            border-bottom: none;
        }

        .day-row .day {
            font-weight: 600;
            color: var(--dark-color);
        }

        .day-row .hours {
            color: var(--primary-color);
            font-weight: 600;
        }

        .day-row.closed .hours {
            color: #dc3545;
        }

        /* Contact Section */
        .contact-section {
            background: var(--dark-color);
            position: relative;
        }

        .contact-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.03)"/></svg>') repeat;
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 35px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: var(--transition);
            height: 100%;
        }

        .contact-card:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-5px);
        }

        .contact-card .icon {
            width: 70px;
            height: 70px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .contact-card .icon i {
            font-size: 1.8rem;
            color: #fff;
        }

        .contact-card h5 {
            color: #fff;
            margin-bottom: 15px;
        }

        .contact-card p {
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
            font-size: 0.95rem;
        }

        .contact-card a {
            color: var(--accent-color);
        }

        /* Partners Section */
        .partners-section {
            background: var(--body-bg);
            padding: 60px 0;
        }

        [data-theme="dark"] .partner-logo {
            filter: grayscale(100%) invert(1);
            opacity: 0.5;
        }

        [data-theme="dark"] .partner-logo:hover {
            filter: grayscale(0) invert(0);
            opacity: 1;
        }

        .partner-logo {
            padding: 20px 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            filter: grayscale(100%);
            opacity: 0.6;
            transition: var(--transition);
        }

        .partner-logo:hover {
            filter: grayscale(0);
            opacity: 1;
        }

        .partner-logo img {
            max-height: 60px;
            max-width: 150px;
        }

        /* Footer */
        footer {
            background: var(--dark-color);
            padding-top: 80px;
        }

        .footer-widget h5 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }

        .footer-widget h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            inset-inline-start: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
        }

        .footer-widget p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
        }

        .footer-widget .footer-logo {
            margin-bottom: 20px;
        }

        .footer-widget .footer-logo img {
            height: 60px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .footer-links a i {
            margin-inline-end: 10px;
            color: var(--primary-color);
        }

        .footer-links a:hover {
            color: var(--accent-color);
            padding-inline-start: 5px;
        }

        .footer-contact li {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-contact li i {
            color: var(--primary-color);
            margin-inline-end: 15px;
            margin-top: 5px;
            font-size: 1.1rem;
        }

        .social-links-footer {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .social-links-footer a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: var(--transition);
        }

        .social-links-footer a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 20px 0;
            margin-top: 60px;
        }

        .footer-bottom p {
            color: rgba(255, 255, 255, 0.6);
            margin: 0;
            font-size: 0.9rem;
        }

        .footer-bottom a {
            color: var(--accent-color);
        }

        /* App Download */
        .app-badges {
            display: flex;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .app-badges a img {
            height: 45px;
            transition: var(--transition);
        }

        .app-badges a:hover img {
            transform: scale(1.05);
        }

        /* Scroll to Top */
        .scroll-top {
            position: fixed;
            bottom: 30px;
            inset-inline-end: 30px;
            width: 50px;
            height: 50px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
            z-index: 999;
            box-shadow: var(--shadow-md);
        }

        .scroll-top.active {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-5px);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .section-title h2 {
                font-size: 2rem;
            }

            .about-image .experience-badge {
                inset-inline-end: 0;
            }

            .system-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767px) {
            .hero-section {
                min-height: auto;
                padding-top: 60px;
                padding-bottom: 30px;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
                margin-bottom: 25px;
            }

            .hero-buttons {
                flex-direction: column;
                margin-bottom: 40px;
            }

            .hero-buttons .btn-primary-custom,
            .hero-buttons .btn-secondary-custom {
                width: 100%;
                text-align: center;
            }

            .hero-stats {
                position: relative;
                bottom: auto;
                margin-top: 30px;
            }

            .hero-stat-card {
                margin-bottom: 15px;
                padding: 20px 15px;
            }

            .hero-stat-card h3 {
                font-size: 2rem;
            }

            .hero-stat-card p {
                font-size: 0.85rem;
            }

            .section-padding {
                padding: 60px 0;
            }

            .quick-links {
                margin-top: -30px;
            }
        }

        /* Dark Mode Form Controls */
        [data-theme="dark"] .form-control {
            background-color: var(--input-bg);
            border-color: var(--input-border);
            color: var(--text-dark);
        }

        [data-theme="dark"] .form-control:focus {
            background-color: var(--input-bg);
            border-color: var(--primary-color);
            color: var(--text-dark);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-light);
        }

        /* Dark Mode Section Titles */
        [data-theme="dark"] .section-title h2 {
            color: var(--text-dark);
        }

        /* Dark Mode Quick Link Cards */
        [data-theme="dark"] .quick-link-card h5,
        [data-theme="dark"] .service-card h4,
        [data-theme="dark"] .news-card h5,
        [data-theme="dark"] .law-card h5,
        [data-theme="dark"] .hours-card h4 {
            color: var(--text-dark);
        }

        [data-theme="dark"] .quick-link-card p,
        [data-theme="dark"] .service-card p,
        [data-theme="dark"] .news-card p,
        [data-theme="dark"] .law-card p {
            color: var(--text-light);
        }

        /* Dark Mode About Section */
        [data-theme="dark"] .about-content h2,
        [data-theme="dark"] .about-feature h6,
        [data-theme="dark"] .day-row .day {
            color: var(--text-dark);
        }

        /* Dark Mode Icon Boxes */
        [data-theme="dark"] .quick-link-card .icon-box,
        [data-theme="dark"] .service-card .service-icon,
        [data-theme="dark"] .about-feature .icon {
            background: var(--section-bg);
        }

        /* Smooth transition for theme change */
        .quick-link-card,
        .service-card,
        .news-card,
        .law-card,
        .hours-card,
        .navbar,
        .section-title h2,
        .form-control {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease;
        }
    </style>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-4">
                        <a href="tel:+1234567890"><i class="fas fa-phone-alt {{ $isRtl ? 'ms-2' : 'me-2' }}"></i> +1 234
                            567 890</a>
                        <a href="mailto:info@doctorssyndicate.org"><i
                                class="fas fa-envelope {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                            info@doctorssyndicate.org</a>
                        <span class="text-white-50"><i class="fas fa-clock {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                            {{ $__['working_hours_short'] }}</span>
                    </div>
                </div>
                <div class="col-lg-5 {{ $isRtl ? 'text-start' : 'text-end' }}">
                    <div
                        class="d-flex align-items-center {{ $isRtl ? 'justify-content-start' : 'justify-content-end' }} gap-3">
                        <button class="theme-toggle" id="themeToggle" title="Toggle Dark Mode">
                            <i class="fas fa-moon"></i>
                            <i class="fas fa-sun"></i>
                        </button>
                        <a href="?lang={{ $__['lang_code'] }}" class="lang-switch">
                            <i class="fas fa-globe {{ $isRtl ? 'ms-1' : 'me-1' }}"></i> {{ $__['lang_switch'] }}
                        </a>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <i class="fas fa-staff-snake fa-2x text-primary"></i>
                <div class="brand-text">
                    {{ $__['site_name'] }}
                    <small>{{ $__['site_desc'] }}</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav {{ $isRtl ? 'me-auto' : 'ms-auto' }} align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">{{ $__['home'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">{{ $__['about'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">{{ $__['services'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#news">{{ $__['news'] }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">{{ $__['contact'] }}</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a href="?lang={{ $__['lang_code'] }}" class="nav-link">
                            <i class="fas fa-globe {{ $isRtl ? 'ms-1' : 'me-1' }}"></i> {{ $__['lang_switch'] }}
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <button class="nav-link theme-toggle-nav" id="themeToggleMobile" title="Toggle Dark Mode">
                            <i class="fas fa-moon"></i>
                            <i class="fas fa-sun"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <button class="theme-toggle-nav d-none d-lg-flex" id="themeToggleNav" title="Toggle Dark Mode">
                            <i class="fas fa-moon"></i>
                            <i class="fas fa-sun"></i>
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-portal" href="/adminPanel">
                            <i class="fas fa-user-md {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>{{ $__['member_portal'] }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="{{ $isRtl ? 'fade-left' : 'fade-right' }}">
                    <div class="hero-content">
                        <span class="badge-text"><i
                                class="fas fa-star {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>{{ $__['established'] }}</span>
                        <h1>{{ $__['hero_title'] }} <span>{{ $__['hero_title_highlight'] }}</span>
                            {{ $__['hero_title_end'] }}</h1>
                        <p>{{ $__['hero_desc'] }}</p>
                        <div class="hero-buttons">
                            <a href="/adminPanel" class="btn-primary-custom">
                                <i
                                    class="fas fa-sign-in-alt {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>{{ $__['doctors_portal'] }}
                            </a>
                            <a href="#services" class="btn-secondary-custom">
                                <i
                                    class="fas fa-info-circle {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>{{ $__['our_services'] }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block" data-aos="{{ $isRtl ? 'fade-right' : 'fade-left' }}">
                    <div class="hero-image">
                        <img src="{{ asset('website/images/background.jpg') }}" alt="{{ $__['site_name'] }}"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-stats">
            <div class="container">
                <div class="row g-3">
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                        <div class="hero-stat-card">
                            <h3>5,000+</h3>
                            <p>{{ $__['registered_doctors'] }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="hero-stat-card">
                            <h3>150+</h3>
                            <p>{{ $__['partner_hospitals'] }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                        <div class="hero-stat-card">
                            <h3>25+</h3>
                            <p>{{ $__['specialties'] }}</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="400">
                        <div class="hero-stat-card">
                            <h3>70+</h3>
                            <p>{{ $__['years_service'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Links -->
    <section class="quick-links">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="/adminPanel" class="d-block">
                        <div class="quick-link-card">
                            <div class="icon-box">
                                <i class="fas fa-user-md"></i>
                            </div>
                            <h5>{{ $__['doctor_info_system'] }}</h5>
                            <p>{{ $__['doctor_info_desc'] }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="/adminPanel" class="d-block">
                        <div class="quick-link-card">
                            <div class="icon-box">
                                <i class="fas fa-hospital"></i>
                            </div>
                            <h5>{{ $__['hospital_distribution'] }}</h5>
                            <p>{{ $__['hospital_dist_desc'] }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <a href="/adminPanel" class="d-block">
                        <div class="quick-link-card">
                            <div class="icon-box">
                                <i class="fas fa-clipboard-check"></i>
                            </div>
                            <h5>{{ $__['monthly_evaluations'] }}</h5>
                            <p>{{ $__['evaluations_desc'] }}</p>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <a href="#contact" class="d-block">
                        <div class="quick-link-card">
                            <div class="icon-box">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h5>{{ $__['support_inquiries'] }}</h5>
                            <p>{{ $__['support_desc'] }}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section-padding" id="about">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0" data-aos="{{ $isRtl ? 'fade-left' : 'fade-right' }}">
                    <div class="about-image">
                        <img src="{{ asset('website/images/background.jpg') }}" alt="{{ $__['about'] }}"
                            class="img-fluid">
                        <div class="experience-badge">
                            <h3>70+</h3>
                            <p>{{ $__['years_excellence'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="{{ $isRtl ? 'fade-right' : 'fade-left' }}">
                    <div class="about-content {{ $isRtl ? 'pe-lg-4' : 'ps-lg-4' }}">
                        <div class="section-title text-start">
                            <h2>{{ $__['about_title'] }}</h2>
                        </div>
                        <p class="lead">{{ $__['about_lead'] }}</p>
                        <p>{{ $__['about_p1'] }}</p>
                        <p>{{ $__['about_p2'] }}</p>

                        <div class="about-features">
                            <div class="about-feature">
                                <div class="icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div>
                                    <h6>{{ $__['professional_protection'] }}</h6>
                                    <p>{{ $__['protection_desc'] }}</p>
                                </div>
                            </div>
                            <div class="about-feature">
                                <div class="icon">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                <div>
                                    <h6>{{ $__['continuing_education'] }}</h6>
                                    <p>{{ $__['education_desc'] }}</p>
                                </div>
                            </div>
                            <div class="about-feature">
                                <div class="icon">
                                    <i class="fas fa-hands-helping"></i>
                                </div>
                                <div>
                                    <h6>{{ $__['member_welfare'] }}</h6>
                                    <p>{{ $__['welfare_desc'] }}</p>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="btn-primary-custom mt-4">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-2' : 'ms-2' }}"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section section-padding" id="services">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <h2>{{ $__['our_services'] }}</h2>
                <p>{{ $__['services_subtitle'] }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-id-card-alt"></i>
                        </div>
                        <h4>{{ $__['membership_services'] }}</h4>
                        <p>{{ $__['membership_desc'] }}</p>
                        <a href="#" class="learn-more">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-hospital-user"></i>
                        </div>
                        <h4>{{ $__['hospital_distribution'] }}</h4>
                        <p>{{ $__['hospital_dist_full'] }}</p>
                        <a href="#" class="learn-more">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4>{{ $__['monthly_evaluations'] }}</h4>
                        <p>{{ $__['evaluations_full'] }}</p>
                        <a href="#" class="learn-more">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h4>{{ $__['continuing_education'] }}</h4>
                        <p>{{ $__['education_full'] }}</p>
                        <a href="#" class="learn-more">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-balance-scale"></i>
                        </div>
                        <h4>{{ $__['legal_support'] }}</h4>
                        <p>{{ $__['legal_desc'] }}</p>
                        <a href="#" class="learn-more">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-briefcase-medical"></i>
                        </div>
                        <h4>{{ $__['career_opportunities'] }}</h4>
                        <p>{{ $__['career_desc'] }}</p>
                        <a href="#" class="learn-more">{{ $__['learn_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }}"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Doctor Information System -->
    <section class="doctor-system section-padding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="{{ $isRtl ? 'fade-left' : 'fade-right' }}">
                    <div class="content">
                        <h2>{{ $__['doctor_system_title'] }}</h2>
                        <p>{{ $__['doctor_system_desc'] }}</p>
                        <ul class="features-list">
                            <li><i class="fas fa-check-circle"></i> {{ $__['feature1'] }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ $__['feature2'] }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ $__['feature3'] }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ $__['feature4'] }}</li>
                            <li><i class="fas fa-check-circle"></i> {{ $__['feature5'] }}</li>
                        </ul>
                        <a href="/adminPanel" class="btn-primary-custom"
                            style="background: #fff; color: var(--primary-color);">
                            <i
                                class="fas fa-sign-in-alt {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>{{ $__['access_portal'] }}
                        </a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="{{ $isRtl ? 'fade-right' : 'fade-left' }}">
                    <div class="system-cards">
                        <div class="system-card">
                            <i class="fas fa-user-circle"></i>
                            <h5>{{ $__['profile_management'] }}</h5>
                        </div>
                        <div class="system-card">
                            <i class="fas fa-file-medical-alt"></i>
                            <h5>{{ $__['medical_records'] }}</h5>
                        </div>
                        <div class="system-card">
                            <i class="fas fa-calendar-check"></i>
                            <h5>{{ $__['appointments'] }}</h5>
                        </div>
                        <div class="system-card">
                            <i class="fas fa-certificate"></i>
                            <h5>{{ $__['certifications'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section section-padding" id="news">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <h2>{{ $__['latest_news'] }}</h2>
                <p>{{ $__['news_subtitle'] }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="{{ asset('website/images/background.jpg') }}" alt="News">
                            <div class="news-date">
                                <strong>15</strong>
                                {{ $isRtl ? 'يناير' : 'Jan' }}
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="news-category">{{ $__['announcements'] }}</span>
                            <h5><a href="#">{{ $__['news_title1'] }}</a></h5>
                            <p>{{ $__['news_desc1'] }}</p>
                            <a href="#" class="read-more">{{ $__['read_more'] }} <i
                                    class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-2' : 'ms-2' }}"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="{{ asset('website/images/background.jpg') }}" alt="News">
                            <div class="news-date">
                                <strong>12</strong>
                                {{ $isRtl ? 'يناير' : 'Jan' }}
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="news-category">{{ $__['news'] }}</span>
                            <h5><a href="#">{{ $__['news_title2'] }}</a></h5>
                            <p>{{ $__['news_desc2'] }}</p>
                            <a href="#" class="read-more">{{ $__['read_more'] }} <i
                                    class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-2' : 'ms-2' }}"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="news-card">
                        <div class="news-image">
                            <img src="{{ asset('website/images/background.jpg') }}" alt="News">
                            <div class="news-date">
                                <strong>08</strong>
                                {{ $isRtl ? 'يناير' : 'Jan' }}
                            </div>
                        </div>
                        <div class="news-content">
                            <span class="news-category">{{ $__['events'] }}</span>
                            <h5><a href="#">{{ $__['news_title3'] }}</a></h5>
                            <p>{{ $__['news_desc3'] }}</p>
                            <a href="#" class="read-more">{{ $__['read_more'] }} <i
                                    class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-2' : 'ms-2' }}"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5" data-aos="fade-up">
                <a href="#" class="btn-primary-custom">{{ $__['view_all_news'] }} <i
                        class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-2' : 'ms-2' }}"></i></a>
            </div>
        </div>
    </section>

    <!-- Laws Section -->
    <section class="laws-section section-padding">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <h2>{{ $__['laws_title'] }}</h2>
                <p>{{ $__['laws_subtitle'] }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="law-card">
                        <i class="fas fa-gavel"></i>
                        <h5>{{ $__['syndicate_law'] }}</h5>
                        <p>{{ $__['syndicate_law_desc'] }}</p>
                        <a href="#" class="btn-link">{{ $__['read_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-1' : 'ms-1' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="law-card">
                        <i class="fas fa-shield-alt"></i>
                        <h5>{{ $__['protection_law'] }}</h5>
                        <p>{{ $__['protection_law_desc'] }}</p>
                        <a href="#" class="btn-link">{{ $__['read_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-1' : 'ms-1' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="law-card">
                        <i class="fas fa-hand-holding-heart"></i>
                        <h5>{{ $__['support_law'] }}</h5>
                        <p>{{ $__['support_law_desc'] }}</p>
                        <a href="#" class="btn-link">{{ $__['read_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-1' : 'ms-1' }}"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="law-card">
                        <i class="fas fa-heartbeat"></i>
                        <h5>{{ $__['health_law'] }}</h5>
                        <p>{{ $__['health_law_desc'] }}</p>
                        <a href="#" class="btn-link">{{ $__['read_more'] }} <i
                                class="fas fa-arrow-{{ $isRtl ? 'left' : 'right' }} {{ $isRtl ? 'me-1' : 'ms-1' }}"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Working Hours & Contact -->
    <section class="working-hours section-padding">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6" data-aos="{{ $isRtl ? 'fade-left' : 'fade-right' }}">
                    <div class="hours-card">
                        <h4><i class="far fa-clock"></i>{{ $__['working_hours'] }}</h4>
                        <div class="day-row">
                            <span class="day">{{ $__['sunday'] }}</span>
                            <span class="hours">8:00 {{ $isRtl ? 'ص' : 'AM' }} - 4:00
                                {{ $isRtl ? 'م' : 'PM' }}</span>
                        </div>
                        <div class="day-row">
                            <span class="day">{{ $__['monday'] }}</span>
                            <span class="hours">8:00 {{ $isRtl ? 'ص' : 'AM' }} - 4:00
                                {{ $isRtl ? 'م' : 'PM' }}</span>
                        </div>
                        <div class="day-row">
                            <span class="day">{{ $__['tuesday'] }}</span>
                            <span class="hours">8:00 {{ $isRtl ? 'ص' : 'AM' }} - 4:00
                                {{ $isRtl ? 'م' : 'PM' }}</span>
                        </div>
                        <div class="day-row">
                            <span class="day">{{ $__['wednesday'] }}</span>
                            <span class="hours">8:00 {{ $isRtl ? 'ص' : 'AM' }} - 4:00
                                {{ $isRtl ? 'م' : 'PM' }}</span>
                        </div>
                        <div class="day-row">
                            <span class="day">{{ $__['thursday'] }}</span>
                            <span class="hours">8:00 {{ $isRtl ? 'ص' : 'AM' }} - 4:00
                                {{ $isRtl ? 'م' : 'PM' }}</span>
                        </div>
                        <div class="day-row closed">
                            <span class="day">{{ $__['friday'] }}</span>
                            <span class="hours">{{ $__['closed'] }}</span>
                        </div>
                        <div class="day-row closed">
                            <span class="day">{{ $__['saturday'] }}</span>
                            <span class="hours">{{ $__['closed'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="{{ $isRtl ? 'fade-right' : 'fade-left' }}">
                    <div class="hours-card">
                        <h4><i class="fas fa-comments"></i>{{ $__['complaints_suggestions'] }}</h4>
                        <p class="mb-4">{{ $__['complaints_desc'] }}</p>
                        <form>
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="{{ $__['your_name'] }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="{{ $__['your_email'] }}"
                                    required>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4" placeholder="{{ $__['your_message'] }}" required></textarea>
                            </div>
                            <button type="submit" class="btn-primary-custom w-100">
                                <i
                                    class="fas fa-paper-plane {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>{{ $__['send_message'] }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <h2 style="color: #fff;">{{ $__['contact_us'] }}</h2>
                <p style="color: rgba(255,255,255,0.8);">{{ $__['contact_subtitle'] }}</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card">
                        <div class="icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>{{ $__['address'] }}</h5>
                        <p>{{ $__['address_line1'] }}<br>{{ $__['address_line2'] }}<br>{{ $__['address_line3'] }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card">
                        <div class="icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <h5>{{ $__['phone'] }}</h5>
                        <p><a href="tel:+1234567890">+1 234 567 890</a><br><a href="tel:+1234567891">+1 234 567
                                891</a></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="contact-card">
                        <div class="icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>{{ $__['email'] }}</h5>
                        <p><a href="mailto:info@doctorssyndicate.org">info@doctorssyndicate.org</a><br><a
                                href="mailto:support@doctorssyndicate.org">support@doctorssyndicate.org</a></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="contact-card">
                        <div class="icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h5>{{ $__['follow_us'] }}</h5>
                        <div class="social-links-footer justify-content-center mt-3">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section">
        <div class="container">
            <div class="section-title text-center" data-aos="fade-up">
                <h2>{{ $__['partners'] }}</h2>
                <p>{{ $__['partners_subtitle'] }}</p>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-6 col-md-3" data-aos="fade-up">
                    <div class="partner-logo">
                        <img src="https://via.placeholder.com/150x60?text=Partner+1" alt="Partner">
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="partner-logo">
                        <img src="https://via.placeholder.com/150x60?text=Partner+2" alt="Partner">
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="partner-logo">
                        <img src="https://via.placeholder.com/150x60?text=Partner+3" alt="Partner">
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="partner-logo">
                        <img src="https://via.placeholder.com/150x60?text=Partner+4" alt="Partner">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-widget">
                        <div class="footer-logo d-flex align-items-center mb-3">
                            <i class="fas fa-staff-snake fa-2x text-primary {{ $isRtl ? 'ms-2' : 'me-2' }}"></i>
                            <span class="text-white fs-4 fw-bold">{{ $__['site_name'] }}</span>
                        </div>
                        <p>{{ $__['footer_desc'] }}</p>
                        <div class="social-links-footer">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <h5>{{ $__['quick_links'] }}</h5>
                        <ul class="footer-links">
                            <li><a href="/"><i class="fas fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                    {{ $__['home'] }}</a></li>
                            <li><a href="#about"><i class="fas fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                    {{ $__['about'] }}</a></li>
                            <li><a href="#services"><i class="fas fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                    {{ $__['services'] }}</a></li>
                            <li><a href="#news"><i class="fas fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                    {{ $__['news'] }}</a></li>
                            <li><a href="#contact"><i class="fas fa-chevron-{{ $isRtl ? 'left' : 'right' }}"></i>
                                    {{ $__['contact'] }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>{{ $__['contact_info'] }}</h5>
                        <ul class="footer-links footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $__['address_line1'] }}, {{ $__['address_line2'] }},
                                    {{ $__['address_line3'] }}</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>+1 234 567 890<br>+1 234 567 891</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>info@doctorssyndicate.org</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget">
                        <h5>{{ $__['mobile_app'] }}</h5>
                        <p>{{ $__['app_desc'] }}</p>
                        <div class="app-badges">
                            <a href="#">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/200px-Google_Play_Store_badge_EN.svg.png"
                                    alt="Google Play">
                            </a>
                            <a href="#">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3c/Download_on_the_App_Store_Badge.svg/200px-Download_on_the_App_Store_Badge.svg.png"
                                    alt="App Store">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p>&copy; {{ date('Y') }} {{ $__['site_name'] }}. {{ $__['copyright'] }}</p>
                    </div>
                    <div class="col-md-6 {{ $isRtl ? 'text-md-start' : 'text-md-end' }}">
                        <p><a href="#">{{ $__['privacy_policy'] }}</a> | <a
                                href="#">{{ $__['terms'] }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <div class="scroll-top" id="scrollTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS Animation -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Theme Toggle Functionality
        (function() {
            const themeToggle = document.getElementById('themeToggle');
            const themeToggleNav = document.getElementById('themeToggleNav');
            const themeToggleMobile = document.getElementById('themeToggleMobile');
            const html = document.documentElement;
            
            // Check for saved theme preference or default to light
            const savedTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', savedTheme);
            
            // Function to toggle theme
            function toggleTheme() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            }
            
            // Add click event listeners to all theme toggle buttons
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }
            if (themeToggleNav) {
                themeToggleNav.addEventListener('click', toggleTheme);
            }
            if (themeToggleMobile) {
                themeToggleMobile.addEventListener('click', toggleTheme);
            }
            
            // Check system preference on load
            if (!localStorage.getItem('theme')) {
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (prefersDark) {
                    html.setAttribute('data-theme', 'dark');
                }
            }
        })();

        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }

            // Scroll to top button
            const scrollTop = document.getElementById('scrollTop');
            if (window.scrollY > 300) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });

        // Scroll to top functionality
        document.getElementById('scrollTop').addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
