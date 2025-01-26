@extends('layouts.app')

@section('content')

    <div id="app" class="max-w-4xl mx-auto bg-white shadow-md p-6 rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Projects</h1>

        <!-- Search Bar -->
        <input type="text" v-model="search" placeholder="Search projects by title..." 
            class="w-full px-4 py-2 border rounded-md focus:ring focus:ring-blue-300"
            @input="fetchProjects()">

        <!-- Filters -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <label class="block text-sm font-semibold">Project Type</label>
                <div>
                <label v-for="city in projectTypes" :key="city.id" class="flex items-center">
                        <input type="checkbox" v-model="selectedProjectTypes" :value="city.name" 
                            class="mr-2" @change="fetchProjects">
                        @{{ city.name }}
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold">City</label>
                <div>
                    <label v-for="city in cities" :key="city.id" class="flex items-center">
                        <input type="checkbox" v-model="selectedCities" :value="city.name" 
                            class="mr-2" @change="fetchProjects">
                        @{{ city.name }}
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold">Project Category</label>
                <div>
                    <label v-for="category in categories" :key="category.id" class="flex items-center">
                        <input type="checkbox" v-model="selectedCategories" :value="category.name" 
                            class="mr-2" @change="fetchProjects">
                        @{{ category.name }}
                    </label>
                </div>
            </div>
        </div>

        <!-- Clear Filters Button -->
        <button @click="clearFilters()" 
            class="w-full mt-4 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
            Clear Filters
        </button>

        <!-- Projects List -->
        <div v-if="projects.length" class="mt-6">
            <div v-for="project in projects" :key="project.id" class="bg-gray-200 p-4 rounded-lg mb-4">
                <h3 class="text-lg font-semibold">@{{ project.title }}</h3>
                <p class="text-gray-600">@{{ project.description }}</p>
            </div>
        </div>
        <p v-else class="text-gray-500 mt-4">No projects found.</p>

        <!-- Load More Button -->
        <button v-if="hasMore" @click="loadMore()" 
            class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Load More
        </button>
    </div>
@endsection
@section('scripts')
    <script>

        const { createApp } = Vue;
        
        const app = createApp({
            data() {
                return {
                    projects: [],
                    search: '',
                    selectedProjectTypes: [],
                    selectedCities: [],
                    selectedCategories: [],
                    projectTypes: [],
                    cities: [],
                    categories: [],
                    page: 1,
                    hasMore: true
                };
            },
            
            mounted() {
                this.loadFilters();
                this.loadFromURL();
                this.fetchProjects();
            },
            methods: {
                updateURL() {
                    const params = new URLSearchParams({
                        search: this.search,
                        project_type: this.selectedProjectTypes.join(','),
                        city: this.selectedCities.join(','),
                        project_category: this.selectedCategories.join(','),
                        page: this.page
                    }).toString();
                    history.pushState(null, '', '?' + params);
                },
                async fetchProjects() {
                    this.updateURL();
                    const params = new URLSearchParams({
                        search: this.search,
                        project_type: this.selectedProjectTypes.join(','),
                        city: this.selectedCities.join(','),
                        project_category: this.selectedCategories.join(','),
                        page: this.page
                    }).toString();

                    const response = await axios.get(`/api/projects?${params}`);
                    this.projects = response.data.data;
                    this.hasMore = response.data.next_page_url !== null;
                },
                async loadMore() {
                    this.page++;
                    this.updateURL();
                    const params = new URLSearchParams({
                        search: this.search,
                        project_type: this.selectedProjectTypes.join(','),
                        city: this.selectedCities.join(','),
                        project_category: this.selectedCategories.join(','),
                        page: this.page
                    }).toString();

                    const response = await axios.get(`/api/projects?${params}`);
                    this.projects.push(...response.data.data);
                    this.hasMore = response.data.next_page_url !== null;
                },
                async loadFilters() {
                    const res = await axios.get('/api/filters');
                    this.projectTypes = res.data.projectTypes;
                    this.cities = res.data.cities;
                    this.categories = res.data.categories;
                },
                loadFromURL() {
                    const urlParams = new URLSearchParams(window.location.search);
                    this.search = urlParams.get('search') || '';
                    this.selectedProjectTypes = urlParams.get('project_type')?.split(',') || [];
                    this.selectedCities = urlParams.get('city')?.split(',') || [];
                    this.selectedCategories = urlParams.get('project_category')?.split(',') || [];
                },
                clearFilters() {
                    this.search = '';
                    this.selectedProjectTypes = [];
                    this.selectedCities = [];
                    this.selectedCategories = [];
                    this.page = 1;
                    this.fetchProjects();
                }
            }
        }).mount('#app');

    </script>
@endsection
</body>
</html>
