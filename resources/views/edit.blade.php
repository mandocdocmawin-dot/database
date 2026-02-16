<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-4 py-10 max-w-2xl">
        <main class="bg-white shadow-md rounded-lg overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-700">Edit Student: {{ $student->first_name }} {{ $student->last_name }}</h1>
            
            <form action="{{ route('students.update', $student->student_id) }}" method="POST" class="space-y-4">
                @csrf
                
                @method('PUT')

                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" 
                           value="{{ $student->first_name }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" 
                           value="{{ $student->last_name }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" 
                           value="{{ $student->email }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="course" class="block text-sm font-medium text-gray-700">Course</label>
                    <input type="text" name="course" id="course" 
                           value="{{ $student->course }}" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2 focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div class="flex items-center justify-end mt-6 space-x-3">
                    <a href="{{ route('students.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150">
                        Update Student
                    </button>
                </div>
            </form>
            
        </main>
    </div>
</body>
</html>