<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Scholarship;
use App\Models\University;
use Illuminate\Database\Seeder;

/**
 * Scholarships checked against their official pages.
 *
 * Run on the server after each update:  php artisan db:seed --class=ScholarshipsSeeder
 *
 * - Verified entries are created or updated by title. Their visibility (is_active) is only set
 *   when they are first created, so a scholarship hidden from the admin panel stays hidden.
 * - Draft entries hold leads that could NOT be verified on an official page. They are created
 *   hidden (inactive) and never overwritten: check the official page, correct the text in the
 *   admin panel, then tick "Active Scholarship" to publish.
 * - Closed scholarships (deadline passed) are hidden from the public pages automatically.
 */
class ScholarshipsSeeder extends Seeder
{
    /** Sample entries from the first version of the site (not real, current data). */
    private const SAMPLE_TITLES = [
        'KNB Scholarship',
        'Darmasiswa Scholarship',
        'UIN Salatiga International Student Scholarship',
    ];

    public function run(): void
    {
        $indonesia = Country::firstOrCreate(['code' => 'ID'], ['name' => 'Indonesia']);

        Scholarship::whereIn('title', self::SAMPLE_TITLES)->update(['is_active' => false]);

        foreach ($this->verified() as $entry) {
            $this->save($indonesia, $entry, draft: false);
        }

        foreach ($this->drafts() as $entry) {
            $this->save($indonesia, $entry, draft: true);
        }
    }

    private function save(Country $country, array $entry, bool $draft): void
    {
        $universityId = null;

        if (isset($entry['university'])) {
            $universityId = University::firstOrCreate(
                ['name' => $entry['university']['name']],
                [
                    'country_id' => $country->id,
                    'city' => $entry['university']['city'],
                    'website' => $entry['university']['website'],
                ]
            )->id;
        }

        $scholarship = Scholarship::firstOrNew(['title' => $entry['title']]);

        if ($draft && $scholarship->exists) {
            return; // keep the consultant's corrections
        }

        $isNew = ! $scholarship->exists;

        $scholarship->fill(collect($entry)->except(['university', 'active'])->all() + [
            'country_id' => $country->id,
            'university_id' => $universityId,
        ]);

        if ($isNew) {
            $scholarship->is_active = $draft ? false : ($entry['active'] ?? true);
        }

        $scholarship->save();
    }

