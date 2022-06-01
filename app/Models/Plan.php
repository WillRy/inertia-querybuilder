<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class Plan extends Model
{
    use HasFactory;

    protected $table = "plans";

    protected $primaryKey = "id";

    protected $fillable = [
        "name",
        "duration",
        "price",
        "tenant_id"
    ];

    public function searchPlans($filters = [])
    {
        $query = DB::table("plans");
        if(!empty($filters["search"])) {
            $query
                ->where("name", 'like', "%{$filters['search']}%")
                ->orWhere("price", 'like', "%{$filters['search']}%");
        }
        return $query->where("tenant_id",'=', Auth::user()->tenant_id)->paginate(10);
    }

    public function createPlan(array $data)
    {
        $data["tenant_id"] = Auth::user()->tenant_id;
        DB::table("plans")->insert($data);
        return $this->getByID(DB::getPdo()->lastInsertId());
    }

    public function updatePlan(int $id, array $data)
    {
        DB::table("plans")->where([
            "id" => $id,
            "tenant_id" => Auth::user()->tenant_id
        ])->update($data);
        return $this->getByID($id);
    }

    public function deletePlan(int $id)
    {
        return DB::table("plans")->where([
            "id" => $id,
            "tenant_id" => Auth::user()->tenant_id
        ])->delete();
    }

    public function getByID($id)
    {
        return DB::table("plans")->where([
            "id" => $id,
            "tenant_id" => Auth::user()->tenant_id
        ])->first();
    }

}
