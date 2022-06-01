<?php

namespace App\Http\Controllers;


use App\Http\Requests\StudentStoreUpdateRequest;
use App\Models\Plan;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StudentController extends Controller
{
    public function index(Request $request)
    {

        $filters = [
            "gender" => $request->input("gender"),
            "search" => $request->input("search")
        ];

//        $students = (new Student())->searchStudents($filters);

        return Inertia::render("Students/Index", [
            'total' => fn() => (new Student())->totais(), //carrega a primeira vez e sempre que solicitado
            'students' => fn() => (new Student())->searchStudents($filters),//carrega a primeira vez e sempre que solicitado
            "filters" => $filters,
            "page" => $request->input("page", 1)
        ]);
    }

    public function list(Request $request)
    {
        $filters = ["search" => $request->input("search")];
        $students = (new Student())->searchStudents($filters);
        return response()->json($students);
    }

    public function store(StudentStoreUpdateRequest $request)
    {
        try {
            $student = (new Student())->createStudent($request->all());

            return redirect()->back()->with([
                "data" => $student,
                "success" => "Aluno criado com sucesso!"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                "error" => $e->getMessage()
            ])->withErrors([]);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $student = (new Student())->getByID($id);

            if (empty($student)) {
                return response()->json([
                    "error" => "Not found"
                ], 404);
            }

            return response()->json([
                "data" => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function update(StudentStoreUpdateRequest $request, $id)
    {
        try {
            $student = (new Student())->getByID($id);

            if (empty($student)) {
                return response()->json([
                    "error" => "Not found"
                ], 404);
            }

            (new Student())->updateStudent($id, $request->all());


            return redirect()->back()->with([
                "data" => $student,
                "success" => "Aluno editado com sucesso!"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with([
                "error" => $e->getMessage()
            ])->withErrors([]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $student = (new Student())->getByID($id);

            if (empty($student)) {
                return response()->json([
                    "error" => "Not found"
                ], 404);
            }

            (new Student())->deleteStudent($id);


            return redirect()->back()->with([
                "success" => "Aluno excluido com sucesso"
            ]);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with(["error" => $e->getMessage()])
                ->withErrors([]);
        }
    }

}