    /**
     * Checked on the official pages on 2026-11-22.
     * Rule: a scholarship is published only when it is open, or opens within 30 days.
     */
    private function verified(): array
    {
        return [
            [
                'title' => 'UIII Admissions & Scholarships 2027',
                'title_ar' => 'القبول والمنح في الجامعة الإسلامية الدولية الإندونيسية (UIII) 2027',
                'university' => ['name' => 'Universitas Islam Internasional Indonesia (UIII)', 'city' => 'Depok', 'website' => 'https://www.uiii.ac.id'],
                'degree' => 'Master, PhD',
                'funding_type' => 'Tuition + Living Allowance',
                'open_date' => '2026-09-23',
                'deadline' => '2027-03-31',
                'official_link' => 'https://admissions.uiii.ac.id/',
                'source_link' => 'https://uiii.ac.id/faq/',
                'description' => "Universitas Islam Internasional Indonesia (UIII, Depok) is open for applications until 31 March 2027.\n\nScholarships: UIII Scholarship (master's, 4 semesters), INSANI–UIII (target countries include Yemen, Sudan and Syria), PhD LPDP–UIII and PEMRI–UIII. According to UIII, its scholarships cover tuition, living expenses and other allowances. UIII's housing page states that scholarship holders receive a monthly stipend of IDR 5,000,000, from which the dormitory fee of IDR 1,000,000 is deducted (confirm the 2027 amounts with UIII). A UIII scholarship holder may not receive any other funding.\n\nHow to apply:\n1. Apply for admission on the official portal before 31 March 2027 (fee USD 50).\n2. Selection: document check, desk review and interview (January–April 2027).\n3. After the Letter of Acceptance (19–22 April 2027), submit the scholarship application during 22–29 April 2027.\n4. Results: 30 April 2027.",
                'description_ar' => "تستقبل الجامعة الإسلامية الدولية الإندونيسية (UIII) في ديبوك طلبات الالتحاق حتى 31 مارس 2027.\n\nالمنح المتاحة: منحة UIII للماجستير (4 فصول دراسية)، ومنحة INSANI–UIII (من الدول المستهدفة: اليمن والسودان وسوريا)، ومنحة الدكتوراه LPDP–UIII، ومنحة PEMRI–UIII. حسب الجامعة، تغطي منحها الرسوم الدراسية ونفقات المعيشة وبدلات أخرى. وتذكر صفحة السكن في الجامعة أن الحاصل على المنحة يتقاضى راتباً شهرياً قدره 5,000,000 روبية، يُخصم منه 1,000,000 روبية رسوم السكن الجامعي (يُرجى تأكيد مبالغ 2027 مع الجامعة). لا يحق للحاصل على منحة UIII الحصول على أي تمويل آخر.\n\nخطوات التقديم:\n1. قدّم طلب الالتحاق عبر البوابة الرسمية قبل 31 مارس 2027 (رسوم التقديم 50 دولاراً).\n2. مراحل الاختيار: مراجعة الأوراق، والتقييم، والمقابلة (من يناير إلى أبريل 2027).\n3. بعد صدور خطاب القبول (19–22 أبريل 2027)، قدّم طلب المنحة في الفترة من 22 إلى 29 أبريل 2027.\n4. إعلان النتائج: 30 أبريل 2027.",
                'eligibility' => "Master's: GPA at least 3.00/4.00; English: IELTS 6.0, TOEFL iBT 80, PTE 58 or TOEFL ITP 525 (Law: IELTS 6.5 / ITP 550). UIII Master's Scholarship: maximum age 35; not for applicants who already hold or are enrolled in a master's degree; all master's programmes except executive classes.\nPhD: GPA at least 3.50/4.00; English: IELTS 6.5, TOEFL ITP 550 or PTE 65.\nOnly applicants who meet the English requirement can apply for a scholarship. Language certificates must be no more than 2 years old. Apply only through the official portal (applications by email are not accepted).",
                'eligibility_ar' => "الماجستير: معدل 3.00 من 4.00 على الأقل؛ اللغة الإنجليزية: IELTS 6.0 أو TOEFL iBT 80 أو PTE 58 أو TOEFL ITP 525 (القانون: IELTS 6.5 أو ITP 550). منحة UIII للماجستير: العمر 35 سنة كحد أقصى، ولا تُمنح لمن يحمل الماجستير أو يدرسه حالياً، وتشمل كل برامج الماجستير ما عدا الفصول التنفيذية.\nالدكتوراه: معدل 3.50 من 4.00 على الأقل؛ IELTS 6.5 أو TOEFL ITP 550 أو PTE 65.\nلا يحق التقديم على المنحة إلا لمن يحقق شرط اللغة الإنجليزية، ويجب ألا يزيد عمر شهادة اللغة عن سنتين. التقديم فقط عبر البوابة الرسمية (لا تُقبل الطلبات بالبريد الإلكتروني).",
                'required_documents' => "English certificate (no more than 2 years old); CV (table format); contacts of two academic referees; motivation letter; bachelor's degree from an accredited institution and GPA certificate (with Scholaro GPA conversion if the scale is not 4.00); passport copy and photo (required for the Turath programme). PhD also: brief research proposal and two academic writing samples.",
                'required_documents_ar' => "شهادة اللغة الإنجليزية (لا يزيد عمرها عن سنتين)؛ السيرة الذاتية (على شكل جدول)؛ بيانات تواصل اثنين من المرجعيات الأكاديمية؛ رسالة الدافع؛ شهادة البكالوريوس من جامعة معتمدة وكشف المعدل (مع تحويل المعدل عبر موقع Scholaro إذا لم يكن من 4.00)؛ صورة جواز السفر وصورة شخصية (مطلوبة لبرنامج التراث). للدكتوراه أيضاً: مقترح بحثي مختصر ونموذجان من الكتابة الأكاديمية.",
            ],
            [
                'title' => 'KNB Scholarship 2027',
                'title_ar' => 'منحة KNB 2027',
                'active' => false, // hidden until the 2027 call is announced (publish when open or opening within 30 days)
                'degree' => 'Bachelor, Master, PhD',
                'funding_type' => null, // to confirm from the 2027 guide
                'open_date' => null,
                'deadline' => null, // 2027 call not announced yet
                'official_link' => 'https://knb.kemdiktisaintek.go.id/',
                'source_link' => 'https://knb.kemdiktisaintek.go.id/',
                'description' => "Indonesian Government scholarship for students from developing countries (bachelor's, master's and doctoral study at 47 partner universities). The 2027 call has not been announced yet on the official portal (checked 22 November 2026). In the last cycle, applications ran from 2 February to 31 March 2026.",
                'description_ar' => "منحة من الحكومة الإندونيسية لطلاب الدول النامية (بكالوريوس وماجستير ودكتوراه في 47 جامعة شريكة). لم يُعلن عن دورة 2027 بعد في البوابة الرسمية (تم التحقق في 22 نوفمبر 2026). في الدورة الماضية كان التقديم من 2 فبراير إلى 31 مارس 2026.",
                'eligibility' => "Based on the 2026 rules (may change for 2027): bachelor's applicants at most 21 years old; English: TOEFL ITP 477, TOEFL iBT 53, IELTS 5.5 or TOEIC 510 (certificate from the last 2 years; not required for English-speaking countries); recommendation letter from the Indonesian Embassy in the applicant's country of origin; a bachelor's degree holder cannot apply for the bachelor's scholarship.",
                'eligibility_ar' => "حسب شروط دورة 2026 (قد تتغير في 2027): عمر المتقدم للبكالوريوس 21 سنة كحد أقصى؛ اللغة الإنجليزية: TOEFL ITP 477 أو TOEFL iBT 53 أو IELTS 5.5 أو TOEIC 510 (شهادة خلال آخر سنتين، ولا تُطلب من الدول الناطقة بالإنجليزية)؛ خطاب توصية من السفارة الإندونيسية في بلد المتقدم الأصلي؛ لا يحق لحامل البكالوريوس التقديم على منحة البكالوريوس.",
                'required_documents' => "Based on the 2026 rules: official passport (in 2026 it had to be valid until at least 31 December 2027); English proficiency certificate; Indonesian Embassy recommendation letter; academic certificate and transcript legalized by the Ministries of Education and Foreign Affairs; certified medical report issued within the last 3 months; statement of purpose (doctoral applicants).",
                'required_documents_ar' => "حسب شروط دورة 2026: جواز سفر رسمي (في 2026 كان يجب أن يكون سارياً حتى 31 ديسمبر 2027 على الأقل)؛ شهادة اللغة الإنجليزية؛ خطاب توصية من السفارة الإندونيسية؛ الشهادة وكشف الدرجات مصدّقان من وزارتي التعليم والخارجية؛ تقرير طبي معتمد صادر خلال آخر 3 أشهر؛ بيان الغرض من الدراسة (للدكتوراه).",
            ],
        ];
    }

