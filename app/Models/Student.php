<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $primaryKey = "id";

    protected $fillable = [
        "name",
        "email",
        "date_birth",
        "weight",
        "height",
        "gender",
        "tenant_id"
    ];


    public function searchStudents($filters = [])
    {
        $query = DB::table("students AS st");

        if (!empty($filters["search"])) {
            $query
                ->where("name", 'like', "%{$filters['search']}%")
                ->orWhere("email", 'like', "%{$filters['search']}%");
        }

        if (!empty($filters["gender"])) {
            $query->where("gender", '=', $filters['gender']);
        }

        return $query
            ->where("tenant_id", "=", Auth::user()->tenant_id)
            ->orderBy($filters["sortName"], $filters["sortOrder"])
            ->paginate(10);
    }

    public function search($filters = [])
    {
        $query = DB::table("students AS st");

        if (!empty($filters["search"])) {
            $query->where("name", 'like', "%{$filters['search']}%");
        }

        return $query
            ->where("tenant_id", "=", Auth::user()->tenant_id)
            ->paginate(10);
    }

    public function totais()
    {
        $totais = [];

        $totais["qtd"] = DB::table("students")
            ->where("tenant_id", "=", Auth::user()->tenant_id)
            ->count();

        $totais["m"] = DB::table("students")
            ->where([
                'tenant_id' => Auth::user()->tenant_id,
                'gender' => 'm'
            ])
            ->count();

        $totais["f"] = DB::table("students")
            ->where([
                'tenant_id' => Auth::user()->tenant_id,
                'gender' => 'f'
            ])
            ->count();

        $totais["o"] = DB::table("students")
            ->where([
                'tenant_id' => Auth::user()->tenant_id,
                'gender' => 'o'
            ])
            ->count();

        return $totais;
    }

    public function getByID($id)
    {
        return DB::table("students")
            ->where([
                "id" => $id,
                "tenant_id" => Auth::user()->tenant_id
            ])->first();
    }

    public function createStudent(array $data)
    {
        $data["tenant_id"] = Auth::user()->tenant_id;
        DB::table("students")->insert($data);
        return $this->getByID(DB::getPdo()->lastInsertId());
    }

    public function updateStudent(int $id, array $data)
    {
        return DB::table("students")
            ->where([
                "id" => $id,
                "tenant_id" => Auth::user()->tenant_id
            ])
            ->update($data);
    }

    public function deleteStudent(int $id)
    {
        return DB::table("students")
            ->where([
                "id" => $id,
                "tenant_id" => Auth::user()->tenant_id
            ])
            ->delete();
    }
}
