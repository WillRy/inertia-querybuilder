<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanStoreUpdateRequest;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render("Plans/Index");
    }

    public function list(Request $request)
    {
        $filters = [
            "search" => $request->input("search"),
            "sortName" => $request->input("sortName", "id"),
            "sortOrder" => $request->input("sortOrder", "asc")
        ];
        $plans = (new Plan())->searchPlans($filters);
        return response()->json($plans);
    }

    public function store(PlanStoreUpdateRequest $request)
    {
        try {
            $student = (new Plan())->createPlan($request->all());

            return response()->json([
                "data" => $student
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function show(Request $request, $id)
    {
        try {
            $plan = (new Plan())->getByID($id);

            if (empty($plan)) {
                return response()->json([
                    "error" => "Not found"
                ], 404);
            }

            return response()->json([
                "data" => $plan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function update(PlanStoreUpdateRequest $request, $id)
    {
        try {
            $plan = (new Plan())->getByID($id);

            if (empty($plan)) {
                return response()->json([
                    "error" => "Not found"
                ], 404);
            }

            (new Plan())->updatePlan($id, $request->all());


            return response()->json([
                "data" => $plan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $plan = (new Plan())->getByID($id);

            if (empty($plan)) {
                return response()->json([
                    "error" => "Not found"
                ], 404);
            }

            if ((new Subscription())->subscriptionUsedByPlan($id)) {
                return response()->json([
                    "error" => "Plano usado em alguma matrícula"
                ], 422);
            }

            (new Plan())->deletePlan($id);


            return response()->json([], 204);
        } catch (\Exception $e) {
            return response()->json([
                "error" => $e->getMessage()
            ], 500);
        }
    }

}