    /** Leads from unofficial sites: NOT verified. Created hidden. */
    private function drafts(): array
    {
        return [
            [
                'title' => 'UIN Malang International Student Scholarship (ISS) 2027',
                'title_ar' => 'منحة جامعة مولانا مالك إبراهيم مالانج للطلاب الدوليين (ISS) 2027',
                'university' => ['name' => 'UIN Maulana Malik Ibrahim Malang', 'city' => 'Malang', 'website' => 'https://uin-malang.ac.id'],
                'degree' => 'Bachelor, Master, PhD',
                'funding_type' => null,
                'open_date' => null,
                'deadline' => '2026-11-30',
                'official_link' => 'https://uin-malang.ac.id/',
                'source_link' => null,
                'description' => "[DRAFT – NOT VERIFIED] Unofficial sites report that the 2027 call closes on 30 November 2026 and covers tuition and dormitory. Check the official UIN Malang page, correct this text and the deadline, then activate.",
                'description_ar' => "[مسودة – غير متحقق] تذكر مواقع غير رسمية أن التقديم لدورة 2027 ينتهي في 30 نوفمبر 2026 وأن المنحة تغطي الرسوم والسكن. تحقق من صفحة الجامعة الرسمية، وصحّح هذا النص وآخر موعد، ثم فعّل المنحة.",
            ],
            [
                'title' => 'UMY International Student Scholarship 2027/2028',
                'title_ar' => 'منحة جامعة محمدية يوجياكرتا (UMY) للطلاب الدوليين 2027/2028',
                'university' => ['name' => 'Universitas Muhammadiyah Yogyakarta (UMY)', 'city' => 'Yogyakarta', 'website' => 'https://www.umy.ac.id'],
                'degree' => 'Bachelor, Master, PhD',
                'funding_type' => null,
                'open_date' => null,
                'deadline' => '2026-12-31',
                'official_link' => 'https://internationaladmissions.umy.ac.id/foreign-student/fulltime/scholarship',
                'source_link' => null,
                'description' => "[DRAFT – NOT VERIFIED] Unofficial sites report four application batches for the 2027/2028 intake, with Batch 2 open until 31 December 2026, and several scholarship levels (Full, Partial Plus, Partial). Check the official UMY page, correct this text, the deadline and the coverage, then activate.",
                'description_ar' => "[مسودة – غير متحقق] تذكر مواقع غير رسمية أن التقديم لدفعة 2027/2028 على أربع مراحل، والمرحلة الثانية مفتوحة حتى 31 ديسمبر 2026، مع عدة مستويات للمنحة (كاملة، جزئية بلس، جزئية). تحقق من صفحة الجامعة الرسمية، وصحّح النص وآخر موعد والتغطية، ثم فعّل المنحة.",
            ],
        ];
    }
}
