<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\City;
use App\Models\Category;

class ProjectController extends Controller {
    public function index(Request $request) {
        $query = Project::query();
    
        // Apply filters only if parameters are present
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
    
        if ($request->filled('project_type')) {
            $query->whereHas('projectTypes', function ($q) use ($request) {
                $q->whereIn('name', explode(',', $request->project_type));
            });
        }
    
        if ($request->filled('city')) {
            $query->whereHas('cities', function ($q) use ($request) {
                $q->whereIn('name', explode(',', $request->city));
            });
        }
    
        if ($request->filled('project_category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->whereIn('name', explode(',', $request->project_category));
            });
        }
    
        // Check if any filters were applied; if not, return all projects
        if (!$request->hasAny(['search', 'project_type', 'city', 'project_category'])) {
            return response()->json(Project::paginate(5)); // Default to all projects
        }
    
        return response()->json($query->paginate(5));
    }
    

    public function getProjectTypes() {
        return response()->json(ProjectType::all());
    }

    public function getCities() {
        return response()->json(City::all());
    }

    public function getCategories() {
        return response()->json(Category::all());
    }

    public function create()
    {
        $cities = City::all();
        $categories = Category::all();
        $projectTypes = ProjectType::all();

        return view('create', compact('cities', 'categories', 'projectTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'cities' => 'required|array',
            'categories' => 'required|array',
            'project_types' => 'required|array',
        ]);


        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Attach cities, categories, and project types
        $project->cities()->attach($request->cities);
        $project->categories()->attach($request->categories);
        $project->projectTypes()->attach($request->project_types);

        return redirect()->route('projects.create')->with('success', 'Project created successfully!');
    }

}
