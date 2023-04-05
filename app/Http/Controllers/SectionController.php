<?php

namespace App\Http\Controllers;

use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    //get all users
    public function getSection(Request $request)
    {
        $sections = section::all();

        if (!$sections) {
            return response()->json(['message' => 'No sections found.'], 404);
        }
        return response()->json([
            'All Sections' => $sections,
        ]);
    }

    //get single section
    public function getSingleSection(Request $request, $id)
    {
         $section = Section::find($id);

        if (!$section) {
            return response()->json(['message' => 'Section not found.'], 404);
        }

        return response()->json([
            'message' => $section,
        ]);
    }

    //add new user(teacher)
    public function addSection(Request $request)
    {
        $section = new section;
        $letter = $request->input('letter');

        $section->letter = $letter;
        $section->save();

        if (!$section) {
            return response()->json([
                'message' => 'Section not found',
            ], 404);
        }

        return response()->json([
            'message' => 'DONE!',
            $section,
        ]);
    }

    //delete user
    public function deleteSection(Request $request, $id)
    {
        $section = section::find($id);
        $section->delete();

        if (!$section) {
            return response()->json([
                'message' => 'Section not found',
            ], 404);
        }
        return response()->json([
            'message' => 'DONE! User deleted',
        ]);
    
    }

    // update user
    public function updateSection(Request $request, $id)
    {
        $section = Section::find($id);

        if (!$section) {
            return response()->json([
                'message' => 'Section not found',
            ], 404);
        }

        $section->update($request->all());

        return response()->json([
            'message' => 'Section updated successfully',
        ]);
    }

    ///grade/section
    public function studentList($gradeId, $sectionId)
    {
        $students = DB::table('userlms')->join('user_grade_sections', 'userlms.id', '=', 'user_grade_sections.student_id')
         ->join('grade_sections', 'user_grade_sections.grade_section_id', '=', 'grade_sections.id')
    ->where('grade_sections.section_id', '=', $sectionId)->where('grade_sections.grade_id', '=', $gradeId)->select('userlms.*')->get();
    
//     if(count($students)==0){
//         return response()->json([
//             'message' => 'No students found',
//         ], 404);
//     }
        return response()->json($students);
    }

    ///jdkshbdjshad
}

