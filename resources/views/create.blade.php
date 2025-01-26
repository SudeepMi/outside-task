@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Create New Project</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('projects.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            
            <!-- Project Title -->
            <div class="form-group">
                <label for="title" class="block font-semibold">Project Title</label>
                <input type="text" id="title" name="title" class="w-full border-gray-300 rounded-lg p-2" value="{{ old('title') }}" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Project Description -->
            <div class="form-group">
                <label for="description" class="block font-semibold">Project Description</label>
                <textarea id="description" name="description" class="w-full border-gray-300 rounded-lg p-2" rows="4" required>{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Select Cities (Checkboxes) -->
            <div class="form-group">
                <label class="block font-semibold">Cities</label>
                <div class="space-y-2 flex gap-4 items-center">
                    @foreach($cities as $city)
                        <div class="flex items-center">
                            <input type="checkbox" id="city_{{ $city->id }}" name="cities[]" value="{{ $city->id }}" 
                                {{ in_array($city->id, old('cities', [])) ? 'checked' : '' }} class="mr-1">
                            <label for="city_{{ $city->id }}" class="text-sm cursor-pointer">{{ $city->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('cities')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Select Categories (Checkboxes) -->
            <div class="form-group">
                <label class="block font-semibold">Categories</label>
                <div class="space-y-2 flex gap-4 items-center">
                    @foreach($categories as $category)
                        <div class="flex items-center">
                            <input type="checkbox" id="category_{{ $category->id }}" name="categories[]" value="{{ $category->id }}" 
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }} class="mr-1">
                            <label for="category_{{ $category->id }}" class="text-sm cursor-pointer">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('categories')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Select Project Types (Checkboxes) -->
            <div class="form-group">
                <label class="block font-semibold">Project Types</label>
                <div class="space-y-2 flex gap-4 items-center">
                    @foreach($projectTypes as $projectType)
                        <div class="flex items-center">
                            <input type="checkbox" id="project_type_{{ $projectType->id }}" name="project_types[]" value="{{ $projectType->id }}" 
                                {{ in_array($projectType->id, old('project_types', [])) ? 'checked' : '' }} class="mr-2">
                            <label for="project_type_{{ $projectType->id }}" class="text-sm cursor-pointer">{{ $projectType->name }}</label>
                        </div>
                    @endforeach
                </div>
                @error('project_types')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-700">Create Project</button>
            </div>
        </div>
    </form>
</div>
@endsection
