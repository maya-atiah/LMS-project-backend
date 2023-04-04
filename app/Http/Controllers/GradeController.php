<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

use App\Models\userlms;
use App\Models\course;
use App\Models\grade;
use App\Models\section;
use App\Models\grade_section;

class GradeController extends Controller
{
    //get grade by id
    public function getGradeById(Request $request, $id)
    {
        $grade = grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found.'], 404);
        }
        return grade::with('sections')->find($id);
    }

    //get all grades
    public function getGrade($sectionId = null)
    {
        $grades = grade::all();

        if (!$grades) {
            return response()->json(['message' => 'Grade not found.'], 404);
        }
        

        if ($sectionId) {
            $grades = section::findOrFail($sectionId)->grades()->with('sections')->get();
        } else {
            $grades = grade::with('sections')->get();
        }
        return $grades;
    }


    //add new grade
    public function addGrade(Request $request){
    $request->validate([
        'name' => 'required',
        'sectionIds' => 'array', // Ensure section IDs are provided in an array format
        'sectionIds.*' => 'exists:sections,id', // Ensure each section ID exists in the sections table
        'capacity' => 'integer|nullable', // Add a capacity field that is optional and must be an integer
    ]);

    // Check if a grade with the given name already exists
    $grade = grade::where('name', $request->input('name'))->first();

    if ($grade) {
        // If the grade already exists, attach the new sections to it
        $grade->sections()->attach($request->input('sectionIds'), ['capacity' => $request->input('capacity')]);
    } else {
        // If the grade does not exist, create a new grade with the provided sections
        $grade = grade::create($request->only('name'));
        $grade->sections()->attach($request->input('sectionIds'), ['capacity' => $request->input('capacity')]);
    }
    // return $grade;
        // Fetch the sections for the grade
        $sections = $grade->sections;

        return [
            'grade' => $grade,
            'sections' => $sections
        ];
}


    //delete grade
    public function deleteGrade(Request $request, $id)
    {
        $grade = grade::find($id);
        if (!$grade) {
            return response()->json(['message' => 'Grade not found.'], 404);
        }
        $grade->delete();

        return response()->json([
            'message' => 'DONE! User deleted'
        ]);

    }

    // update grade
    public function updateGrade(Request $request, $id)
    {
       
        $grade = grade::find($id);

        if (!$grade) {
            return response()->json([
                'message' => 'grade not found',
            ], 404);
        }

        $grade->update($request->all());

        return response()->json([
            'message' => 'grade updated successfully',]);
    }
    
      ////*****Adding a new section grade with a pre saved grade and section */

    public function newGradesection (Request $request,$gradeId,$sectionId ){

        $grade=grade::find($gradeId);
        $grade->sections()->attach($sectionId,['capacity'=>$request->input('capacity')]);
        return $grade;
    }
}
