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

    /** Checked on the official pages on 2026-11-22. */
    private function verified(): array
    {
        return [
            [
                'title' => 'UIII Admissions & Scholarships 2027',
                'title_ar' => 'القبول والمنح في الجامعة الإسلامية الدولية الإندونيسية (UIII) 2027',
                'university' => ['name' => 'Universitas Islam Internasional Indonesia (UIII)', 'city' => 'Depok', 'website' => 'https://www.uiii.ac.id'],
                'degree' => 'Master, PhD',
                'funding_type' => null, // coverage is not stated on the admissions page
                'open_date' => '2026-09-23',
                'deadline' => '2027-03-31',
                'official_link' => 'https://admissions.uiii.ac.id/',
                'source_link' => 'https://admissions.uiii.ac.id/',
                'description' => "Universitas Islam Internasional Indonesia (UIII, Depok) is open for applications (Admissions 2026/2027) until 31 March 2027. After receiving the Letter of Acceptance, admitted students apply for a scholarship during 22–29 April 2027: UIII Scholarship (master's), PhD LPDP–UIII, and INSANI–UIII (target countries include Yemen, Sudan and Syria). Scholarship coverage is not stated on the admissions page — confirm with UIII.",
                'description_ar' => "تستقبل الجامعة الإسلامية الدولية الإندونيسية (UIII) في ديبوك طلبات الالتحاق حتى 31 مارس 2027. بعد الحصول على خطاب القبول، يقدّم الطالب على المنحة في الفترة من 22 إلى 29 أبريل 2027: منحة UIII للماجستير، ومنحة الدكتوراه LPDP–UIII، ومنحة INSANI–UIII (من الدول المستهدفة: اليمن والسودان وسوريا). تفاصيل ما تغطيه المنحة غير مذكورة في صفحة القبول ويجب تأكيدها مع الجامعة.",
                'eligibility' => "Master's: GPA at least 3.00/4.00; English: IELTS 6.0, TOEFL iBT 80 or TOEFL ITP 525 (Law: IELTS 6.5 / ITP 550); TOAFL 550 is also listed. UIII Master's Scholarship: maximum age 35; not for applicants who already hold or are enrolled in a master's degree.\nPhD: GPA at least 3.50/4.00; English: IELTS 6.5, TOEFL iBT 94 or TOEFL ITP 550.\nOnly applicants who meet the English requirement can apply for the scholarship. Application fee: USD 50. Apply only through the official portal.",
                'eligibility_ar' => "الماجستير: معدل 3.00 من 4.00 على الأقل؛ اللغة الإنجليزية: IELTS 6.0 أو TOEFL iBT 80 أو TOEFL ITP 525 (القانون: IELTS 6.5 أو ITP 550)، ومذكور أيضاً اختبار TOAFL 550. منحة UIII للماجستير: العمر 35 سنة كحد أقصى، ولا تُمنح لمن يحمل الماجستير أو يدرسه حالياً.\nالدكتوراه: معدل 3.50 من 4.00 على الأقل؛ IELTS 6.5 أو TOEFL iBT 94 أو TOEFL ITP 550.\nلا يحق التقديم على المنحة إلا لمن يحقق شرط اللغة الإنجليزية. رسوم التقديم: 50 دولاراً. التقديم فقط عبر البوابة الرسمية.",
                'required_documents' => "English certificate (no more than 2 years old); CV; contacts of two academic referees; motivation letter; bachelor's degree and GPA certificate (with Scholaro GPA conversion if the scale is not 4.00). PhD also: research proposal and two academic writing samples.",
                'required_documents_ar' => "شهادة اللغة الإنجليزية (لا يزيد عمرها عن سنتين)؛ السيرة الذاتية؛ بيانات تواصل اثنين من المرجعيات الأكاديمية؛ رسالة الدافع؛ شهادة البكالوريوس وكشف المعدل (مع تحويل المعدل عبر موقع Scholaro إذا لم يكن من 4.00). للدكتوراه أيضاً: مقترح بحثي ونموذجان من الكتابة الأكاديمية.",
            ],
            [
                'title' => 'KNB Scholarship 2027',
                'title_ar' => 'منحة KNB 2027',
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
