<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $closesAt = now()->addWeeks(3)->toDateString();

        $academicReq = 'Minimum of good second-class degree from a recognized institution of higher '
            .'learning in the relevant field. Evidence of post-secondary school teaching experience is '
            .'an added advantage. Candidates must present evidence of TRCN registration, NYSC discharge '
            .'or exemption certificate, and demonstrate good knowledge of computer use.';

        $academicDepartments = [
            'School of General Education' => ['General Studies', 'Special Needs Education'],
            'School of Secondary Education (Arts and Social Sciences)' => ['Islamic Studies', 'Social Studies', 'Economics'],
            'School of Secondary Education (Science)' => ['Chemistry Education', 'Health Education', 'Integrated Science', 'Environmental Education', 'Human Kinetic Education'],
            'School of Secondary Education (Languages)' => ['Hausa Education', 'English Education'],
            'School of Secondary Education (Vocational)' => ['Home Economics', 'Fine and Applied Arts'],
            'School of Secondary Education (Business)' => ['Office Technology Management (OTM)', 'Marketing Education', 'Entrepreneurship Education'],
            'School of Secondary Education (Technical)' => ['Metal Work Education', 'Wood-Work Education'],
        ];

        foreach ($academicDepartments as $school => $subjects) {
            foreach ($subjects as $subject) {
                Position::create([
                    'title' => "Assistant Lecturer - {$subject}",
                    'grade' => 'CONPCASS 01',
                    'category' => 'academic',
                    'department' => $school,
                    'requirements' => $academicReq,
                    'slots' => 1,
                    'is_open' => true,
                    'closes_at' => $closesAt,
                ]);
            }
        }

        $nonAcademic = [
            ['title' => 'House Officer', 'grade' => 'CONMESS 05', 'department' => 'Medical Doctor', 'req' => 'Good degree in Medicine from a recognized institution plus NYSC discharge or exemption certificate. Cognate work experience and evidence of MDCN membership with current practice license. Good knowledge of computer required.'],
            ['title' => 'Pharmacist', 'grade' => 'CONHESS 08', 'department' => 'Pharmacy', 'req' => 'Good degree in Pharmacy from a recognized institution, registered with PRBN, plus NYSC discharge or exemption certificate. Cognate work experience required.'],
            ['title' => 'Programme Analyst I', 'grade' => 'CONTEDISS 08', 'department' => 'Programme Analyst', 'req' => 'Good honours degree in Computer Science/ICT plus NYSC discharge or exemption certificate. Cognate work experience, membership of a relevant professional body, and excellent understanding of computer programming/web designing.'],
            ['title' => 'Senior Confidential Secretary', 'grade' => 'CONTEDISS 08', 'department' => 'Confidential Secretary', 'req' => 'Good HND in Secretarial Studies/Office Technology Management plus NYSC discharge or exemption certificate. Three (3) years cognate work experience and evidence of professional body membership.'],
            ['title' => 'Nursing Officer', 'grade' => 'CONHESS 07', 'department' => 'Nursing', 'req' => 'Good degree in Nursing Science plus NYSC discharge or exemption certificate. Cognate work experience and evidence of NMCN membership with current practice license. Good knowledge of computer required.'],
            ['title' => 'Administrative Officer II', 'grade' => 'CONTEDISS 07', 'department' => 'Administration', 'req' => 'Good honours degree in Arts or Social Sciences plus NYSC discharge or exemption certificate. Relevant cognate work experience and evidence of professional body membership. Good knowledge of computer required.'],
            ['title' => 'Accountant II', 'grade' => 'CONTEDISS 07', 'department' => 'Accounts', 'req' => 'Good honours degree in Accountancy plus evidence of NYSC discharge or exemption certificate. Registered member of ICAN or ANAN is an added advantage.'],
            ['title' => 'Auditor II', 'grade' => 'CONTEDISS 07', 'department' => 'Audit', 'req' => 'Good honours degree in Accountancy/Finance plus NYSC discharge or exemption certificate. Registered member of ICAN or ANAN is an added advantage.'],
            ['title' => 'Higher Technician', 'grade' => 'CONTEDISS 07', 'department' => 'Technician', 'req' => 'Good HND in Laboratory Science plus NYSC discharge or exemption certificate, or a minimum of three (3) years cognate work experience.'],
            ['title' => 'Scientific Officer II', 'grade' => 'CONTEDISS 07', 'department' => 'Scientific Officer', 'req' => 'Good degree in Natural Sciences plus NYSC discharge or exemption certificate.'],
            ['title' => 'Sport Officer II', 'grade' => 'CONTEDISS 07', 'department' => 'Sport Officer', 'req' => 'Good degree in Physical and Health Education plus NYSC discharge or exemption certificate.'],
            ['title' => 'Library Officer', 'grade' => 'CONTEDISS 06', 'department' => 'Library', 'req' => 'National Diploma (ND) in Library and Information Science plus a minimum of two (2) years cognate work experience. Good knowledge of computer required.'],
            ['title' => 'Executive Officer (Admin)', 'grade' => 'CONTEDISS 06', 'department' => 'Administration', 'req' => 'Good National Diploma (ND) in Business Administration or Public Administration plus at least two (2) years cognate work experience on the grade.'],
            ['title' => 'Secretary Assistant I', 'grade' => 'CONTEDISS 05', 'department' => 'Secretariat', 'req' => 'SSCE/NECO/NABTEB plus a computer/secretarial studies certificate and typing speed of 50 WPM, with at least two (2) years cognate work experience on the grade.'],
            ['title' => 'Senior Health Attendant', 'grade' => 'CONHESS 04', 'department' => 'Health Services', 'req' => 'SSCE/NECO/NABTEB plus a certificate from School of Health Technology or other approved Assistant Health Cadre, or at least two (2) years cognate work experience on the grade.'],
            ['title' => 'Motor Driver/Mechanic II', 'grade' => 'CONTEDISS 03', 'department' => 'Transport', 'req' => 'SSCE/NECO/NABTEB, minimum of two (2) years driving experience, Trade Test I, II and III, and a valid driver\u2019s license.'],
            ['title' => 'Craftsman', 'grade' => 'CONTEDISS 03', 'department' => 'Works', 'req' => 'SSCE/NECO/NABTEB and Trade Test I, II with a minimum of two (2) years cognate work experience.'],
            ['title' => 'Artisan', 'grade' => 'CONTEDISS 03', 'department' => 'Works', 'req' => 'SSCE/NECO/NABTEB and Trade Test I, II with a minimum of two (2) years cognate work experience.'],
        ];

        foreach ($nonAcademic as $p) {
            Position::create([
                'title' => $p['title'],
                'grade' => $p['grade'],
                'category' => 'non_academic',
                'department' => $p['department'],
                'requirements' => $p['req'],
                'slots' => 1,
                'is_open' => true,
                'closes_at' => $closesAt,
            ]);
        }
    }
}
